<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public $timestamps = false;

    protected $fillable = [
        'course_code',
        'course_name',
        'college_id',
        'campus_id',
        'user_id',
        'deleted_at',
    ];

    public function colleges()
    {
        return $this->belongsTo(College::class, 'college_id','id');
    }

    public function campuses()
    {
        return $this->belongsTo(Campus::class, 'campus_id','id');
    }

}
