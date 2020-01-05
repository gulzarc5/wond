@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add New Cloth Size</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.add_cloth_size']) }}

                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Cloth Type</label>
                                    <select class="form-control" name="type">
                                        <option value="">Please Select Size</option>
                                        <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>T-Shirt</option>
                                        <option value="2" {{ old('type') == 1 ? 'selected' : '' }}>Track Pant</option>
                                    </select>
                                    @if($errors->has('type'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Size Name</label>
                                  <input type="text" class="form-control" name="name"  placeholder="Enter Cloth Size" value="{{ old('name')}}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>


@endsection
