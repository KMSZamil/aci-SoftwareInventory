@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables_btn/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">New Project</h6>

                            </div>

                            
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 1) }}">
                                    <div class="col-6 col-md-12 ">
                                        <h3 class="mb-2 pt-4">{{ number_format(get_project_count(1)) }}</h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Completed Project</h6>

                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 2) }}">
                                    <div class="col-6 col-md-12 ">
                                        <h3 class="mb-2 pt-4">{{ number_format(get_project_count(4)) }}</h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Ongoing Project</h6>

                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 3) }}">
                                    <div class="col-6 col-md-12 ">
                                        <h3 class="mb-2 pt-4">{{ number_format(get_project_count(2)) }}</h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Pipeline Project</h6>

                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 2) }}">
                                    <div class="col-6 col-md-12 ">
                                        <h3 class="mb-2 pt-4">{{ number_format(get_project_count(3)) }}</h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Desktop Project</h6>
                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 1) }}">
                                    <div class="col-6 col-md-12">
                                        <h3 class="mb-2 pt-4">{{ number_format(get_project_platform_wise_count(1)) }}
                                        </h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Web Project</h6>

                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 2) }}">
                                    <div class="col-6 col-md-12">
                                        <h3 class="mb-2 pt-4">
                                            {{ number_format(get_project_platform_wise_count(2)) }}
                                        </h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Mobile Project</h6>

                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 3) }}">
                                    <div class="col-6 col-md-12">
                                        <h3 class="mb-2 pt-4">
                                            {{ number_format(get_project_platform_wise_count(3)) }}
                                        </h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Web + Mobile Project</h6>
                            </div>
                            <div class="row">
                                <a href="{{ route('my_project.platform_wise', 4) }}">
                                    <div class="col-6 col-md-12">
                                        <h3 class="mb-2 pt-4">
                                            {{ number_format(get_project_platform_wise_count(4)) }}
                                        </h3>
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                                <span></span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Developer Wise Project Count</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>UserID</th>
                                    <th>UserName</th>
                                    <th class="text-center">Total Project</th>
                                    <th class="text-center">New</th>
                                    <th class="text-center">Pipeline</th>
                                    <th class="text-center">In Progress</th>
                                    <th class="text-center">Complete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($developer_wise_count as $row)
                                    <tr>
                                        <td>{{ $row->UserID }}</td>
                                        <td>{{ $row->UserName }}</td>
                                        <td class="text-right">{{ $row->TotalCount }}</td>
                                        <td class="text-right">{{ $row->TotalNewCount }}</td>
                                        <td class="text-right">{{ $row->TotalPipelineCount }}</td>
                                        <td class="text-right">{{ $row->TotalInprogressCount }}</td>
                                        <td class="text-right">{{ $row->TotalCompleteCount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Department Wise Project Count</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Department Name</th>
                                    <th class="text-center">Total Project</th>
                                    <th class="text-center">New</th>
                                    <th class="text-center">Pipeline</th>
                                    <th class="text-center">In Progress</th>
                                    <th class="text-center">Complete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department_wise_count as $row)
                                    <tr>
                                        <td>{{ $row->DepartmentName }}</td>
                                        <td class="text-right">{{ $row->TotalCount }}</td>
                                        <td class="text-right">{{ $row->TotalNewCount }}</td>
                                        <td class="text-right">{{ $row->TotalPipelineCount }}</td>
                                        <td class="text-right">{{ $row->TotalInprogressCount }}</td>
                                        <td class="text-right">{{ $row->TotalCompleteCount }}</td>
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
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables_btn/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatable_custom.js') }}"></script>

    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
@endpush
