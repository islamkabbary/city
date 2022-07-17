<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\AddedTax;
use App\Models\PromoCode;
use App\Models\orderDetails;
use Illuminate\Http\Request;
use App\Models\DeliveryValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $order = new Order;
            $order->user_id = Auth::id();
            $order->company_id = $request->company_id;
            if ($request->has('phone')) {
                $order->phone = $request->phone;
            }
            if ($request->has('promo_code')) {
                if ($this->checkPromoCode($request->promo_code)) {
                    $order->promo_code_id = $this->checkPromoCode($request->promo_code);
                }
            }
            $products = Cart::where('user_id',Auth::id())->get();
            dd($products);
            foreach($products as $product){
                $order->sub_total += $product->price;
            }
            $tax = AddedTax::where('company_id', $request->company_id)->first();
            $DeliveryValue = DeliveryValue::where('company_id', $request->company_id)->first();
            if($tax){
                $order->added_tax_id = $tax->id;
                $order->total = $order->sub_total + $order->sub_total * $tax->tax / 100;
            }
            if($DeliveryValue){
                $order->delivery_value_id = $DeliveryValue->id;
                $order->total = $order->total + $DeliveryValue->value;
            }
            // $order->save();
            foreach($products as $product){
                $orderDetail = new orderDetails;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->qty = $product->pivot->qty;
                $orderDetail->save();
            }
            // $data['product'] = ProductResource::collection($products);
            // // $data['order'] = OrderResource::collection($order);
            // $data['user_name'] = Auth::user()->name;
            // $data['user_phone_login'] = Auth::user()->phone;
            // $data['user_phone_new'] = $order->phone;
            // return response()->json(['status' => 1, 'code' => 200, 'message' => 'Order created successfully', 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function checkPromoCode($code)
    {
        $promoCode = PromoCode::where('code', $code)->first();
        if ($promoCode != null) {
            if ($promoCode->start_date <= now()  && $promoCode->end_date >= now()) {
                if ($promoCode->limit_for_user != null) {
                    $orderForUserCount = $promoCode->orders()->where('user_id', Auth::id())->count();
                    if ($orderForUserCount >= $promoCode->limit_for_user) {
                        return false;
                    }
                }
                if ($promoCode->limit_use != null) {
                    $orderCount = $promoCode->orders()->count();
                    if ($orderCount >= $promoCode->limit_use) {
                        return false;
                    }
                }
                return $promoCode->id;
            }
        }
        return false;
    }

    // if($order->promo_code_id){
    //     $promoCode = PromoCode::find($order->promo_code_id);
    //     $order->total = $order->sub_total - ($order->sub_total * $promoCode->discount / 100);
    // }else{
    //     $order->total = $order->sub_total + ($order->sub_total * $tax->value / 100) + $DeliveryValue->value;
    // } 
}
