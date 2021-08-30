<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'data' => User::paginate(10),
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
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|same:password',
            'phone_number' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $imageName = null;
        if ($request->profile_image != null) {
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('profile_image'), $imageName);
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'profile_image' => $imageName
        ]);
        $user->roles()->attach(Role::where('name', 'user')->first());

        $data = [
            'data' => $user,
            'message' => "Votre compte a bien été créé, un email de confirmation vous a été envoyé"
        ];

        $user->sendEmailVerificationNotification();

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
        $user = User::find($id);

        if (is_null($user)) {
            $data = [
                'message' => "L'utilisateur n'existe pas !"
            ];
            $code_response = 404;
        } else {
            $data = [
                'data' => $user,
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
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email|unique:users',
            'password' => 'nullable|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        if (is_null($user)) {
            $data = [
                'message' => "L'utilisateur n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($request->user()->id != $id) {
            $data = [
                'message' => "L'utilisateur ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            $imageName = null;
            $userImage = $user->profile_image;
            if (!is_null($userImage) && $request->profile_image != null) {
                if (File::exists(public_path('profile_image/' . $userImage))) {
                    File::delete(public_path('profile_image/' . $userImage));
                }
            }
            $data = $request->all();
            if ($request->profile_image != null) {
                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('profile_image'), $imageName);
                $data['profile_image'] = $imageName;
            }
            $user->update($data);
            $data = [
                'data' => $user,
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
        $user = User::find($id);

        if (is_null($user)) {
            $data = [
                'message' => "L'utilisateur n'existe pas !"
            ];
            $code_response = 404;
        } elseif ($request->user()->id != $id) {
            $data = [
                'message' => "L'utilisater ne vous appartient pas !"
            ];
            $code_response = 403;
        } else {
            $userImage = $user->profile_image;
            if (File::exists(public_path('profile_image/' . $userImage))) {
                File::delete(public_path('profile_image/' . $userImage));
            }
            $user->addresses()->delete();
            $user->products()->delete();
            $user->roles()->detach();
            $user->delete();
            $data = [
                'message' => "La supression a bien été effectuée"
            ];
            $code_response = 200;
        }
        return response()->json($data, $code_response);
    }

    public function getUserByRequest(Request $request)
    {
        return $request->user();
    }
}
