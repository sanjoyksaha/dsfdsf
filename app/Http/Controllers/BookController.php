<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request){
//        $request->validate([
//            'title' => 'required',
//            'author' => 'required',
//            'status' => 'required'
//        ]);

        Book::create($request->all());
    }
}
