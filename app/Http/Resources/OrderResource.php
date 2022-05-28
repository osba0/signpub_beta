<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type_id' => $this->type->name.' '.(($this->autre_matiere!=' ' && $this->autre_matiere!='')?'('.$this->autre_matiere.')':''),
            'long' => $this->long,
            'larg' => $this->larg,
            'unit' => $this->unit,
            'comment' => Str::limit($this->comment, 15),
            'full_comment' => $this->comment,
            'status' => $this->status,
            'user' => $this->user->name,
            'infouser' => $this->user,
            'autre_matiere' => $this->autre_matiere,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
