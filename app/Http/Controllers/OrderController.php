<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\PizzaMapper;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use PizzaMapper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query()
            ->with('pizzas')
            ->get();

        $orders = $this->map_pizza($orders);

        return response($orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::query()->where('id', $id)->with('pizzas')->get();

        $order = $this->map_pizza($order);

        return response()->json($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->pizzas) {
            $message = "Позиции в заказе не найдены";
            $status = 402;
            return response($message, $status);
        }

        $order = new Order;
        $order->fill($request->all())->save();

        foreach ($request->pizzas as $pizza) {
            $pizza = json_decode($pizza, true);
            $order->pizzas()->attach($pizza['pizza_id'], ['pizza_count' => $pizza['pizza_count']]);
        }

        $message = "Заказ № {$order->id} успешно создан";
        $status = 200;

        return response($message, $status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input();
        $order = Order::find($id);

        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $order->$key = $value;
            }
        }
        $order->save();

        $order->pizzas()->detach();
        foreach ($request->pizzas as $pizza) {
            $pizza = json_decode($pizza, true);
            $order->pizzas()->attach($pizza['pizza_id'], ['pizza_count' => $pizza['pizza_count']]);
        }

        $message = "Заказ № {$id} обновлён";
        $status = 200;
        return response($message, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = "Заказ № {$id} не найден";
        $status = 422;
        $order = Order::find($id) ?? null;

        if ($order) {
            $order->delete();
            $message = "Заказ № {$id} удалён";
            $status = 200;
        }

        return response($message, $status);
    }
}
