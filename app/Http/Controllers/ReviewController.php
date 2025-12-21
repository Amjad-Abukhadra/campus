<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\Apartment;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Submit a review
    public function store(Request $request, Apartment $apartment)
    {
        $student = Auth::user();

        // Check if student has paid for this apartment
        $hasPaid = Application::where('std_id', $student->id)
            ->where('apartment_id', $apartment->id)
            ->where('payment_status', 'paid')
            ->exists();

        if (!$hasPaid) {
            return redirect()->back()->with('error', 'You must have paid for this apartment to leave a review.');
        }

        // Check if already reviewed
        if (Review::where('student_id', $student->id)->where('apartment_id', $apartment->id)->exists()) {
            return redirect()->back()->with('error', 'You have already reviewed this apartment.');
        }

        // Validate
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create review
        Review::create([
            'student_id' => $student->id,
            'apartment_id' => $apartment->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    // View reviews for an apartment
    public function index(Apartment $apartment)
    {
        $reviews = $apartment->reviews()->with('student')->latest()->get();
        $averageRating = $apartment->averageRating();

        return view('student.reviews.index', compact('apartment', 'reviews', 'averageRating'));
    }
}
