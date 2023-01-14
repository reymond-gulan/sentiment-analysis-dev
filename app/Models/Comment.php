<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';

    protected $fillable = [
        'comment',
        'neutral',
        'positive',
        'negative',
        'client_id',
        'campus_id',
        'office_id',
        'college_id'
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function colleges()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function offices()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function campuses()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }
}
