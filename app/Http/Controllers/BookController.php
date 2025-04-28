<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function show($id)
    {
        return Book::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $book->update($request->only('title', 'description', 'price', 'category_id'));

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }
}
