<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'nanny_profiles_id';

    protected $fillable = [
        'user_id',
        'name',
        'photo',
        'bio',
        'experience_years',
        'age',
        'hourly_rate',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'nanny_profiles_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'nanny_profiles_service', 'nanny_profiles_id', 'service_id');
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
