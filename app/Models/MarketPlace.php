<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPlace extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'unit_price',
        'isSold',   
    ];
    public function user(){

    	return $this->belongsTo(User::class);
    }  
}
