@extends('theme.layouts.app')

@section('title', 'Gateway | Create')


@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Gateway</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('gateway.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="name">name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter name" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="api_key">api key</label>
                                <input type="text" name="api_key" class="form-control" id="api_key"
                                    placeholder=" Enter api key" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="api_secret">api secret</label>
                                <input type="text" name="api_secret" class="form-control" id="api_secret"
                                    placeholder=" Enter api secret" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="api_token">api token</label>
                                <input type="text" name="api_token" class="form-control" id="api_token"
                                    placeholder=" Enter api token" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="api_url">api url</label>
                                <input type="text" name="api_url" class="form-control" id="api_url"
                                    placeholder=" Enter api url" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="client_id">client id</label>
                                <input type="text" name="client_id" class="form-control" id="client_id"
                                    placeholder=" Enter client id" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">logo</label>
                                <input name="logo" type="file" class="dropify" data-height="100" />
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
