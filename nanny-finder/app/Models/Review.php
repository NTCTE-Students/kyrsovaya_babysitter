<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'reviews_id';

    protected $fillable = [
        'nanny_profiles_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function nannyProfile()
    {
        return $this->belongsTo(NannyProfile::class, 'nanny_profiles_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
