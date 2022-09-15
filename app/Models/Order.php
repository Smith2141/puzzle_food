<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'is_paid',
        'is_cooked',
        'is_delivered'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'is_paid' => 'boolean',
    //     'is_cooked' => 'boolean',
    //     'is_delivered' => 'boolean',
    // ];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class, 'order_pizza')->withPivot('pizza_count');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
