<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeFrame extends Model
{
    use HasFactory;

    protected $table = 'TimeFrame';
    protected $primaryKey = 'TimeFrameID';
    public $incrementing = false;
    public $timestamps = false;

    public function timeframe_name()
    {
        return $this->belongsTo(TimeFrame::class, 'TimeFrameID', 'TimeFrameID');
    }
}
