<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class UserManager extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'UserManager';
    protected $primaryKey = 'UserID';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    protected $guard_name = 'web';

    public $guarded = [];

    public function getAuthPassword() {
        return $this->Password;
    }
}
