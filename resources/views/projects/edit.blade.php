@extends('layouts.master')

@push('css')
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

@section('page_title')
    Project Edit
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
                    <h6 class="card-title">Project Form</h6>
                    <form action="{{ route('projects.update', $project->SoftwareID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Software Name</label>
                                    <input type="text" class="form-control" name="SoftwareName" id="SoftwareName"
                                        placeholder="Enter Software Name" value="{{ $project->SoftwareName }}">
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
                                    <select class="form-control select2Single" name="SoftwarePlatform[]"
                                        id="SoftwarePlatform" required>
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
                                        multiple required>
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
                                        multiple required>
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
                                        placeholder="Enter Number Of User" value="{{ $project->NumberOfUser }}" />
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Implementation Date</label>
                                    <input type="date" class="form-control" name="ImplementationDate"
                                        {{-- id="datePickerEdit" --}} placeholder="Enter Implementation Date" {{-- value="{{ date('Y-m-d', strtotime($project->ImplementationDate)) }}" --}}
                                        value="<?php echo $project->ImplementationDate != '1970-01-01 00:00:00.000' && $project->ImplementationDate != null ? date('Y-m-d', strtotime($project->ImplementationDate)) : ''; ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Contact Person</label>
                                    <input type="text" class="form-control" name="ContactPerson" id="ContactPerson"
                                        placeholder="Enter Contact Person" value="{{ $project->ContactPerson }}" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <select class="form-control mb-3" name="StatusID" required>
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
                                    <textarea class="form-control" name="Description" rows="6">{{ $project->Description }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Time Frame</label>
                                    <select class="form-control mb-3" name="TimeFrameID">
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
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Value</label>
                                    <input type="text" class="form-control" name="Value" id="Value"
                                        placeholder="Enter Value" value="{{ $project->Value }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div id="reload" class="form-group row">
                                        <div id='category_div' style="border: #0000FF 0px solid; float: left; width: 100%;">
                                            <div style="border: 0px solid #d1dceb; float: left; width: 99%; background-color: #e8ebf0;">
                                                <div style="border: #0000FF 0px solid; float: left; width: 100%; ">
                                                    <div style="float: left; width:100%; padding: 5px; padding-left: 5px; border-right: 1px solid #bbb;">Modification</div>
                                                </div>
                                            </div>
                                            <div style="border: 0px solid #d1dceb; float: left; width: 99%;">
                                                <div style="border: #0000FF 0px solid; float: left; width: 100%;">
                                                    <input type="text" style="float: left; width:100%; font-size:12px;" class="form-control typeahead" id="inputDistributor" name="Modification[]" placeholder="Modification">
                                                    <input type="hidden" style="float: left;" class="form-control" id="
                                                    " name="DistributorCode[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div>&nbsp;</div>
                                        <div style="border: #f00 0px solid; float: left; width: 99%; margin-top: 15px;">
                                            <div style="border: #f00 0px solid; float: right;">
                                                <div class="form-row" style="padding-top: 30px;">
                                                    <div class="col">
                                                        <a id="addButton" href="javascript:;" class="btn btn-success">
                                                            &nbsp;&nbsp;Add&nbsp;&nbsp;
                                                        </a>
                                                        <a id="removeButton" href="javascript:;" class="btn btn-danger">
                                                            Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary submit">Update Software</button>
                    </form>
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

        $(function() {
            $('.select2Single').select2();
        });
    </script>
        <script>
            $( function() {
                $( "#inputDistributor" ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url: "",
                            type: 'post',
                            dataType: "json",
                            data: {
                                search: request.term,
                                _token : $('meta[name=\'csrf-token\']').attr('content')
                            },
                            success: function( data ) {
                                //console.log(data);
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#inputDistributor').val(ui.item.label);
                        $('#DistributorCode_1').val(ui.item.DistributorCode);
                        return false;
                    }
                });
            });
        </script>
    
        <script>
            $count = 2;
            $(function () {
                $('#addButton').click(function(){
                    $category = $("<div id='TextBoxDiv"+$count+"' style='border: 0px solid #d1dceb; float: left; width: 99%;'>\n\
                            <div style='border: #0000FF 0px solid; float: left; width: 100%;'>\n\
                            <input type='text' style='float: left; width:100%; font-size:12px;' class='form-control typeahead' id='inputDistributor_" + $count + "' name='Modification[]' placeholder='Modification' required>\n\
                            <input type='hidden' style='float: left;' class='form-control' id='DistributorCode_" + $count + "' name='DistributorCode[]'>\n\
                            </div>\n\
                        </div>");
    
                    $('#category_div').append($category);
    
                    $('.typeahead').click(function ()
                    {
                        //alert("dd");
                        var ProductCodeIdString = $(this).attr('id');
                        var ProductCodeIdNo = ProductCodeIdString.substr(ProductCodeIdString.indexOf("_") + 1);
    
                        $( "#inputDistributor_" + ProductCodeIdNo  ).autocomplete({
                            source: function( request, response ) {
                                $.ajax({
                                    url: "",
                                    type: 'post',
                                    dataType: "json",
                                    data: {
                                        search: request.term,
                                        _token : $('meta[name=\'csrf-token\']').attr('content')
                                    },
                                    success: function( data ) {
                                        //console.log(data);
                                        response( data );
                                    }
                                });
                            },
                            select: function (event, ui) {
                                $('#inputDistributor_'+ProductCodeIdNo).val(ui.item.label);
                                $('#DistributorCode_'+ProductCodeIdNo).val(ui.item.DistributorCode);
                                return false;
                            }
                        });
                    });   
    
                    $count++;
                });
    
                $("#removeButton").click(function () {
                    if ($count == 1) {
                        alert("No more textbox to remove");
                        return false;
                    }
                    $count--;
                    $("#TextBoxDiv" + $count).remove();
                    $("#TextBoxDiv" + $count).hide();
                    calcTotal();
                });
    
            });
    
        </script>
@endpush
