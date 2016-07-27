<?php



namespace Hazzard\Comments\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Hazzard\Comments\Comments\Comment;
use Hazzard\Comments\Jobs\UpdateComment;
use Hazzard\Comments\Jobs\DeleteComment;
use Hazzard\Comments\Http\Middleware\Admin;
use Hazzard\Comments\Jobs\BulkCommentUpdate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Hazzard\Comments\Jobs\FetchCommentsAdmin;
use Hazzard\Comments\Settings\Repository as Settings;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminDashboardController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        app('comments');

        Comment::$admin = true;

        $this->middleware(Admin::class);
    }

    /**
     * List all comments.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $args = [
            'page'   => (int) $request->input('page', 1),
            'status' => $request->input('status', 'all'),
            'pageId' => $request->input('page_id'),
        ];

        if ($request->ajax()) {
            return Response::json($this->dispatch(new FetchCommentsAdmin($args)));
        }

        return view('comments::admin.dashboard', $args);
    }

    /**
     * Display a specified comment.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return Response::json(Comment::findOrFail($id));
    }

    /**
     * Update a specified comment.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id = null)
    {
        if ($ids = $request->input('ids')) {
            return $this->dispatch(new BulkCommentUpdate($ids, $request->input('status')));
        }

        $input = $request->only('author_name', 'author_email', 'author_url', 'content', 'status');
        $input['author_name'] = e($input['author_name']);

        $validator = $this->validateForUpdate($input);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($input as $key => $value) {
                if ($errors->has($key)) {
                    unset($input[$key]);
                }
            }
        }

        $comment = Comment::findOrFail($id);

        $this->dispatch(new UpdateComment($comment, $input));

        return Response::json($comment);
    }

    /**
     * Validate input for update.
     *
     * @param  array $input
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateForUpdate(array $input)
    {
        $rules = [
            'status'       => 'required|in:pending,approved,spam,trash',
            'content'      => 'required|min:2',
            'author_url'   => 'url|max:255',
            'author_name'  => 'required|max:100',
            'author_email' => 'required|email|max:255',
        ];

        if ($max = config('comments.max_length')) {
            $rules['content'] .= "|max:$max";
        }

        return $this->getValidationFactory()->make($input, $rules);
    }

    /**
     * Delete the specified comment.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $this->dispatch(new DeleteComment($id));

        return Response::json(null, 204);
    }
}
