<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Categories $category)
    {
        return response()->json([
            'data' => $category->with('products')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Categories $category)
    {
        $validated_req = $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $stored_category = $category->insert($validated_req);

        return !$stored_category ? response()->json([
            'message' => "Category wasn't saved",
            'data' => $stored_category
        ]) : response()->json([
            'message' => 'Category Saved',
            'data' => $stored_category
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = new Categories();
        $cat = $category->find($id);
        return !$cat ? response()->json(['message' => 'Category doesnt exist']) : response()->json([
            'message' => "Category Found",
            'data' => $cat
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
        $validated_req = $request->validate(['name' => 'string|unique:categories,name']);

        $update_cat = Categories::where('id', $id)->update($request->all());
        return $update_cat ? response()->json([
            'message' => "Item updated Successfully",
            'data' => $update_cat
        ]) : response()->json(['message' => 'Error, Item not updated']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Categories::find($id)->delete();

        return $cat ? response()->json(['Message' => 'Item wasnt deleted']) : response()->json(['Message' => 'Item Deleted Successfully']);
    }
}
