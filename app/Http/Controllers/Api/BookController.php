<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function __construct(private Book $book)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->book->all());
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = $this->book->create($request->all());

        return response()->json($book, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $book = $this->book->find($id);

        $book->update($request->all());
        
        return response()->json($book);
    }

    public function destroy(int $id): JsonResponse
    {
        $book = $this->book->find($id);

        $book->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
