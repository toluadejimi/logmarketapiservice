<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function e_check(request $request){

        $get_user =  User::where('email', $request->email)->first() ?? null;

        if($get_user == null){

            return response()->json([
                'status' => false,
                'message' => 'No user found, please check email and try again',
            ]);
        }


        return response()->json([
            'status' => true,
            'user' => $get_user->username,
        ]);

    }


    public function e_fund(request $request){

        $get_user =  User::where('email', $request->email)->first() ?? null;

        if($get_user == null){

            return response()->json([
                'status' => false,
                'message' => 'No user found, please check email and try again',
            ]);
        }

        User::where('email', $request->email)->increment('balance', $request->amount) ?? null;

        $amount = number_format($request->amount, 2);

        Deposit::where('trx', $request->order_id)->update(['status'=> 1]);

        return response()->json([
            'status' => true,
            'message' => "NGN $amount has been successfully added to your wallet",
        ]);

    }


    public function verify_username(request $request)
    {

        $get_user =  User::where('email', $request->email)->first() ?? null;

        if($get_user == null){
            return response()->json([
                'status' => false,
                'message' => 'No user found, please check email and try again',
            ]);
        }

        return response()->json([
            'username' => $get_user->username
        ]);



    }
}
