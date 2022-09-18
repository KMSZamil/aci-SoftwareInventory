@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 20px !important;
            padding-left: 0px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #fff transparent transparent transparent !important;
            border-style: solid;
            margin-top: -8px !important;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #ffffff;
            border: 0;
            border-radius: 3px;
            padding: 6px;
            font-size: .625rem;
            font-family: inherit;
            line-height: 1;
            background: #727cf5;
        }
    </style>
@endpush

@section('page_title') Department wise report @endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Department wise report</li>
        </ol>
    </nav>
     @php
        $departments = all_department();
     @endphp
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Choose department to generate report</h6>
                    <form action="{{ route('department_wise_report') }}" method="get">
                        <div class="row">
                            <div class="col form-inline">
                                <div class="form-group">
                                    <label class="control-label">Department</label>
                                    <select style="min-width: 400px;" class="form-control select2" name="SoftwareDepartment[]" id="SoftwareDepartment"
                                        multiple required>
                                        <option value="">Select a department</option>
                                        @foreach ($departments as $row)
                                            <option 
                                            value='{{ $row->DepartmentCode }}'
                                            {{ isset($department) && in_array($row->DepartmentCode,$department) ? 'selected' : '' }}
                                            >
                                            {{ $row->DepartmentName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">&nbsp;&nbsp;</label>
                                    <input type="submit" class="btn btn-primary" value="Show Report">
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    @if(isset($projects))
                        @include('report.html.dwr',['projects' => $projects])
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('js/datatable_custom.js') }}"></script>

    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/datepicker_custom.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                closeOnSelect: false
            });
        });

        $(function() {
            $('.select2Single').select2();
        });
        
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'print'
            ]
        });
    </script>
@endpush
