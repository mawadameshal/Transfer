<?php

namespace App\Http\Controllers\API;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CompaniesController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $companies =  Company::all();
        return response()->json(['Companies' => $companies], $this->successStatus);

    }

    public function show($id)
    {
        if(is_numeric($id)){
            $company =  Company::find($id);

            if (!$company){
                return response()->json(['error'=>trans('messages.company_not_found')], 401);

            }else{
                $company = Company::with('branches')->with('offices')->find($id);
                return $company;
            }
        }else{
            return response()->json(['error'=>trans('messages.company_not_valid')], 401);

        }


    }

    public function store(Request $request)
    {
        $company = new Company($request->input()) ;

        if($file = $request->hasFile('logo')) {
            $file = $request->file('logo') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/public/uploads/company_logos/' ;
            $file->move($destinationPath,$fileName);
            $company->logo = URL::to('/').'/public/uploads/company_logos/'.$fileName ;
        }
        $company->save() ;
        return response()->json($company, 201);

    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());
        if($file = $request->hasFile('logo')) {
            $file = $request->file('logo') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/public/uploads/company_logos/' ;
            $file->move($destinationPath,$fileName);
            $company->logo = URL::to('/').'/public/uploads/company_logos/'.$fileName ;
        }
        $company->save() ;
        return response()->json($company, 200);
    }

    public function delete(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(null, 204);

    }

    public function searchForCompanyID($company_id)
    {
        if(!empty($company_id)){
            $company = Company::where('company_id', '=', $company_id)->first();
            if (!$company){
                return response()->json(['error'=>trans('messages.company_not_found')], 401);
            }else{
                $company = Company::where('company_id', '=', $company_id)->with('branches')->with('offices')->first();
                return $company;
            }
        }else{
            return response()->json(['error'=>trans('messages.company_required')], 401);
        }


    }


}
