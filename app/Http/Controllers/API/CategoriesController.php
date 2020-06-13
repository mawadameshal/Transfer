<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CategoriesController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $categories = Category::whereNull('father_id')->with('subcategory')->get();
        return response()->json(['Categories' => $categories], $this->successStatus);

    }

    public function show($id)
    {
        if(is_numeric($id)){
            $category =  Category::find($id);

            if (!$category){
                return response()->json(['error'=>trans('messages.category_not_found')], 401);

            }else{
                $category = Category::with('subcategory')->find($id);
                return $category;
            }
        }else{
            return response()->json(['error'=>trans('messages.category_not_valid')], 401);

        }


    }

    public function store(Request $request)
    {
        $category = new Category($request->input()) ;

        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'public//uploads/categories/' ;
            $file->move($destinationPath,$fileName);
            $category->image = URL::to('/').'/public/uploads/categories/'.$fileName ;
        }
        $category->save() ;
        return response()->json($category, 201);

    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category){
            $category->update($request->all());

            if($file = $request->hasFile('image')) {
                $file = $request->file('image') ;
                $fileName = $file->getClientOriginalName() ;
                $destinationPath = public_path().'public//uploads/categories/' ;
                $file->move($destinationPath,$fileName);
                $category->image = URL::to('/').'/public/uploads/categories/'.$fileName ;
            }

            $category->save();
            return response()->json($category, 200);
        }else{
            return response()->json(['error'=>trans('messages.category_not_found')], 401);

        }

    }

    public function delete(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success'=>trans('messages.category_delete')], 204);

    }

    public function search(){

        $category = Category::where('ename', 'like', request('name'))
            ->orWhere('aname', 'like', request('name'))->with('subcategory')->first();


        if (!$category){
            return response()->json(['error'=>trans('messages.category_not_found')], 401);
        }else{
            return $category;
        }

    }

}
