@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables_btn/buttons.dataTables.min.css') }}">
@endpush

@section('page_title')
    Projects
@endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">Project List</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10 text-left">
                            <a href="{{ route('excel.project_export') }}">
                                <button type="button" class="btn btn-primary mb-2 text-right">Projects Export</button>
                            </a>
                        </div>
                        <div class="col-2 text-right">
                            <a href="{{ route('projects.create') }}">
                                <button type="button" class="btn btn-primary mb-2 text-right">Create Project</button>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <div class="form-group row">
                                <label class="control-label col-sm-3">Date From</label>
                                <input type="date" name="FromDate" id="FromDate" class="form-control"
                                    value="{{ date('Y-m-01') }}">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <div class="form-group row">
                                <label class="control-label col-sm-3">Date To</label>
                                <input type="date" name="ToDate" id="ToDate" class="form-control"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-sm-2 col-sm-2 col-xs-2 pt-5">
                            <input type="submit" class="button-create filter btn btn-primary" value="Filter">
                        </div>

                    </div>


                    <h6 class="card-title">Project Data</h6>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Software Name</th>
                                    <th>Status</th>
                                    <th>Platform</th>
                                    <th>Department</th>
                                    <th>Number of User</th>
                                    <th>Implementation Date</th>
                                    <th>Contact Person</th>
                                    <th>Developer</th>
                                    <th>Description</th>
                                    <th>Delivery Date</th>
                                    <th>Area Of Concern</th>
                                    <th>Benefit</th>
                                    <th>Impact Area</th>
                                    <th>Entry Date</th>
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
        // $(function() {
        //     var table = $('#datatable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('projects.index') }}",
        //         columns: [
        //             // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        //             {
        //                 data: 'SoftwareName',
        //                 name: 'SoftwareName'
        //             },
        //             {
        //                 data: 'Status',
        //                 name: 'Status'
        //             },

        //             {
        //                 data: 'platform_name',
        //                 name: 'platform_name'
        //             },
        //             {
        //                 data: 'department_name',
        //                 name: 'department_name'
        //             },
        //             {
        //                 data: 'NumberOfUser',
        //                 name: 'NumberOfUser'
        //             },
        //             {
        //                 data: 'ImplementationDate',
        //                 name: 'ImplementationDate'
        //             },
        //             {
        //                 data: 'ContactPerson',
        //                 name: 'ContactPerson'
        //             },

        //             {
        //                 data: 'developer_name',
        //                 name: 'developer_name'
        //             },
        //             {
        //                 data: 'Description',
        //                 name: 'Description'
        //             },

        //             {
        //                 data: 'DeliveryDate',
        //                 name: 'DeliveryDate'
        //             },
        //             {
        //                 data: 'AreaOfConcern',
        //                 name: 'AreaOfConcern'
        //             },
        //             {
        //                 data: 'Benefit',
        //                 name: 'Benefit',                      
        //             },
        //             {
        //                 data: 'ImpactArea',
        //                 name: 'ImpactArea'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ],
        // createdRow: function(row, data, index) {
        //     $('td', row).eq(4).addClass('text-right');

        // },
        //         // dom: 'Bfrtip',
        //         // buttons: [
        //         //     'copy', 'csv', 'excel', 'print'
        //         // ]
        //     });

        // });

        //Added By Mahbub
        $(function() {

            load_data();

            function load_data(FromDate = '', toDate = '') {
                var table = $('.table-bordered').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "autoWidth": false,
                    order: [
                        [13, 'desc']
                    ],
                    ajax: {
                        url: '{{ route('projects.index') }}',
                        data: {
                            FromDate: FromDate,
                            ToDate: toDate
                        }
                    },
                    columns: [{
                            data: 'SoftwareName',
                            name: 'SoftwareName'
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
                            data: 'developer_name',
                            name: 'developer_name'
                        },
                        {
                            data: 'Description',
                            name: 'Description'
                        },

                        {
                            data: 'DeliveryDate',
                            name: 'DeliveryDate'
                        },
                        {
                            data: 'AreaOfConcern',
                            name: 'AreaOfConcern'
                        },
                        {
                            data: 'Benefit',
                            name: 'Benefit',
                        },
                        {
                            data: 'ImpactArea',
                            name: 'ImpactArea'
                        },
                        {
                            data: 'EntryDate',
                            name: 'EntryDate'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    createdRow: function(row, data, index) {
                        $('td', row).eq(4).addClass('text-right');

                    },
                });
            }

            $('body').on('click', '.filter', function(e) {
                e.preventDefault();

                var from = $('#FromDate').val();
                var to = $('#ToDate').val();
                console.log(from)
                console.log(to)
                if (from != '' && to != '') {
                    $('.table-bordered').DataTable().destroy();
                    load_data(from, to);
                } else {
                    alert('Both Date is required');
                }
            });


        });
    </script>
    <script>
        function deleteConfirmation(id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('projects.destroy', '_id') }}".replace('_id', id),
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        dataType: 'JSON',
                        success: function(results) {
                            //console.log(data); return false;
                            if (results.success === true) {
                                swal.fire("Successfully deleted", results.message, "success").then(
                                    function() {
                                        window.location = "{{ route('projects.index') }}";
                                    });
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                } else {
                    e.dismiss;
                }
            })
        }
    </script>
@endpush
