<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        Book::all();
    }
    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'details' => '',
            'status' => 'required'
        ]);

        $book = Book::create($data);

        return redirect($book->path());
    }

    public function update(Request $request, Book $book){
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'details' => '',
            'status' => 'required'
        ]);

        $book->update($data);

        return redirect($book->path());
    }

    public function delete(Book $book){
        $book->delete();

        return redirect('/books');
//        return response()->json([
//            'status' => 1,
//            'msg' => 'Deleted'
//        ]);
    }
}
