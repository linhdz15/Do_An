<?php

namespace App\Models;

class Answer extends BaseModel
{
    const WRONG = 0;
    const RIGHT = 1;

    protected $fillable = [
        'content',
        'answer',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
