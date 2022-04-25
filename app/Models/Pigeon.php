<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pigeon extends Model
{
    use HasFactory;

    const  STATUS_AVAILABLE = 0;
    const  STATUS_BUSY = 1;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pigeon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'speed',
        'max_range',
        'cost',
        'downtime',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function Order(){
        $this->hasMany(Order::class);
    }
}
