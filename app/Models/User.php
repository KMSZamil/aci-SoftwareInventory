<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'UserManager';
    protected $primaryKey = 'UserID';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public $guarded = [];

    public function getAuthPassword() {
        return $this->Password;
    }
}
