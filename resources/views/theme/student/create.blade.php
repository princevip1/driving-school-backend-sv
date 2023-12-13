@extends('theme.layouts.app')

@section('title', 'Student | Create')


@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Student</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="name">name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter name" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="age">age</label>
                                <input type="text" name="age" class="form-control" id="age"
                                    placeholder=" Enter age" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="email">email</label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder=" Enter email" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="password">password</label>
                                <input type="text" name="password" class="form-control" id="password"
                                    placeholder=" Enter password" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="registration_number">registration number</label>
                                <input type="text" name="registration_number" class="form-control"
                                    id="registration_number" placeholder=" Enter registration number" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phone_number">phone number</label>
                                <input type="text" name="phone_number" class="form-control" id="phone_number"
                                    placeholder=" Enter phone number" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="gender">gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value=""selected>Select Gander</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="course">course</label>
                                <select class="form-control" name="course" id="gender">
                                    <option value=""selected>Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="address">address</label>
                                <div class="input-group input-group-merge">
                                    <textarea class="form-control" name="address" id="address" cols="10" rows="5" placeholder="Enter Address"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">profile Picture </label>
                                <input name="profile_picture" type="file" class="dropify" data-height="100" />
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
