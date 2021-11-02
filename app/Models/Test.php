<?php

namespace App\Models;

class Test extends BaseModel
{
    protected $fillable = [
        'user_id',
        'curriculum_id',
        'started_at',
        'ended_at',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    public function testDetails()
    {
        return $this->hasMany(TestDetail::class);
    }
}
