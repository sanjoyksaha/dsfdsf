<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function testABookCanBeAddedToTheLibrary()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/book', [
            'title' => 'Test Book Title',
            'author' => 'Test Author',
            'details' => 'Test Details',
            'status' => 1
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }

    public function testTitleIsRequired()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/book', [
            'title' => '',
            'author' => 'Test Author',
            'details' => 'Test Details',
            'status' => 1
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/book', [
            'title' => 'Test Title',
            'author' => '',
            'details' => 'Test Details',
            'status' => 1
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function testStatusIsRequired()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/book', [
            'title' => 'Test Title',
            'author' => 'Test Author',
            'details' => 'Test Details',
            'status' => ''
        ]);

        $response->assertSessionHasErrors('status');
    }

    public function testABookCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        $this->post('/book', [
            'title' => 'Test Title',
            'author' => 'Test Author',
            'details' => 'Test Details',
            'status' => 1
        ]);

        $book = Book::first();

        $response = $this->patch('/updatebook/' . $book->id, [
            'title' => 'Test Title Update',
            'author' => 'Test Author Update',
            'details' => 'Test Details Update',
            'status' => 0
        ]);

        $this->assertEquals('Test Title Update', Book::first()->title);
        $this->assertEquals('Test Author Update', Book::first()->author);
        $this->assertEquals('Test Details Update', Book::first()->details);
        $this->assertEquals(0, Book::first()->status);
    }
}
