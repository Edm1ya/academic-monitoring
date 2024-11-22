<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'theoretical_hours',
        'practical_hours',
        'credits',
        'semester',
        'prerequisites'
    ];
}
