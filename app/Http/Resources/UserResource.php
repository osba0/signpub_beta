<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\UserRole;
use Cache;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'role'  => ($this->roles!=''? UserRole::getRoleList()[$this->roles[0]]:'User'),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
            'is_online' => Cache::has('user-is-online-' . $this->id)? ' <span class="text-success text-nowrap fw-bold">En Ligne</span>' : ' <span class="text-danger text-nowrap fw-bold">Hors Ligne</span>',
            'last_seen' => ($this->last_seen!=""?Carbon::parse($this->last_seen)->diffForHumans():'') 
            
        ];
    }
}
