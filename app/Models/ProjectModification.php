<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProjectModification extends Model
{
    use HasFactory;

    protected $table = 'SoftwareModification';
    protected $primaryKey = 'SoftwareModificationID';
   
}
