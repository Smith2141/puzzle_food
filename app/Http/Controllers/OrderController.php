<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\PizzaMapper;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class OrderController extends Controller
{
    use PizzaMapper;
    private $rules = [
        'user_id'      => 'required|exists:users,id',
        'is_paid'      => 'required|boolean',
        'is_cooked'    => 'required|boolean',
        'is_delivered' => 'required|boolean',

        'pizzas'               => 'required|array|min:1',
        'pizzas.*.pizza_id'    => 'required|numeric|exists:pizzas,id',
        'pizzas.*.pizza_count' => 'required|numeric',
    ];

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
        try {
            $order = Order::query()->where('id', $id)->with('pizzas')->get();
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ошибка запроса id=' . $id], 422);
        }

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
        $validated = $request->validate($this->rules);

        $order = new Order;
        $order->fill($validated)->save();

        foreach ($validated['pizzas'] as $pizza) {
            $order->pizzas()->attach($pizza['pizza_id'], ['pizza_count' => $pizza['pizza_count']]);
        }

        $message = "Заказ № {$order->id} успешно создан";
        $status = 200;
        return response()->json(['message' => $message], $status);
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
        $validated = $request->validate($this->rules);

        $order = Order::find($id);

        foreach ($validated as $key => $value) {
            if (!is_array($value)) {
                $order->$key = $value;
            }
        }
        $order->save();

        $order->pizzas()->detach();
        foreach ($validated['pizzas'] as $pizza) {
            $order->pizzas()->attach($pizza['pizza_id'], ['pizza_count' => $pizza['pizza_count']]);
        }

        $message = "Заказ № {$id} обновлён";
        $status = 200;
        return response()->json(['message' => $message], $status);
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

        try {
            $order = Order::find($id);
        } catch (QueryException $e) {
            $message = "Ошибка запроса id={$id}";
            $status = 400;
            return response()->json(['message' => $message], $status);
        }

        if ($order) {
            $order->pizzas()->detach();
            $order->delete();
            $message = "Заказ № {$id} удалён";
            $status = 200;
        }

        return response()->json(['message' => $message], $status);
    }
}
