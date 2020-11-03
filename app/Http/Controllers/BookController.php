<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    protected $page_title;

    /**
     * BookController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('layout.app-vue');
    }

    /**
     * Get all books.
     *
     * @return array
     */
    public function books()
    {
        $books = Books::orderBy('created_at', 'DESC')->paginate(100);;
        return $books;
    }

    /**
     * Book search by isbn.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchBookByISBN(Request $request)
    {
        $isbn = $request->get('isbn');

        $book = Books::where('isbn','LIKE',"%{$isbn}%")
            ->get();

        return response()->json([ 'book' => $book ],Response::HTTP_OK);
    }
}
