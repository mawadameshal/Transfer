<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\User_Type;

class UserTypesController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        $user_types =  User_Type::all();
        return response()->json(['Types' => $user_types], $this->successStatus);
    }

}