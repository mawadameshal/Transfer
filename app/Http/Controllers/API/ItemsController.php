<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;


class ItemsController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $items = Item::with('category', 'subcategory')->get();
        return response()->json(['Items' => $items], $this->successStatus);

    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $item = Item::find($id);

            if (!$item) {
                return response()->json(['error' => trans('messages.item_not_found')], 401);

            } else {
                $item = Item::with('category', 'subcategory')->find($id);
                return $item;
            }
        } else {
            return response()->json(['error' => trans('messages.item_not_valid')], 401);

        }


    }

    public function store(Request $request)
    {
        $ename = request('ename');
        $count_items = Item::where('ename', '=', $ename)->get();
        if($count_items->count() > 0){
            return response()->json(['error' => trans('messages.duplicate_item')], 401);
        }else{
            $item = new Item($request->input());

            if ($file = $request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path() . 'public//uploads/items/';
                $file->move($destinationPath, $fileName);
                $item->image = URL::to('/') . '/public/uploads/items/' . $fileName;
            }
            $item->save();
            return response()->json($item, 201);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->update($request->all());
            if ($file = $request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path() . '/public/uploads/items/';
                $file->move($destinationPath, $fileName);
                $item->image = URL::to('/') . '/public/uploads/items/' . $fileName;
            }
            $item->save();
            return response()->json($item, 200);
        } else {
            return response()->json(['error' => trans('messages.item_not_found')], 401);

        }

    }

    public function delete(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json(['success' => trans('messages.item_delete')], 204);

    }

    public function mostly_orders($category = null)
    {
        if ($category != null) {
            $items = Item::where('category_id', '=', $category)->with('category', 'subcategory')->orderBy('no_orders', 'DESC')->take(10)->get();
            return response()->json(['Items' => $items], $this->successStatus);
        } else {
            $items = Item::with('category', 'subcategory')->orderBy('no_orders', 'DESC')->take(10)->get();
            return response()->json(['Items' => $items], $this->successStatus);
        }

    }

    public function featured_items($category = null)
    {
        if ($category != null) {
            $items = Item::where([['category_id', '=', $category], ['featured', '=', '1']])->with('category', 'subcategory')->take(10)->get();
            return response()->json(['Items' => $items], $this->successStatus);
        } else {
            $items = Item::where('featured', '=', '1')->with('category', 'subcategory')->take(10)->get();
            return response()->json(['Items' => $items], $this->successStatus);
        }
    }

    public function new_item($category = null)
    {
        if ($category != null) {
            $items = Item::where('category_id', '=', $category)->with('category', 'subcategory')->orderBy('created_at', 'DESC')->take(10)->get();
            return response()->json(['Items' => $items], $this->successStatus);
        } else {
            $items = Item::with('category', 'subcategory')->orderBy('created_at', 'DESC')->take(10)->get();
            return response()->json(['Items' => $items], $this->successStatus);
        }
    }


    public function search()
    {
        $items = Item::where('ename', 'like', request('name'))
            ->orWhere('aname', 'like', request('name'))
            ->with('category', 'subcategory')->orderBy('no_orders', 'DESC')->get();

        if (!$items) {
            return response()->json(['error' => trans('messages.items_not_found')], 401);
        } else {
            return response()->json(['Items' => $items], $this->successStatus);
        }

    }

    public function items_by_category($category)
    {
        $items = Item::where('sub_category_id', '=', $category)
            ->with('category', 'subcategory')->orderBy('no_orders', 'DESC')->get();

        if (!$items) {
            return response()->json(['error' => trans('messages.items_not_found')], 401);

        } else {
            return response()->json(['Items' => $items], $this->successStatus);
        }
    }
}
