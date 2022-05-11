@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
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

@section('page_title')
    Project Show
@endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Project Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-sm-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="text-center">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Software Name</label>
                                <input type="text" class="form-control" name="SoftwareName" id="SoftwareName"
                                    placeholder="Enter Software Name" value="{{ $project->SoftwareName }}" readonly>
                            </div>
                        </div>

                        @php
                            $data_array = [];
                            if (!empty($user_platform)) {
                                foreach ($user_platform as $row) {
                                    $data_array[] = $row['PlatformID'];
                                }
                            }
                        @endphp
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Software Platform</label>
                                <select class="form-control select2" name="SoftwarePlatform[]" id="SoftwarePlatform"
                                    multiple required disabled="disabled">
                                    <option value="">Select a platform</option>
                                    @foreach ($platform as $row)
                                        <option value='{{ $row->PlatformID }}' @php
                                            if (in_array($row->PlatformID, $data_array)) {
                                                echo 'selected';
                                            }
                                        @endphp>
                                            {{ $row->PlatformName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Unit</label>
                                    <input type="text" class="form-control" name="Unit" id="Unit"
                                        placeholder="Enter Unit">
                                </div>
                            </div> --}}

                        @php
                            $data_array = [];
                            if (!empty($user_departments)) {
                                foreach ($user_departments as $row) {
                                    $data_array[] = $row['DepartmentCode'];
                                }
                            }
                        @endphp
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                                <select class="form-control select2" name="SoftwareDepartment[]" id="SoftwareDepartment"
                                    multiple required disabled="disabled">
                                    <option value="">Select a department</option>
                                    @foreach ($departments as $row)
                                        <option value='{{ $row->DepartmentCode }}' @php
                                            if (in_array($row->DepartmentCode, $data_array)) {
                                                echo 'selected';
                                            }
                                        @endphp>
                                            {{ $row->DepartmentName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @php
                            $data_array = [];
                            if (!empty($user_developers)) {
                                foreach ($user_developers as $row) {
                                    $data_array[] = $row['DeveloperID'];
                                }
                            }
                        @endphp

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Developer</label>
                                <select class="form-control select2" name="SoftwareDeveloper[]" id="SoftwareDeveloper"
                                    multiple required disabled="disabled">
                                    <option value="">Select a developer</option>
                                    @foreach ($developers as $row)
                                        <option value='{{ $row->DeveloperID }}' @php
                                            if (in_array($row->DeveloperID, $data_array)) {
                                                echo 'selected';
                                            }
                                        @endphp>
                                            {{ $row->DeveloperName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Number of User</label>
                                <input type="text" class="form-control numeric" name="NumberOfUser" id="NumberOfUser"
                                    placeholder="Enter Number Of User" value="{{ $project->NumberOfUser }}" readonly />
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Implementation Date</label>
                                <input type="date" class="form-control" name="ImplementationDate" {{-- id="datePickerEdit" --}}
                                    placeholder="Enter Implementation Date" {{-- value="{{ date('Y-m-d', strtotime($project->ImplementationDate)) }}" --}}
                                    value="<?php echo $project->ImplementationDate != '1970-01-01 00:00:00.000' ? date('Y-m-d', strtotime($project->ImplementationDate)) : ''; ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Person</label>
                                <input type="text" class="form-control" name="ContactPerson" id="ContactPerson"
                                    placeholder="Enter Contact Person" value="{{ $project->ContactPerson }}" readonly />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <select class="form-control mb-3" name="StatusID" required disabled="disabled">
                                    @foreach ($status as $row)
                                        <option value='{{ $row->StatusID }}' @php
                                            if (isset($project->StatusID) && $project->StatusID == $row->StatusID) {
                                                echo 'selected';
                                            }
                                        @endphp>
                                            {{ $row->StatusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" name="Description" rows="3"
                                    disabled="disabled">{{ $project->Description }}</textarea>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Time Frame</label>
                                <select class="form-control mb-3" name="TimeFrameID" required disabled="disabled">
                                    <option value=''>Select</option>
                                    @foreach ($time_frame as $row)
                                        <option value='{{ $row->TimeFrameID }}' @php
                                            if (isset($project->TimeFrameID) && $project->TimeFrameID == $row->TimeFrameID) {
                                                echo 'selected';
                                            }
                                        @endphp>
                                            {{ $row->TimeFrameName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Value</label>
                                <input type="text" class="form-control" name="Value" id="Value" placeholder="Enter Value"
                                    value="{{ $project->Value }}" readonly />
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-primary" onclick="goBack()">Go Back</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/datepicker_edit_custom.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                closeOnSelect: false
            });
        });
    </script>
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endpush
