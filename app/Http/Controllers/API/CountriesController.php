<?php


namespace App\Http\Controllers\API;


use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CountriesController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        $Countries =  Country::orderBy('code')->get();
        return response()->json(['Countries' => $Countries], $this->successStatus);
    }

}