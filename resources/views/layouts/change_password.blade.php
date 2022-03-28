@extends('layouts.master')

@push('css')

@endpush

@section('page_title')
    Password Change
@endsection

@section('content')

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
                    <h6 class="card-title">Password Change</h6>
                    <form action="{{ route('authenticate.pass_change_submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter Current Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">New Confirm Password</label>
                                    <input type="password" class="form-control" name="new_confirm_password" id="new_confirm_password" placeholder="Enter New Confirm Password">
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary submit">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
