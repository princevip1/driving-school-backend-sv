@extends('theme.layouts.app')

@section('title', 'Course | Create')


@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Course</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="basic-default-fullname">Title</label>
                                <input type="text" name="title" class="form-control" id="basic-default-fullname"
                                    placeholder="Enter Title" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="description">Description</label>
                                <input type="text" name="description" class="form-control" id="description"
                                    placeholder=" Enter description" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="duration">duration</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="duration" name="duration" class="form-control"
                                        placeholder="Enter duration" aria-label="john.doe"
                                        aria-describedby="basic-default-email2" required />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for=" price">price</label>
                                <input type="text" name="price" id="price" class="form-control phone-mask"
                                    placeholder="Enter Price" required />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">thumbnail </label>
                                <input name="thumbnail" type="file" class="dropify" data-height="100" />
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
        const theme = localStorage.getItem('templateCustomizer-vertical-menu-template--Style');
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
            // change background color of dropify
            $('.dropify-wrapper').css('background-color', theme === 'light' ? '#fff' :
                '#283144');
            $('.dropify-wrapper').css('border', `1px solid #546990`);
            $('.dropify-wrapper').css('border-radius', 5);

        });
    </script>
@endsection
