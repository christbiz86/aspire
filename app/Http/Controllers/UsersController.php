<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(){
        $data = User::all();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function show($id){
        try {
            $data = User::find($id)->first();
            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(request $request){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = md5($request->password);
        $user->save();
        return response()->json([
            'message' => 'User saved!',
            'data' => $user
        ]);
    }

    public function update(request $request, $id){
        try {
            $name = $request->name;
            $email = $request->email;
            $password = md5($request->password);

            $user = User::find($id);
            if(!$email){
                $email = $user->email;
            }
            if(!$password){
                $password = $user->password;
            }
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->save();
            return response()->json([
                'message' => 'User updated!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id){
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'message' => 'User deleted!',
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
