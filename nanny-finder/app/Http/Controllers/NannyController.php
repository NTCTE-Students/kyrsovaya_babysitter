<?php

namespace App\Http\Controllers;

use App\Models\NannyProfile;
use App\Models\Service;
use Illuminate\Http\Request;

class NannyController extends Controller
{
    public function index(Request $request)
    {
        $query = NannyProfile::query();
        
        // Фильтрация по местоположению
        if ($request->has('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        
        // Фильтрация по опыту
        if ($request->has('min_experience')) {
            $query->where('experience_years', '>=', $request->min_experience);
        }
        
        // Фильтрация по ставке
        if ($request->has('max_rate')) {
            $query->where('hourly_rate', '<=', $request->max_rate);
        }
        
        // Фильтрация по услугам
        if ($request->has('services')) {
            $query->whereHas('services', function($q) use ($request) {
                $q->whereIn('services.service_id', $request->services);
            });
        }
        
        $nannies = $query->with(['services', 'reviews.user'])
                        ->withAvg('reviews', 'rating')
                        ->paginate(10);
        
        $services = Service::all();
        
        return view('nannies.index', compact('nannies', 'services'));
    }
    
    public function show($id)
    {
        $nanny = NannyProfile::with(['services', 'reviews.user'])
                            ->withAvg('reviews', 'rating')
                            ->findOrFail($id);
        
        return view('nannies.show', compact('nanny'));
    }
}
