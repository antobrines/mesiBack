<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'data' => Category::paginate(10),
            'message' => null
        ];
        $code_response = 200;
        return response()->json($data, $code_response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required|string|'
        ]);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $category = Category::create([
            'name' => $request->name,
            'image' => $request->image
        ]);

        $data = [
            'data' => $category,
            'image' => "La catégorie a bien été créé"
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            $data = [
                'message' => "La catégorie n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $data = [
                'data' => $category,
                'message' => null
            ];
            $code_response = 200;
        }

        return response()->json($data, $code_response);
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
        $category = Category::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required|string|'
        ]);
        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        if (is_null($category)) {
            $data = [
                'message' => "La catégorie n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $category->update($request->all());
            $data = [
                'data' => $category,
                'message' => "La modification à bien été effectuée"
            ];
            $code_response = 200;
        }

        return response()->json($data, $code_response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            $data = [
                'message' => "La catégorie n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $category->delete();
            $data = [
                'message' => "La supression a bien été effectuée"
            ];
            $code_response = 200;
        }
        return response()->json($data, $code_response);
    }

    public function getProductByCategories(Request $request, $id) {
        $categories = Category::find($id);
        return $categories->products()->get();
    }  

}
