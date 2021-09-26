<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;


use Illuminate\Http\Request;
use App\Models\PhoneBookModel;

class PhoneBookController extends Controller
{
    function onInsert(Request $request){
        //accessing the token key
        $token=$request->input('access_token');
        $key=env('TOKEN_KEY');
        //Token key decoding
        $decoded = JWT::decode($token, $key, array('HS256'));
        //converting decoding result to associative array
        $decoded_array =(array) $decoded;
        //Taking username from associative array
        $user = $decoded_array['user'];

       $one =  $request->input('phone_number_one');
       $two =  $request->input('phone_number_two');
        $name = $request->input('name');
        $email = $request->input('email');

        $result=PhoneBookModel::insert([
            'username'=>$user,
            'phone_number_one'=>$one,
            'phone_number_two'=>$two,
            'name'=>$name,
            'email'=>$email,
            

         ]);

         if($result==true){
            return 'Save Succesfull';

         }else{
            return 'Fail ! Try Again' ;

         }

        
        
    }

    function onSelect(Request $request){
        //accessing the token key
        $token=$request->input('access_token');
        $key=env('TOKEN_KEY');
        //Token key decoding
        $decoded = JWT::decode($token, $key, array('HS256'));
        //converting decoding result to associative array
        $decoded_array =(array) $decoded;
        //Taking username from associative array
        $user = $decoded_array['user'];

        $result=PhoneBookModel::where('username', $user)->get();

        return $result;

    }

    function onDelete(Request $request){
        //Taking email because deleting will continue according to email
        $email=$request->input('email');
        //accessing the token key
        $token=$request->input('access_token');
        $key=env('TOKEN_KEY');
        //Token key decoding
        $decoded = JWT::decode($token, $key, array('HS256'));
        //converting decoding result to associative array
        $decoded_array =(array) $decoded;
        //Taking username from associative array
        $user = $decoded_array['user'];

        $result=PhoneBookModel::where(['username'=> $user,'email'=> $email ])->delete();

        
        if($result==true){
            return 'Delete Succesfull';

         }else{
            return 'Delete Fail ! Try Again' ;

         }



    }
}
