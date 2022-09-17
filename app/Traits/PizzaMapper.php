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
                'user_name'       => $elem->user->name,
                'user_patronymic' => $elem->user->patronymic,
                'user_last_name'  => $elem->user->last_name,
                'user_address'    => $elem->user->address,
                'order_number'    => $elem->id,
                'is_paid'         => $elem->is_paid,
                'is_cooked'       => $elem->is_cooked,
                'is_delivered'    => $elem->is_delivered,
                'order_date'      => $elem->created_at->format('d.m.Y'),
                'total_amount'    => $total_amount,
                'pizzas'          => $pizzas
            ];
        });

        return $data;
    }
}
