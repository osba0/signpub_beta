<?php

namespace App\Http\Resources;

use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;
use Cache;

class ClientResource extends JsonResource
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
            'company' => $this->company,
            'phone_code' => $this->phone_code,
            'phone' => ' +'.$this->phone_code.' '.$this->phone,
            'phoneOnly' => $this->phone,
            'account' => $this->account,
            'address' => $this->address,
            'typecompte' => $this->typeCompte,
            'total_cmd' => $this->total_cmd,
            'is_online' => (Cache::has('user-is-online-' . $this->user)? ' <span class="text-success text-nowrap fw-bold">En Ligne</span>' : ' <span class="text-danger text-nowrap fw-bold">Hors Ligne</span>').' '.($this->lastSee!=""?Carbon::parse($this->lastSee)->diffForHumans():''),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:m'),
            'username' => $this->username
            
        ];
    }
}
