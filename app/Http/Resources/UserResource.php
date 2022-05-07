<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\UserRole;

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
            'role'  => UserRole::getRoleList()[$this->roles[0]],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:m'),
            
        ];
    }
}
