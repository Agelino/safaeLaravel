<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    /**
     * Get all genres
     */
    public function index()
    {
        $genres = Genre::withCount('topics')->get();

        return ResponseHelper::success($genres, 'Genres retrieved successfully');
    }

    /**
     * Get genre by ID with topics
     */
    public function show($id)
    {
        $genre = Genre::with(['topics.user', 'topics.comments'])->findOrFail($id);

        return ResponseHelper::success($genre, 'Genre retrieved successfully');
    }

    /**
     * Create new genre (Admin only)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|string|max:255|unique:genres',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $genre = Genre::create([
            'nama_genre' => $request->nama_genre,
            'slug' => Str::slug($request->nama_genre),
        ]);

        return ResponseHelper::success($genre, 'Genre created successfully', 201);
    }

    /**
     * Update genre (Admin only)
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_genre' => 'sometimes|string|max:255|unique:genres,nama_genre,' . $id,
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        if ($request->filled('nama_genre')) {
            $genre->update([
                'nama_genre' => $request->nama_genre,
                'slug' => Str::slug($request->nama_genre),
            ]);
        }

        return ResponseHelper::success($genre, 'Genre updated successfully');
    }

    /**
     * Delete genre (Admin only)
     */
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return ResponseHelper::success(null, 'Genre deleted successfully');
    }
}
