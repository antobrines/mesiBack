<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate(10);
        $data = [
            'data' => $products,
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
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price_ht' => 'required|integer',
            'description' => 'required|string|min:5',
            'stock' => 'required|string',
            'user_id' => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $imageName = null;
        if ($request->product_image != null) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('product_image'), $imageName);
        }

        $product = Product::create([
            'name' => $request->name,
            'price_ht' => $request->price_ht,
            'description' => $request->description,
            'stock' => $request->stock,
            'user_id' => $user->id,
            'product_image' => $imageName
        ]);

        $data = [
            'data' => $product,
            'message' => "Le produit a bien été créé"
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
        $product = Product::find($id);

        if (is_null($product)) {
            $data = [
                'message' => "Le produit n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $data = [
                'data' => $product,
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
        $product = Product::find($id);
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price_ht' => 'required|integer',
            'description' => 'required|string|min:5',
            'stock' => 'required|string',
            'user_id' => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        if (is_null($product)) {
            $data = [
                'message' => "Le produit n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($user->id !== $product->user_id) {
            $data = [
                'message' => "Le produit ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            $imageName = null;
            $productImage = $product->product_image;
            if (!is_null($product_image) && $request->product_image != null) {
                if (File::exists(public_path('product_image/' . $productImage))) {
                    File::delete(public_path('product_image/' . $productImage));
                }
            }
            $data = $request->all();
            if ($request->product_image != null) {
                $imageName = time() . '.' . $request->product_image->extension();
                $request->product_image->move(public_path('product_image'), $imageName);
                $data['product_image'] = $imageName;
            }
            $product->update($data);
            $data = [
                'data' => $product,
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
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $user = $request->user();

        if (is_null($product)) {
            $data = [
                'message' => "Le produit n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($user->id !== $product->user_id) {
            $data = [
                'message' => "Le produit ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            $productImage = $product->product_image;
            if (File::exists(public_path('product_image/' . $productImage))) {
                File::delete(public_path('product_image/' . $productImage));
            }
            $product->delete();
            $product->images()->delete();
            $data = [
                'message' => "La supression à bien été effectuée"
            ];
            $code_response = 200;
        }
        return response()->json($data, $code_response);
    }

    public function getCategoriesProduct(Request $request, $id) {
        $product = Product::find($id);
        return $product->categories()->get();
    }  

    /**
     * return the product's image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getImagesByProduct(Request $request, $id){

        $product = Product::find($id);

        if (is_null($product)) {
            $data = [
                'message' => "Le produit n'existe pas !"
            ];
            $code_response = 404;
        } else {
        $data = [
            'data' => $product->images()->paginate(10),
            'message' => null
        ];
    }
        $code_response = 200;
        return response()->json($data, $code_response);
    }

        /**
     * Display the specified resource.
     *
     * @param  string 
     * @return \Illuminate\Http\Response
     */
    public function searchByName(Request $request,$name)
    {
        $products = Product::where([
            ['name', 'LIKE', '%' . $name . '%']
        ])
            ->orderBy("id", "desc")
            ->paginate(10);

        if (is_null($products)) {
            $data = [
                'message' => "Pas de résultat !"
            ];
            $code_response = 404;
        } else {
            $data = [
                'data' => $products,
                'message' => null
            ];
            $code_response = 200;
        }

        return response()->json($data, $code_response);
    }


}
