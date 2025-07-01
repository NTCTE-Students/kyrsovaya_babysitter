<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    protected $fillable = ['name'];

    public function nannyProfiles()
    {
        return $this->belongsToMany(NannyProfile::class, 'nanny_profiles_service', 'service_id', 'nanny_profiles_id');
    }
}