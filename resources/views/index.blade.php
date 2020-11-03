@extends('layout.app')
@section('content')
    <h2>Book list</h2>

    <form class="form-inline" method="get">
        @csrf
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">ISBN</label>
            <input type="text" class="form-control" name="ISBN" placeholder="Please enter a ISBN number">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>

    <table class="table table-bordered mb-5">
        <thead>
        <tr class="table-success">
            <th scope="col">#</th>
            <th scope="col">ISBN</th>
            <th scope="col">Title</th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <th scope="row">{{ $book->id }}</th>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->title }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $books->links() !!}
    </div>
@endsection
