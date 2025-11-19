<?php

namespace App\Http\Controllers;

use App\Models\Roommate;
use App\Models\RoommatePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoommateController extends Controller
{
    // SHOW ALL ROOMMATE POSTS
    public function index()
    {
        $posts = RoommatePost::with('student', 'apartment')
            ->latest()
            ->get();

        return view('student.roommates.index', compact('posts'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        $student = Auth::user();

        $accepted = $student->applications()
            ->where('status', 'accepted')
            ->first();

        if (!$accepted) {
            return back()->with('error', 'You must be accepted in an apartment to create a roommate post.');
        }

        return view('student.roommates.create', compact('accepted'));
    }

    // STORE NEW POST
    public function store(Request $request)
    {
        $student = Auth::user();

        $accepted = $student->applications()->where('status', 'accepted')->first();

        RoommatePost::create([
            'student_id' => $student->id,
            'apartment_id' => $accepted->apartment_id,
            'title' => $request->title,
            'description' => $request->description,
            'cleanliness' => $request->cleanliness,
            'smoking' => $request->smoking ?? 0,
        ]);

        return redirect()->route('student.roommates.index')->with('success', 'Roommate post created.');
    }

    // APPLY TO JOIN ROOMMATE POST
    public function apply(RoommatePost $post)
    {
        $student = Auth::id();

        if (Roommate::where('student_id', $student)->where('post_id', $post->id)->exists()) {
            return back()->with('error', 'You already applied.');
        }

        Roommate::create([
            'student_id' => $student,
            'post_id' => $post->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Application sent!');
    }

    // MANAGE APPLICATIONS (FOR OWNER)
    public function manage()
    {
        $post = RoommatePost::where('student_id', Auth::id())->first();

        if (!$post) {
            return back()->with('error', 'You have no roommate post.');
        }

        $requests = Roommate::with('student')->where('post_id', $post->id)->get();

        return view('student.roommates.manage', compact('post', 'requests'));
    }

    // UPDATE APPLICATION STATUS
    public function updateStatus(Roommate $roommate, $status)
    {
        $roommate->update(['status' => $status]);

        return back()->with('success', 'Status updated.');
    }
}

