<?php

namespace App\Http\Controllers;

use App\Models\Pizza;

class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all();
        return response($pizzas);
    }
}
