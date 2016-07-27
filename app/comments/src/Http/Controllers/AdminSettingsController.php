<?php



namespace Hazzard\Comments\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Hazzard\Comments\Http\Middleware\Admin;
use Hazzard\Comments\Settings\Repository as Settings;

class AdminSettingsController extends Controller
{
    /**
     * @var \Hazzard\Comments\Settings\Repository
     */
    protected $settings;

    /**
     * Create a new controller instance.
     *
     * @param \Hazzard\Comments\Settings\Repository $settings
     */
    public function __construct(Settings $settings)
    {
        $this->middleware(Admin::class);

        $this->settings = $settings;
    }

    /**
     * Display the settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('comments::admin.settings', [
            'config' => config('comments'),
        ]);
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $input = collect($request->input('settings'))->lists('value', 'name');

        $input = $input->map(function ($value, $key) {
            return is_string($value) ? trim($value) : $value;
        });

        $method = 'update'.ucfirst($input['group']).'Settings';

        if (method_exists($this, $method)) {
            $this->$method($input, $this->settings);
        }

        $this->settings->save();

        return Response::json();
    }

    protected function updateGeneralSettings($input, $settings)
    {
        $settings->set([
            'guest'      => (boolean) $input['guest'],
            'votes'      => (boolean) $input['votes'],
            'replies'    => (boolean) $input['replies'],
            'real_time'  => (boolean) $input['real_time'],
            'per_page'   => $input['per_page'] ? (int) $input['per_page'] : null,
            'max_length' => $input['max_length'] ? (int) $input['max_length'] : null,
            'default_gravatar' => e($input['default_gravatar']),
        ]);

        if (is_numeric($input['edit'])) {
            $settings->set('edit', (int) $input['edit']);
        } else {
            $settings->set('edit', $input['edit'] === 'true');
        }

        if (in_array($input['default_sort'], ['1', '2', '3'])) {
            $settings->set('default_sort', (int) $input['default_sort']);
        }
    }

    protected function updateFormattingSettings($input, $settings)
    {
        $settings->set([
            'emoticons' => (boolean) $input['emoticons'],
            'bbcodes'   => (boolean) $input['bbcodes'],
            'markdown'  => (boolean) $input['markdown'],
            'auto_link' => (boolean) $input['auto_link'],
            'auto_email' => (boolean) $input['auto_email'],
            'auto_image' => (boolean) $input['auto_image'],
            'media_embed' => (boolean) $input['media_embed'],
        ]);

        app('comments.formatter')->flush();
    }

    protected function updateModerationSettings($input, $settings)
    {
        $moderationKeys = explode('\n', $input['moderation_keys']);
        $blacklistKeys  = explode('\n', $input['blacklist_keys']);
        $censoredWords  = explode(' ', $input['censored_words']);

        $settings->set([
            'moderation'  => (boolean) $input['moderation'],
            'akismet'     => (boolean) $input['akismet'],
            'duplicate'   => (boolean) $input['duplicate'],
            'censor'      => (boolean) $input['censor'],
            'max_pending' => $input['max_pending'] ? (int) $input['max_pending'] : null,
            'max_links'   => $input['max_links'] ? (int) $input['max_links'] : null,
            'moderation_keys' => array_map('trim', $moderationKeys),
            'blacklist_keys'  => array_map('trim', $blacklistKeys),
            'censored_words'  => array_map('trim', $censoredWords),
        ]);

        app('comments.formatter')->flush();
    }

    protected function updateProtectionSettings($input, $settings)
    {
        if (in_array($input['captcha'], ['0', '1', '2', '3'])) {
            $settings->set('captcha', (int) $input['captcha']);
        }

        $settings->set([
            'throttle'              => (boolean) $input['throttle'],
            'throttle_max_attempts' => (int) $input['throttle_max_attempts'],
            'throttle_lockout_time' => (int) $input['throttle_lockout_time'],
        ]);
    }

    protected function updateNotificationsSettings($input, $settings)
    {
        $settings->set([
            'admin_email' => e($input['admin_email']),
            'reply_email' => (boolean) $input['reply_email'],
        ]);
    }
}
