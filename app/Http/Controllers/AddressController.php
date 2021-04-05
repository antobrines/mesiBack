<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->addresses;
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
            'country' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:5|min:5',
            'street' => 'required|string',
            'type' => 'in:idk1,idk2'
        ]);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $adress = Address::create([
            'country' => $request->country,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'street' => $request->street,
            'type' => $request->type,
            'user_id' => $request->user()->id
        ]);

        return $adress;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $adress = Address::find($id);
        $user = $request->user();

        if (is_null($adress)) {
            $data = [
                'message' => "L'adresse n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($user->id !== $adress->user_id) {
            $data = [
                'message' => "L'adresse ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            $data = [
                'data' => $adress,
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
        $adress = Address::find($id);
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'country' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:5|min:5',
            'street' => 'required|string',
            'type' => 'in:idk1,idk2',
            'user_id' => 'nullable'
        ]);
        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        if (is_null($adress)) {
            $data = [
                'message' => "L'adresse n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($user->id !== $adress->user_id) {
            $data = [
                'message' => "L'adresse ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            $adress->update($request->all());
            $data = [
                'data' => $adress,
                'message' => "La modification à bien été effectuée"
            ];
            $code_response = 200;
        }

        return response()->json($data, $code_response);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $adress = Address::find($id);
        $user = $request->user();
        if (is_null($adress)) {
            $data = [
                'message' => "L'adresse n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($user->id !== $adress->user_id) {
            $data = [
                'message' => "L'adresse ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            Address::find($id)->delete();
            $data = [
                'message' => "La supression à bien été effectuée"
            ];
            $code_response = 200;
        }
        return response()->json($data, $code_response);
    }
}
