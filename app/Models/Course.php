<?php

namespace App\Models;

class Course extends BaseModel
{
    const DISABLE = 0, ACTIVE = 1;
    const TYPE_TEST = 0;

    protected $fillable = [
        'title',
        'slug',
        'banner',
        'description',
        'grade_id',
        'subject_id',
        'chapter_id',
        'lesson_id',
        'editor_id',
        'status',
        'type',
        'index',
        'view',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'published_at',
    ];

    public function isActive()
    {
        return $this->status === self::ACTIVE;
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function examCurriculums()
    {
        return $this->curriculums()
            ->where('type', self::TYPE_TEST)
            ->where(function($query) {
                $query->whereNotNull('parent_id')
                      ->where('parent_id', '<>', 0);
            });
    }
}
