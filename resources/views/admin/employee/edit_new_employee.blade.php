@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Edit Employee</h2>
                    <div class="clearfix"></div>
                </div>

                 <div>
                    @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div>
                    <div class="x_content">
                        @if (isset($employee) && !empty($employee))
                        {{ Form::open(['method' => 'post','route'=>'admin.update_employee']) }}
                        <input type="hidden" name="id" value="{{$employee->id}}">
                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Employee Name</label>
                                  <input type="text" class="form-control" name="name"  placeholder="Enter Employee name" value="{{ $employee->name }}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile"  placeholder="Enter Employee Mobile Number" value="{{ $employee->mobile}}" >
                                    @if($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email"  placeholder="Enter Employee Email Id" value="{{ $employee->email }}" >
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control" name="designation"  placeholder="Enter Employee Designation" value="{{ $employee->designation }}" >
                                    @if($errors->has('designation'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('designation') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="salary">Monthly Salary</label>
                                    <input type="number" class="form-control" name="salary"  placeholder="Enter Monthly Salary" value="{{ $employee->salary }}" >
                                    @if($errors->has('salary'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('salary') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="qualification">Highest Qualification</label>
                                    <input type="text" class="form-control" name="qualification"  placeholder="Enter Highest Qualification" value="{{ $employee->qualification }}" >
                                    @if($errors->has('qualification'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('qualification') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Save', array('class'=>'btn btn-success')) }}
                            <a href="{{route('admin.employee_list')}}" class="btn btn-warning">Back</a>
                        </div>
                        {{ Form::close() }}
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>


@endsection
