<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    protected $table = 'Software';
    protected $primaryKey = 'SoftwareID';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function platforms()
    {
        return $this->hasMany(SoftwarePlatform::class, 'SoftwareID', 'SoftwareID');
    }

    public function developers()
    {
        return $this->hasMany(SoftwareDeveloper::class, 'SoftwareID', 'SoftwareID');
    }

    public function departments()
    {
        return $this->hasMany(SoftwareDepartment::class, 'SoftwareID', 'SoftwareID');
    }
}
