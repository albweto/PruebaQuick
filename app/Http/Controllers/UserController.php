<?php
/**
 * Created by PhpStorm.
 * User: samuelhenriquez
 * Date: 28/02/19
 * Time: 07:57 PM
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends  Controller
{

    public function list(Request $request)
    {
        if ($request->isJson()){
            $users = User::all();
            return response()->json($users,200);
        }
        return response()->json(["Error"=>"Unauthorized"],400);
    }

    public function update($id,Request $request)
    {
     if ($request->json()){
         $user = User::findOrFail($id);
         $user->update($request->all());
         return response()->json($user,201);
     }
        return response()->json(["Error"=>"Unauthorized"],400);
    }

    public function create(Request $request)
    {
        if ($request->isJson()){
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);
           $data = $request->json()->all();
           $user = User::create([
               'first_name' =>$data['first_name'],
               'last_name' =>$data['last_name'],
               'email' =>$data['email'],
               'password' =>$data['password'],
               'api_token' =>str_random(60)
           ]);
            return response()->json($user,201);
        }
        return response()->json(["Error"=>"Unauthorized"],400);
    }

    public function  findUser($id,Request $request)
    {
        if ($request->isJson()){
            $user = User::find($id);
            return response()->json($user,200);
        }
        return response()->json(["Error"=>"Unauthorized"],400);
    }

    public function delete($id,Request $request)
    {
        if ($request->isJson()){
            User::findOrFail($id)->delete();
            return response()->json(['succes'=>'user delete'],200);
        }
        return response()->json(["Error"=>"Unauthorized"],400);
    }


    public function Login(Request $request)
    {
    if ($request->isJson()){
        try{

            $data = $request->json()->all();

            $user = User::where('email',$data['email'])->first();
            if ($user && $user->password){
                return response()->json($user,200);
            }else{
                return response()->json(['error'=>'No Content1'],406);
            }
        }catch (ModelNotFoundException $exception){
            return response()->json(['error'=>'No Content2'],406);
        }
    }
        return response()->json(["Error"=>"Unauthorized"],400);
    }

}