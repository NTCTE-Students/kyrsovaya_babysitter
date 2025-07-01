<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyProfileService extends Model
{
    use HasFactory;

    protected $primaryKey = 'nanny_profiles_service_id';

    protected $fillable = [
        'nanny_profiles_id',
        'service_id',
    ];
}