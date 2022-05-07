<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class UserList extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    use HasFactory, LaravelVueDatatableTrait;

    protected $casts = [
        'roles'             => 'array'
    ];

   

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'name' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'roles' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'email' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'created_at' => [
            'searchable' => false,
            'orderable' => true,
        ]
    ];
}
