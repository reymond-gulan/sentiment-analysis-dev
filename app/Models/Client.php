<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'id_number',
        'name',
        'yr',
        'gender',
        'email_address',
        'verification_code',
        'is_verified',
        'course_id',
        'college_id',
        'office_id',
        'campus_id',
        'semester',
        'deleted_at',
    ];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function colleges()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function offices()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
