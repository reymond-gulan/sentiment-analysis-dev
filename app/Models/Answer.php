<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    public $fillable = [
        'description',
        'points',
        'campus_id',
        'user_id',
        'deleted_at',
    ];

    public function campuses()
    {
        return $this->belongsTo(Campus::class, 'campus_id','id');
    }
}
