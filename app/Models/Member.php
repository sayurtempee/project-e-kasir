<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'name',
        'no_telp',
        'email',
        'status',
        'discount_percentage',
        'point',
    ];
}
