<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //Get all categories
        $categories = Category::all();
        return CategoryResource::collection($categories);
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
        $category = $request->isMethod('put') 
            ? 
            Category::findOrFail($request->category_id)
            :
            new Category;

        $category->id = $request->input('category_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->parent_id = $request->input('parent_id');

        if($category->save()) {
            return new CategoryResource($category);
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
        //Get a single category
        $category = Category::findOrFail($id);

        return new CategoryResource($category);
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
        //Get a single category
        $category = Category::findOrFail($id);

        if($category->delete()) {
            return new CategoryResource($category);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        //Get a single category
        $category = Category::findOrFail($id);

        //$category->id = $request->input('category_id');
        $category->is_active = $request->input('is_active');

        if($category->save()) {
            return new CategoryResource($category);
        }
    }
}
