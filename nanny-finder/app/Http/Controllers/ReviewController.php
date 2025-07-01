<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\NannyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $nannyId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        
        $nanny = NannyProfile::findOrFail($nannyId);
        
        $review = new Review();
        $review->nanny_profiles_id = $nanny->nanny_profiles_id;
        $review->user_id = Auth::id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        
        return redirect()->back()->with('success', 'Отзыв успешно добавлен');
    }
}