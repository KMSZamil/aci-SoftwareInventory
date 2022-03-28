<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareDepartment extends Model
{
    use HasFactory;

    protected $table = 'SoftwareDepartment';
    public $timestamps = false;

    public function department_name()
    {
        return $this->belongsTo(Department::class, 'DepartmentCode', 'DepartmentCode');
    }
}
