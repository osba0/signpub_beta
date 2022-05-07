<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use App\Models\Type;
use App\Models\User;

class Order extends Model
{


    use HasFactory, LaravelVueDatatableTrait;

     protected $fillable = [
        'id',
        'type_id',
        'long',
        'larg',
        'unit',
        'comment',
        'user_id',
        'images',
        'status'
    ];

    

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'type_id' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'unit' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'long' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'larg' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'status' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'comment' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'user_id' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'created_at' => [
            'searchable' => false,
            'orderable' => true,
        ]
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
