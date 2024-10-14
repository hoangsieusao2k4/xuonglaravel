<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'classroom_id'

    ];
    public function passport()
    {
        return $this->hasOne(Passport::class);
    }
    public function classroom()
    {
        return $this->BelongsTo(Classroom::class);
    }
    public function subjects() {
        return $this->belongsToMany(Subject::class);
    }
}
