<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'campuses';

    protected $fillable = [
        'campus_name',
        'campus_address',
        'email_address',
        'contact_information'
    ];

    public function colleges()
    {
        return $this->hasMany(College::class, 'campus_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'campus_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'campus_id');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class, 'campus_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'campus_id');
    }
}
