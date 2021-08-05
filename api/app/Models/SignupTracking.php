<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

# We do not need the full blown eloquent db model.
# But it just comes up with most commonly used method.
# So lets just extends for it

class SignupTracking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'created_at',
        'onboarding_perentage',
        'count_applications',
        'count_accepted_applications',
    ];

    protected $casts = [
        'onboarding_perentage' => 'int',
    ];
}
