<?php

namespace SaadeMotion\Photofolio\Http\Controllers;

use Illuminate\Http\Request;

class PortifolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portifolios = \Photofolio::model('Portifolio')->with('category')->get();

        return \Photofolio::view('portifolio.list')->with([
            'portifolios' => $portifolios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Photofolio::view('portifolio.create')->with([
            'categories' => \Photofolio::model('Category')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->only(['title', 'slug', 'description', 'category_id', 'status']), [
            'title' => 'required|max:255',
            'slug' => 'required|slug|unique:portifolios',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:draft,published'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $portifolio = \Photofolio::model('Portifolio')->create($request->only(['title', 'slug', 'description', 'category_id', 'status']));

        return response()->json($portifolio, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Photofolio::view('portifolio.edit')->with([
            'portifolio' => \Photofolio::model('Portifolio')->findOrFail($id),
            'portifolioItems' => \Photofolio::model('PortifolioItem')->where('portifolio_id', $id)->get(),
            'categories' => \Photofolio::model('Category')->all()
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
        $validator = \Validator::make($request->only(['title', 'slug', 'description', 'category_id', 'status']), [
            'title' => 'required|max:255',
            'slug' => 'required|slug|unique:portifolios,slug,'.$id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:draft,published'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $portifolio = \Photofolio::model('Portifolio')->findOrFail($id);
        $portifolio->fill($request->only(['title', 'slug', 'description', 'category_id', 'status']));
        $portifolio->save();

        return response()->json($portifolio, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \Photofolio::model('Portifolio')->destroy($id);
        return response()->json(null, 204);
    }
}
