<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'traitement' => $this->traitement,
            'status' => $this->status,
            'isOther'  => $this->isOther,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
