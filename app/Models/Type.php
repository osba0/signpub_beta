<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Type extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'types';
   
    use HasFactory, LaravelVueDatatableTrait;

    protected $fillable = [
        'id',
        'name',
        'traitement',
        'status',
        'isOther',
        'created_at'
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
        'traitement' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'status' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'isOther' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'created_at' => [
            'searchable' => true,
            'orderable' => true,
        ]
        
        
        
    ];


}
