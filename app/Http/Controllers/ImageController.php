<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {
            $data = [
                'data' => Image::paginate(10),
                'message' => null
            ];
            $code_response = 200;
            return response()->json($data, $code_response);
        }
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
        $validator = Validator::make($request->all(), [
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_name' => 'required|string|max:40',
            'product_id'=> 'nullable'
            ]);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $imageName = null;
        if ($request->image_url != null) {
            $imageName = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('image_url'), $imageName);
        }


        $image = Image::create([
            'image_url' => $imageName,
            'image_name' => $request->image_name,
            'product_id' => $request->product_id
        ]);
        
        $data = [
            'data' => $image,
            'message' => "L'image a bien été ajoutée"
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::find($id);

        if (is_null($image)) {
            $data = [
                'message' => "L'image n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $data = [
                'data' => $image,
                'message' => null
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
        $image = Image::find($id);

        if (is_null($image)) {
            $data = [
                'message' => "L'image n'existe pas !"
            ];
            $code_response = 404;
        // } elseif ($request->image()->id != $id) {
        //     $data = [
        //         'message' => "L'image ne vous appartient pas !"
        //     ];
        //     $code_response = 403;
        } else {
            $productImage = $image->image_url;
            if (File::exists(public_path('image_url/' . $productImage))) {
                File::delete(public_path('image_url/' . $productImage));
            }
            $image->delete();
            $data = [
                'message' => "La supression a bien été effectuée"
            ];
            $code_response = 200;
        }
        return response()->json($data, $code_response);
    }


}



