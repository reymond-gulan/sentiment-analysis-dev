<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $table = 'settings';

    public $timestamps = false;

    protected $fillable = [
        'require_email_verification',
        'campus_id'
    ];

    public function campuses()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'id');
    }
}
