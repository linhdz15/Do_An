<?php

namespace App\Models;

use Illuminate\Support\Str;

class Grade extends BaseModel
{
    const DISABLE = 0;
    const ENABLE = 1;
    const PRE_SCHOOL = 0;
    const JUNIOR_SCHOOL = 1;
    const HIGH_SCHOOL = 2;

    protected $fillable = [
        'title',
        'slug',
        'banner',
        'status',
        'type',
        'index',
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

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'courses',
            'grade_id',
            'subject_id'
        )->distinct('subject_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'grade_id');
    }

    public static function getType($type)
    {
        switch ($type) {
            case self::PRE_SCHOOL :
                return 'Tiểu học';
                break;
            case self::JUNIOR_SCHOOL :
                return 'Trung học cơ sở';
                break;
            case self::HIGH_SCHOOL :
                return 'Trung học phổ thông';
                break;
            default :
                return '';
                break;
        }
    }
}
