<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:6|max:50',
            'contactNumber' => 'required|regex:/^[0-9]{11}$/',
            'email' => 'email|required|unique:users,email',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status'=>500, 'errors' => $validator->errors()]);
        } else {
            $validated = $request->all();
            $result = Users::create($validated);
            return response()->json(['status'=>200, 'data'=>$result]);
        }
    }
}
