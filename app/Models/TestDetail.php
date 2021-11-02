<?php

namespace App\Models;

class TestDetail extends BaseModel
{
    const FAILED = 0;
    const CORRECT = 1;

    protected $fillable = [
        'test_id',
        'question_id',
        'status',
        'right_answer_index',
        'choose_answer_index',
    ];
}
