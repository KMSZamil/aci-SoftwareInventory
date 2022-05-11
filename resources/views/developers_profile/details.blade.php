@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables_btn/buttons.dataTables.min.css') }}">
@endpush

@section('page_title')
    Developers Profile
@endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Projects</li>
            <li class="breadcrumb-item active" aria-current="page">Developers Profile</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user_data->UserName }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10 text-left">
                            <a href="{{ route('excel.my_project_export') }}">
                                <button type="button" class="btn btn-primary mb-2 text-right">Projects Export</button>
                            </a>
                        </div>
                    </div>

                    <h6 class="card-title">Projects</h6>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Software Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Platform</th>
                                    <th>Developer</th>
                                    <th>Department</th>
                                    <th>Number of User</th>
                                    <th>Implementation Date</th>
                                    <th>Contact Person</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatable_custom.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('developers_profile') }}",
                columns: [
                    // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {
                        data: 'SoftwareName',
                        name: 'SoftwareName'
                    },
                    {
                        data: 'Description',
                        name: 'Description'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },

                    {
                        data: 'platform_name',
                        name: 'platform_name'
                    },
                    {
                        data: 'developer_name',
                        name: 'developer_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'NumberOfUser',
                        name: 'NumberOfUser'
                    },
                    {
                        data: 'ImplementationDate',
                        name: 'ImplementationDate'
                    },
                    {
                        data: 'ContactPerson',
                        name: 'ContactPerson'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data, index) {
                    $('td', row).eq(6).addClass('text-right');

                },
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'print'
                // ]
            });

        });
    </script>
@endpush
