<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'data' => Role::paginate(10),
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
            'description' => 'required|string|'
        ]);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $data = [
            'data' => $role,
            'message' => "Le role a bien été créé"
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
        $role = Role::find($id);

        if (is_null($role)) {
            $data = [
                'message' => "Le role n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $data = [
                'data' => $role,
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
        $role = Role::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string|'
        ]);
        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        if (is_null($role)) {
            $data = [
                'message' => "Le role n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $role->update($request->all());
            $data = [
                'data' => $role,
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
        $role = Role::find($id);

        if (is_null($role)) {
            $data = [
                'message' => "Le role n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $role->delete();
            $data = [
                'message' => "La supression a bien été effectuée"
            ];
            $code_response = 200;
        }
        return response()->json($data, $code_response);
    }
}
