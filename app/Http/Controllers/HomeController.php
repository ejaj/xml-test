<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessXML;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $page_title;

    /**
     * HomeController constructor.
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
        if (isset($_GET['ISBN'])) {
            $books = Books::where('isbn', $_GET['ISBN'])->paginate(100);
            $books->setPath(url('/'));
            $books_pagination = $books->appends(['ISBN' => $_GET['ISBN']])->render();
            $data['books_pagination'] = $books_pagination;
            $data['books'] = $books;
        } else {
            $books = Books::paginate(100);
            $books->setPath(url('/'));
            $books_pagination = $books->render();
            $data['books_pagination'] = $books_pagination;
            $data['books'] = $books;
        }

        return view('index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', '-1');
        $validator = Validator::make($request->all(), [
            'xml_file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            if ($request->file('xml_file') != null) {
                $path = $request->file('xml_file')->getRealPath();
                $xml = simplexml_load_file($path);
                ProcessXML::dispatch(json_encode($xml, JSON_PRETTY_PRINT));
                return redirect()->back()->with('success-message', 'XML upload successfully');
            }
        } catch (\Exception $e) {
            $message = "Message : " . $e->getMessage() . ", File : " . $e->getFile() . ", Line : " . $e->getLine();
            Log::debug($message);
            return redirect()->back()->with('error-message', $message);
        }
    }

}
