@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add New Class</h2>
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
                    @if (isset($class) && !empty($class))   
                        {{ Form::open(['method' => 'post','route'=>'admin.class_update']) }}

                        <input type="hidden" name="class_id" value="{{$class->id}}">
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Class Name</label>
                                  <input type="text" class="form-control" name="name"  placeholder="Enter Class name" value="{{$class->name}}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="tag_name">Select Medium</label>
                                  <select class="form-control" name="medium">
                                    <option value="1" {{ $class->medium == 1 ? 'selected' : '' }}>Bengali</option>
                                    <option value="2" {{ $class->medium == 2 ? 'selected' : '' }}>English</option>
                                  </select>
                                  @if($errors->has('medium'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('medium') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-10">

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="size_wearing">Monthly Fees</label>
                                <input type="number" class="form-control" name="fees"  placeholder="Enter Monthly Fees" value="{{$class->monthly_fees}}" >

                                  @if($errors->has('fees'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('fees') }}</strong>
                                        </span>
                                    @enderror
                                </div>                                                             
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Save', array('class'=>'btn btn-success')) }}
                            <a href="{{route('admin.class_list')}}" class="btn btn-warning">Back</a>
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
