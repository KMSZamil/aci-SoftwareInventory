<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'Department';
    protected $primaryKey = 'DepartmentCode';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
}
