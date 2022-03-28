<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareDeveloper extends Model
{
    use HasFactory;
    protected $table = 'SoftwareDeveloper';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function developer_name()
    {
        return $this->belongsTo(Developer::class, 'DeveloperID', 'DeveloperID');
    }
}
