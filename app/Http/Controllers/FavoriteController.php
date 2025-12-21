<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Favorite;
use App\Models\Apartment;
use App\Models\RoommatePost;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:apartment,roommate_post',
        ]);

        $user = Auth::user();
        $modelClass = $request->type === 'apartment' ? Apartment::class : RoommatePost::class;
        $model = $modelClass::findOrFail($request->id);

        $existing = $user->favorites()
            ->where('favoritable_id', $request->id)
            ->where('favoritable_type', $modelClass)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
            $message = 'Removed from favorites.';
        } else {
            $user->favorites()->create([
                'favoritable_id' => $request->id,
                'favoritable_type' => $modelClass,
            ]);
            $status = 'added';
            $message = 'Added to favorites.';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('favoritable')->latest()->get();

        $savedApartments = $favorites->where('favoritable_type', Apartment::class)->pluck('favoritable');
        $savedPosts = $favorites->where('favoritable_type', RoommatePost::class)->pluck('favoritable');

        return view('student.favorites.index', compact('savedApartments', 'savedPosts'));
    }
}
