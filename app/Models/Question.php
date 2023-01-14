<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    public $fillable = [
        'question_number',
        'question_description',
        'campus_id',
        'user_id',
        'deleted_at',
    ];

    public function campuses()
    {
        return $this->belongsTo(Campus::class, 'campus_id','id');
    }
}
