@extends('theme.layouts.app')

@section('title', 'Contact | Create')


@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Contact</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="name">name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter name" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="contact">contact</label>
                                <input type="text" name="contact" class="form-control" id="contact"
                                    placeholder=" Enter contact" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="type">Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value=""selected>Select Type</option>
                                    <option value="office">Office</option>
                                    <option value="person">Person</option>
                                </select>
                            </div>


                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
        });
    </script>
@endsection
