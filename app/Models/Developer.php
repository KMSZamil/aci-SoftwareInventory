<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $table = 'Developers';
    protected $primaryKey = 'DeveloperID';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function user_info()
    {
        return $this->belongsTo(UserManager::class, 'DeveloperID', 'UserID');
    }
}
