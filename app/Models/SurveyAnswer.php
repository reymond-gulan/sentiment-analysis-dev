<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'survey_answers';
    public $timestamps = false;

    protected $fillable = [
        'answer',
        'question_id',
        'client_id',
        'campus_id',
        'office_id',
        'college_id'
    ];

    public function questions()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

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
