<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $table = 'offices';

    protected $fillable = [
        'office_name',
        'college_id',
        'user_id',
        'deleted_at'
    ];

    public function colleges()
    {
        return $this->belongsTo(College::class, 'college_id','id');
    }
}
