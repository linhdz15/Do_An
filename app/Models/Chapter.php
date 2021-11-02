<?php

namespace App\Models;

use Illuminate\Support\Str;

class Chapter extends BaseModel
{
    const DISABLE = 0;
    const ENABLE = 1;

    protected $fillable = [
        'title',
        'slug',
        'banner',
        'status',
        'index',
        'grade_id',
        'subject_id',
        'editor_id',
        'seo_title',
        'seo_keywords',
        'seo_description',
    ];

    /**
     * Set the title and the readable slug.
     *
     * @param string $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        $this->setUniqueSlug($value);
    }

    /**
     * Get the unique slug.
     *
     * @return param $extra
     */
    public function getUniqueSlug()
    {
        return $this->slug;
    }

    /**
     * Set the unique slug.
     *
     * @param $value
     * @param $extra
     */
    public function setUniqueSlug($value)
    {
        $slug = Str::slug($value);

        if (static::whereSlug($slug)->where('id', '<>', $this->id)->exists()) {
            $this->setUniqueSlug($slug . '-' . Str::random(5));

            return;
        }

        $this->attributes['slug'] = $slug;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', self::ENABLE);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
