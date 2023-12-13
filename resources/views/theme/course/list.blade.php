@extends('theme.layouts.app')

@section('title', 'Course | List')

@section('head')
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
@endsection
@section('content')
    {{-- session message --}}
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
    <div class="card">
        <div class="card-datatable table-responsive p-4">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Course List</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <a href="{{ route('course.create') }}">
                            <button class="dt-button create-new btn btn-sm btn-primary" tabindex="0"
                                aria-controls="DataTables_Table_0" type="button">
                                <span>
                                    <i class="bx bx-plus me-sm-2"></i>
                                    <span class="d-none d-sm-inline-block">Add New</span>
                                </span>
                            </button>
                        </a>
                    </div>
                </div>
                <table class=" border  table table-bordered dataTable no-footer dtr-column" id="user_datatable"
                    role="grid" aria-describedby="DataTables_Table_0_info" style="width: 1382px;">
                    <thead>
                        <tr role="row">
                            <th>Sl</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 162px;"
                                aria-label="Actions">Actions
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="/assets/vendor/libs/datatables/jquery.dataTables.js"></script>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('#user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('course.list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>

@endsection
