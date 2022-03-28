@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
@endpush

@section('page_title')
    User Create
@endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('usermanager.index') }}">User Manager</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Create</li>
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
                    <h6 class="card-title">User Form</h6>
                    <form action="{{ route('usermanager.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="UserID">User ID</label>
                                    <input type="text" placeholder="UserID"
                                           class="form-control @error('UserID') is-invalid @enderror" name="UserID"
                                           value="{{ old('UserID') }}">
                                    @error('UserID')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="UserName">User Name</label>
                                    <input type="text" placeholder="UserName"
                                           class="form-control @error('UserName') is-invalid @enderror" name="UserName"
                                           value="{{ old('UserName') }}" required>
                                    @error('UserName')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Designation">Designation</label>
                                    <input type="text" placeholder="Designation"
                                           class="form-control @error('Designation') is-invalid @enderror" name="Designation"
                                           value="{{ old('Designation') }}" required>
                                    @error('Designation')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Email">Email address</label>
                                    <input type="email" placeholder="Email"
                                           class="form-control @error('Email') is-invalid @enderror" name="Email"
                                           value="{{ old('Email') }}" required >
                                    @error('Email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" placeholder="Password"
                                           class="form-control  @error('Password') is-invalid @enderror" name="Password"
                                           required autocomplete="new-password">
                                    @error('Password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Password_Confirm">Confirm Password</label>
                                    <input id="Password_Confirm" type="password" class="form-control" name="Password_Confirm"
                                           required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <select class="form-control mb-3" name="Active" required>
                                        <option value="Y">Active</option>
                                        <option value="N">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label">Menu Permissions</label>
                            </div>
                            <div class="col-sm-10 row">
                                @foreach($permissions as $row)
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="Menu[]" value="{{ $row }}">
                                                {{ $row }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/datepicker_custom.js') }}"></script>
@endpush
