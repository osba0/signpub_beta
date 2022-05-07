<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole 
{
    const ROLE_ADMIN = 'admin';
    const ROLE_SECRETARIAT = 'secretariat';
    const ROLE_SALLE_TIRAGE_ROULEAU = 'salle_tirage_rouleau';
    const ROLE_SALLE_TIRAGE_FEUILLE = 'salle_tirage_feuille';
    const ROLE_SALLE_DECOUPE = 'salle_decoupe';
    const ROLE_FINITION = 'finition';


    /***
     * @return array
     */
    public static function getRoleList()
    {
        return [
            static::ROLE_ADMIN  => 'Admin',
            static::ROLE_SECRETARIAT   => 'Secretariat',
            static::ROLE_SALLE_TIRAGE_ROULEAU => 'Salle tirage rouleau',
            static::ROLE_SALLE_TIRAGE_FEUILLE => 'Salle tirage feuille',
            static::ROLE_SALLE_DECOUPE => 'Salle decoupe',
            static::ROLE_FINITION => 'Finition'
        ];
    }
}
