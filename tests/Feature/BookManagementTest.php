<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllBooks()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/books');

        $response->assertOk();

    }

    public function testABookCanBeAddedToTheLibrary()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/book', [
            'title' => 'Test Book Title',
            'author' => 'Test Author',
            'details' => 'Test Details',
            'status' => 1
        ]);

//        $response->assertOk();

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
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

        $response = $this->patch($book->path(), [
            'title' => 'Test Title Update',
            'author' => 'Test Author Update',
            'details' => 'Test Details Update',
            'status' => 0
        ]);

        $this->assertEquals('Test Title Update', Book::first()->title);
        $this->assertEquals('Test Author Update', Book::first()->author);
        $this->assertEquals('Test Details Update', Book::first()->details);
        $this->assertEquals(0, Book::first()->status);

        $response->assertRedirect($book->fresh()->path());
    }

    public function testABookCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/book', [
            'title' => 'Test Title',
            'author' => 'Test Author',
            'details' => 'Test Details',
            'status' => 1
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete('/deletebook/'. $book->id);
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
//        $response->assertJson([
//            'status' => 1,
//            'msg' => 'Deleted'
//        ]);
    }
}
