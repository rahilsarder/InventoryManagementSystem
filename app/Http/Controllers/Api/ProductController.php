<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Products::with('category')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_req = $request->validate(['name' => 'required|string|unique:products,name', 'category_id' => 'required']);

        $product = Products::insert($request->all());

        $product = $product->with('category');

        return $product ? response()->json(['message' => 'Product stored successfully', 'data' => $product]) : response()->json(['message' => "Something went wrong"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        return $product ? response()->json(['message' => 'Product Found', 'data' => $product]) : response()->json(['message' => 'Product doesnt exist']);
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
        return Products::find($id)->delete() ? response()->json(['message' => 'Item deleted Successfully']) : response()->json(['message' => 'Item doesnt exist']);
    }
}
