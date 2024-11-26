<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'role',
        'user_code',
        'academic_areer',
        'total_point',
        'completion_date',
        'semester',
        'gender',
        'email',
    ];

    protected $casts = [
        'total_point' => 'integer',
        'completion_date' => 'datetime',
        'semester' => 'integer',
    ];

    public function campusProgress()
    {
        return $this->hasMany(CampusProgress::class);
    }
}
