<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwarePlatform extends Model
{
    use HasFactory;

    protected $table = 'SoftwarePlatform';
    public $timestamps = false;

    public function platform_name()
    {
        return $this->belongsTo(Platform::class, 'PlatformID', 'PlatformID');
    }
}
