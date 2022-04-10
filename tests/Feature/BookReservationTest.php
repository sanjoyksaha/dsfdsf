<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
//    use RefreshDatabase;

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
        $this->withoutExceptionHandling();

        $response = $this->post('/book', [
            'title' => '',
            'author' => '',
            'details' => 'Test Details',
            'status' => 1
        ]);

        $response->assertSessionHasErrors('title');
//        $response->assertSessionHasErrors('author');
    }
}
