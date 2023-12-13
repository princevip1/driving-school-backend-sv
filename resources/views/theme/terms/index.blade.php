@extends('theme.layouts.app')

@section('title', 'Terms of use')

@section('style')

@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-primary alert-dismissible d-flex align-items-center" role="alert">
            <i class="bx bx-xs bx-command me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
            <i class="bx bx-xs bx-store me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.terms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label" for="description">description</label>
                            <textarea class="ckeditor form-control" name="description" cols="10">
                                {{ $terms->description ?? '' }}
                            </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>

            </div>

        </div>

    </div>
@endsection


@section('script')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('.ckeditor').ckeditor();
            $('.ckeditor_basic').ckeditor(); // if class is prefered.

        });
    </script>

@endsection
