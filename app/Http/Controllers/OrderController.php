<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::query()
            ->with('pizzas')
            ->get()
            ->map(function ($elem) {
                $pizzas = $elem->pizzas
                    ->map(function ($pizza) {
                        return [
                            'id' => $pizza->id,
                            'name' => $pizza->name,
                            'count' => $pizza->pivot->pizza_count,
                            'position_amount' => $pizza->amount * $pizza->pivot->pizza_count,
                        ];
                    });

                $total_amount = $pizzas->sum('position_amount');

                return [
                    'user'         => $elem->user->name . ' ' . $elem->user->last_name,
                    'is_paid'      => $elem->is_paid,
                    'is_cooked'    => $elem->is_cooked,
                    'is_delivered' => $elem->is_delivered,
                    'total_amount' => $total_amount,
                    'pizzas'       => $pizzas
                ];
            });

        return response($data);
    }
}
