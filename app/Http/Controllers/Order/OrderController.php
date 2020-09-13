<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class OrderController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function order(Request $request)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ];  

        $this->validate($request, $rules);

        $order = $request->all();
        $order['user_id'] = auth()->user()->id;
        Order::create($order);

        $product = Product::find($request->product_id);

        if ($product->available_stock == 0) {
            return $this->errorResponse('Failed to order this product due to unavailability of the stock', 400);
        }

        if ($product->available_stock < $request->quantity) {
            return $this->errorResponse('The product does not have enough stocks for this order', 400);
        }
        
        $product->available_stock -= $request->quantity;
        $product->save();

        return $this->successResponse('You have successfully ordered this product', 201);
    }
}
