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
            'type' => $this->type->name,
            'long' => $this->long,
            'larg' => $this->larg,
            'unit' => $this->unit,
            'comment' => Str::limit($this->comment, 15),
            'full_comment' => $this->comment,
            'status' => $this->status,
            'user' => $this->user->name,
            'infouser' => $this->user,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:m'),
        ];
    }
}
