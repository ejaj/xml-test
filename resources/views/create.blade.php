@extends('layout.app')
@section('content')
    <h2>XML Upload</h2>
    @if($errors->count() > 0 )
        <div class="alert alert-danger" role="alert">
            <strong class="text-capitalize">The following errors have occurred:</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach( $errors->all() as $message )
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('success-message'))
        <div class="alert alert-card alert-success" role="alert">
            <strong class="text-capitalize">Success! </strong>
            {{\Illuminate\Support\Facades\Session::get('success-message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('error-message'))
        <div class="alert alert-card alert-danger" role="alert">
            <strong class="text-capitalize">Error! </strong>
            {{\Illuminate\Support\Facades\Session::get('error-message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form method="post" action="" enctype="multipart/form-data">
        @csrf
        <p>XML file:</p>
        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" id="customFile" name="xml_file">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
