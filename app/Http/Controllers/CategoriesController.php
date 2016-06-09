<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = \App\models\Category::with('children')->where('parent_id', '0')->get();
        $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get();
        $active_menu = "categorias";
        return \View::make('backend.pages.categories', compact('categories', 'categoriesList', 'active_menu'));
    }


    public function forumCategories()
    {
        $categories = \App\models\ForumCategory::with('children')->where('parent_id', '0')->get();
        $categoriesList = \App\models\ForumCategory::with('children')->where('parent_id', '0')->get();
        $active_menu = "categorias_foro";
        return \View::make('backend.pages.forum.categories', compact('categories', 'categoriesList', 'active_menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->parent_id == 'subcat')
        {
            return \Redirect::back()->with('error', 'Necesitas escoger categoría padre para creat una subcategoria');
        }
        else {
            $rules = [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug',
            ];
            $validation = \Validator::make($request->all(),  $rules);


            if($validation->fails()) {
                return \Redirect::back()->withErrors($validation)->withInput();
            } else {
                if($request->has('parent_id')) 
                {
                    $category = \App\models\Category::create(array('name' => $request->name, 'slug' => $request->slug, 'parent_id' => $request->parent_id));
                } else {
                    $category = \App\models\Category::create(array('name' => $request->name, 'slug' => $request->slug));
                }
               return \Redirect::back();
            }
        }


    }


    public function storeForumCategory(Request $request)
    {
        //dd($request->all());
        if($request->parent_id == 'subcat')
        {
            return \Redirect::back()->with('error', 'Necesitas escoger categoría padre para creat una subcategoria');
        }
        else {
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'slug' => 'required|unique:forum_categories,slug',
            ];
            $validation = \Validator::make($request->all(),  $rules);


            if($validation->fails()) {
                return \Redirect::back()->withErrors($validation)->withInput();
            } else {
                if($request->has('parent_id')) 
                {
                    $category = \App\models\ForumCategory::create(array('title' => $request->title, 'description' => $request->description,  'slug' => $request->slug, 'parent_id' => $request->parent_id));
                } else {
                    $category = \App\models\ForumCategory::create(array('title' => $request->title, 'description' => $request->description,  'slug' => $request->slug, 'parent_id' => '0'));
                }
               return \Redirect::back();
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
