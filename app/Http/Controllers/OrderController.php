<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::query()
            ->with('pizzas')
            ->get()
            ->map(function ($elem) {
                $total_amount = $elem->pizzas->sum('amount');
                $pizzas = $elem->pizzas->groupBy('name')
                    ->map(function ($pizza) {
                        $pizza_price = $pizza->first()->amount;
                        return [
                            'count' => $pizza->count(),
                            'position_amount' => $pizza->count() * $pizza_price
                        ];
                    });
                return [
                    'user'         => $elem->user->name . ' ' . $elem->user->last_name,
                    'is_paid'      => $elem->is_paid,
                    'is_cooked'    => $elem->is_cooked,
                    'is_delivered' => $elem->is_delivered,
                    'total'        => $total_amount,
                    'pizzas'       => $pizzas
                ];
            });

        return response($data);
    }
}
