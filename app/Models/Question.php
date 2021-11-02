<?php

namespace App\Models;

class Question extends BaseModel
{
    const DISABLE = 0;
    const ACTIVE = 1;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'reason',
        'curriculum_id',
        'editor_id',
        'index',
        'status',
        'view',
        'edited_at',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
