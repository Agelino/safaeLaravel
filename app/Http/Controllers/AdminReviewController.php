<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'book'])->latest()->get();

        return view('admin.reviews.index', [
            'reviews' => $reviews
        ]);
    }

    public function show($id)
    {
        $review = Review::with(['user', 'book'])->findOrFail($id);

        return view('admin.reviews.show', [
            'review' => $review
        ]);
    }

    public function destroy($id)
    {

        $review = Review::findOrFail($id);

        $review->delete();

        return redirect('/admin/reviews');
    }
}
