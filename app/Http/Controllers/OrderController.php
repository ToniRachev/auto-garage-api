<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\Order\StoreOrderRequest;
use App\Http\Requests\V1\Order\UpdateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use App\Responses\V1\ApiResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::latest()->with('car.client')->paginate();
        return ApiResponse::paginated($orders, OrderResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        $order->load('car');
        return ApiResponse::ok(
            'Order was created successfully',
            new OrderResource($order)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return ApiResponse::ok(data: new OrderResource($order->load('car.client')));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->fill($request->validated());

        if ($order->isDirty()) {
            $order->save();
        }

        return ApiResponse::ok(data: new OrderResource($order));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return ApiResponse::noContent();
    }
}
