<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

trait PizzaMapper
{
    public function map_pizza(Collection $data): SupportCollection
    {
        $data = $data->map(function ($elem) {
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
                'user_name'      => $elem->user->name,
                'user_last_name' => $elem->user->last_name,
                'is_paid'        => $elem->is_paid,
                'is_cooked'      => $elem->is_cooked,
                'is_delivered'   => $elem->is_delivered,
                'total_amount'   => $total_amount,
                'pizzas'         => $pizzas
            ];
        });

        return $data;
    }
}
