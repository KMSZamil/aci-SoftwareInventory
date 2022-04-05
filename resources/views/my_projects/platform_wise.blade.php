@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables_btn/buttons.dataTables.min.css') }}">
@endpush

@section('page_title')
    Platform Wise Projects
@endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Projects</li>
            <li class="breadcrumb-item active" aria-current="page">Platform Wise Projects</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Platform Wise Projects</h6>
                    <div class="table-responsive">
                        <table id="dataTableExampleCsv" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Software Name</th>
                                    <th>PlatformName</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td> {{ $row->SoftwareName }} </td>
                                        <td> {{ $row->PlatformName }} </td>
                                        <td> {{ $row->Description }} </td>
                                        <td> {{ $row->StatusName }} </td>
                                    </tr>
                                @endforeach
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
@endpush
