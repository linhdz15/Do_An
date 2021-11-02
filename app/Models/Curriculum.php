<?php

namespace App\Models;

class Curriculum extends BaseModel
{
    protected $table = 'curriculums';

    const DISABLE = 0, ACTIVE = 1;
    const TYPE_TEST = Course::TYPE_TEST;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'course_id',
        'parent_id',
        'index',
        'time',
        'score',
        'type',
        'status',
        'view',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function children()
    {
        return $this->hasMany(Curriculum::class, 'parent_id');
    }
}
