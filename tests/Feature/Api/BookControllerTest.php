<?php

namespace Tests\Feature\Api;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_books_endpoint(): void
    {
        $books = Book::factory(3)->create();
        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function(AssertableJson $json) use ($books)  {
            $json->whereAllType([
                '0.id' => 'integer',
                '0.title' => 'string',
                '0.isbn' => 'string'
            ]);

            $json->hasAll(['0.id', '0.title', '0.isbn']);

            $book = $books->first();

            $json->whereAll([
                '0.id' => $book->id,
                '0.title' => $book->title,
                '0.isbn' => $book->isbn,
            ]);
        });
    }

    public function test_get_book_endpoint(): void
    {
        $book = Book::factory(1)->createOne();
        $response = $this->getJson('/api/books/'. $book->id);

        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($book)  {
            $json->hasAll(['id', 'title', 'isbn', 'created_at', 'updated_at']);

            $json->whereAllType([
                'id' => 'integer',
                'title' => 'string',
                'isbn' => 'string'
            ]);

            $json->whereAll([
                'id' => $book->id,
                'title' => $book->title,
                'isbn' => $book->isbn,
            ]);
        });
    }

    public function test_post_book_endpoint(): void
    {
        $book = Book::factory(3)->makeOne()->toArray();

        $response = $this->postJson('/api/books', $book);

        $response->assertStatus(201);

        $response->assertJson(function(AssertableJson $json) use ($book)  {
            $json->hasAll(['id', 'title', 'isbn', 'created_at', 'updated_at']);

            $json->whereAll([
                'title' => $book['title'],
                'isbn' => $book['isbn'],
            ])->etc();
        });
    }

    public function test_put_book_endpoint(): void
    {
        Book::factory(1)->createOne();

        $book = [
            'title' => 'Update book',
            'isbn'  => '12345678900'
        ];

        $response = $this->putJson('/api/books/1', $book);

        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($book)  {
            $json->hasAll(['id', 'title', 'isbn', 'created_at', 'updated_at']);

            $json->whereAll([
                'title' => $book['title'],
                'isbn' => $book['isbn'],
            ])->etc();
        });
    }

    public function test_patch_book_endpoint(): void
    {
        Book::factory(1)->createOne();

        $book = [
            'title' => 'Update book with patch'
        ];

        $response = $this->patchJson('/api/books/1', $book);

        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($book)  {
            $json->hasAll(['id', 'title', 'isbn', 'created_at', 'updated_at']);

            $json->where('title', $book['title']);
        });
    }

    public function test_delete_book_endpoint(): void
    {
        Book::factory(1)->createOne();

        $response = $this->deleteJson('/api/books/1');

        $response->assertStatus(204);
    }

    public function test_post_book_should_validate_request(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422);

        $response->assertJson(function(AssertableJson $json)  {
            $json->hasAll(['message', 'errors']);

            $json->where('errors.title.0', 'Este campo é obrigatório')
                ->where('errors.isbn.0', 'Este campo é obrigatório');

        });
    }
}
