<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\Http\Controllers\Controller;
use App\OrderItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  auth()->user()->id;
        $orders = Order::where('user_id_sender','=',$user)->with('sender','receiver','items','office')->get();
        return response()->json(['Orders' => $orders], $this->successStatus);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user =  auth()->user()->id;
        $order = new Order($request->input()) ;
        $order->user_id_sender = $user;
        $order->status = 0;
        if($order->save()){
            if(!empty($request->input('items'))){
                foreach ($request->input('items') as $item_order){
                    $item = new OrderItems();
                    $item->item_id =  $item_order['item_id'];
                    $item->quantity =  $item_order['quantity'];
                    $item->sugar_spoon = $item_order['sugar_spoon'];
                    $item->order_id = $order->id;
                    $item->user_id = $user;
                    $item->save();
                }
            }
            return response()->json($order, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order_info = Order::where('id','=',$id)->with('sender','receiver','items','office')->first();
        if(!$order_info){
            return response()->json(['error'=>trans('messages.Not_found')], 401);
        }else{
            return response()->json(['Order' => $order_info], $this->successStatus);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order){
            $order->delete();
            return response()->json(null, 204);
        }else{
            return response()->json(['error'=>trans('messages.Not_found')], 401);
        }

    }

    public function current_orders()
    {
        $user =  auth()->user()->id;
        $orders = Order::whereDate('created_at', Carbon::today())->where('user_id_sender','=',$user)->with('sender','receiver','items','office')->get();
        return response()->json(['Orders' => $orders], $this->successStatus);

    }

    public function previous_orders()
    {
        $user =  auth()->user()->id;
        $orders = Order::whereDate('created_at','<', Carbon::today())->where('user_id_sender','=',$user)->with('sender','receiver','items','office')->get();
        return response()->json(['Orders' => $orders], $this->successStatus);
    }

    public function favorite_orders()
    {
        //
    }
}
