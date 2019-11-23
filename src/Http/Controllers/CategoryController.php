<?php

namespace SaadeMotion\Photofolio\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = \Photofolio::model('Category')->withCount('portifolios')->get();
        return \Photofolio::view('category.list')->with([
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Photofolio::view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->only(['title', 'slug']), [
            'title' => 'required|max:255',
            'slug' => 'required|slug|unique:categories'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = \Photofolio::model('Category')->create($request->only(['title', 'slug']));

        return response()->json($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Photofolio::view('category.edit')->with([
            'category' => \Photofolio::model('Category')->findOrFail($id)
        ]);
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
        $validator = \Validator::make($request->only(['title', 'slug']), [
            'title' => 'required|max:255',
            'slug' => 'required|slug|unique:categories,slug,'.$id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = \Photofolio::model('Category')->findOrFail($id);
        $category->fill($request->only(['title', 'slug']));
        $category->save();

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \Photofolio::model('Category')->destroy($id);
        return response()->json(null, 204);
    }
}
