<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Get all books with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');
        $genre = $request->get('genre');
        $status = $request->get('status');

        $query = Book::with(['reviews', 'komentar']);

        // Search by title or author
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by genre
        if ($genre) {
            $query->where('genre', $genre);
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        $books = $query->paginate($perPage);

        return ResponseHelper::success($books, 'Books retrieved successfully');
    }

    /**
     * Get book by ID
     */
    public function show($id)
    {
        $book = Book::with(['reviews.user', 'komentar.user', 'readingHistories'])
                    ->findOrFail($id);

        return ResponseHelper::success($book, 'Book retrieved successfully');
    }

    /**
     * Create new book (Admin only)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'description' => 'required|string',
            'status' => 'required|in:available,unavailable',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->only(['title', 'author', 'genre', 'year', 'description', 'status', 'content']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image_path'] = $imagePath;
        }

        $book = Book::create($data);

        return ResponseHelper::success($book, 'Book created successfully', 201);
    }

    /**
     * Update book (Admin only)
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:100',
            'year' => 'sometimes|integer|min:1000|max:' . (date('Y') + 1),
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:available,unavailable',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->only(['title', 'author', 'genre', 'year', 'description', 'status', 'content']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($book->image_path) {
                Storage::disk('public')->delete($book->image_path);
            }
            
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image_path'] = $imagePath;
        }

        $book->update($data);

        return ResponseHelper::success($book, 'Book updated successfully');
    }

    /**
     * Delete book (Admin only)
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Delete image if exists
        if ($book->image_path) {
            Storage::disk('public')->delete($book->image_path);
        }

        $book->delete();

        return ResponseHelper::success(null, 'Book deleted successfully');
    }

    /**
     * Get popular books
     */
    public function popular()
    {
        $books = Book::withCount('reviews')
                     ->withCount('readingHistories')
                     ->orderBy('reviews_count', 'desc')
                     ->orderBy('reading_histories_count', 'desc')
                     ->limit(10)
                     ->get();

        return ResponseHelper::success($books, 'Popular books retrieved successfully');
    }

    /**
     * Get latest books
     */
    public function latest()
    {
        $books = Book::orderBy('created_at', 'desc')
                     ->limit(10)
                     ->get();

        return ResponseHelper::success($books, 'Latest books retrieved successfully');
    }
}
