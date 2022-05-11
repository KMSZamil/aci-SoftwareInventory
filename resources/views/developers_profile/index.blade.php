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
        </ol>
    </nav>

    <div class="row">

        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                @foreach ($developers as $developer)
                    <div class="col-md-3 col-lg-3 col-sm-3 grid-margin stretch-card">
                        <div class="card">
                            {{-- <a href="{{ route('developers_details', $developer->UserID) }}" style="color: inherit;"> --}}
                            <div class="card-body">
                                <div class=" image d-flex flex-column justify-content-center align-items-center">
                                    <button class="btn btn-secondary">
                                        <img style="border-radius: 10%"
                                            src="data:image/png;base64,{{ base64_encode($developer->Photo) }}"
                                            height="100" width="100" />
                                    </button>
                                    <span class="name mt-3">Staff ID: {{ $developer->UserID }}</span>
                                    <span class="name mt-3">Name: {{ $developer->UserName }}</span>
                                    <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span
                                            class="idd1">Designation: {{ $developer->Designation }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-center align-items-center"> <span
                                            class="number">Total Project:
                                            {{ $developer->TotalCount }}</span>&nbsp;<span class="number">New:
                                            {{ $developer->TotalNewCount }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-center align-items-center"> <span
                                            class="number">Pipeline:
                                            {{ $developer->TotalPipelineCount }}</span>&nbsp;<span
                                            class="number">InProgress:
                                            {{ $developer->TotalInprogressCount }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-center align-items-center"> <span
                                            class="number">Complete:
                                            {{ $developer->TotalCompleteCount }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- </a> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
    <script src="{{ asset('js/datatable_custom.js') }}"></script>
@endpush
