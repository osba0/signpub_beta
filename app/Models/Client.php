<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use App\Models\AccountType;
use App\Models\User;

class Client extends Model
{
    use HasFactory, LaravelVueDatatableTrait;
     protected $fillable = [
        'id',
        'user',
        'company',
        'address',
        'account_type_id',
        'phone_code',
        'phone'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'user' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'company' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'address' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'phone_code' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'phone' => [
            'searchable' => true,
            'orderable' => true,
        ]
    ];

}
