<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'user',
        'company',
        'address',
        'account_type_id',
        'phone_code',
        'phone'
    ];
}
