@extends('theme.layouts.app')
@section('title', 'Teacher | Edit')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Teacher</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="name">name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter name" required value="{{ $teacher->name }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="age">age</label>
                                <input type="text" name="age" class="form-control" id="age"
                                    placeholder=" Enter age" value="{{ $teacher->age }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="address">address</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="address" name="address" class="form-control"
                                        placeholder="Enter address" aria-label="john.doe"
                                        aria-describedby="basic-default-email2" required value="{{ $teacher->address }}" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for=" phone_number">phone number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control phone-mask"
                                    placeholder="Enter Phone number" required value="{{ $teacher->phone_number }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for=" role">Role</label>
                                <input type="text" name="role" id="role" class="form-control phone-mask"
                                    placeholder="Enter role" required value="{{ $teacher->role }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="gender">gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value=""selected>Select Gander</option>
                                    <option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
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
