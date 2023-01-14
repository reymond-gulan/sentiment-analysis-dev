<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $table = 'colleges';

    protected $fillable = [
        'college_code',
        'college_name',
        'college_dean',
        'campus_id',
        'user_id',
        'deleted_at'
    ];

    public function campuses()
    {
        return $this->belongsTo(Campus::class, 'campus_id','id');
    }

    public function offices()
    {
        return $this->hasMany(Office::class, 'college_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'college_id');
    }
}
