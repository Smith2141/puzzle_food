<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function list()
    {
        $orders = Order::all();
        return response($orders);
    }
}
