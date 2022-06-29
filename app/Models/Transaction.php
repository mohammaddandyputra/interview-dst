<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "transactions";

    public $timestamps = false;

    protected $fillable = [
        'id', 'uuid', 'user_id', 'product_id', 'amount', 'tax', 'admin_fee', 'total', 'created_at', 'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
