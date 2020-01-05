@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Edit Cloth Size</h2>
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
                    @if (isset($cloth_size) && !empty($cloth_size))   
                        {{ Form::open(['method' => 'post','route'=>'admin.update_cloth_size']) }}

                        <input type="hidden" name="size_id" value="{{$cloth_size->id}}">
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                    <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Cloth Type</label>
                                    <select class="form-control" name="type">
                                        <option value="">Please Select Size</option>
                                        <option value="1" {{ $cloth_size->cloth_type == 1 ? 'selected' : '' }}>T-Shirt</option>
                                        <option value="2" {{ $cloth_size->cloth_type == 2 ? 'selected' : '' }}>Track Pant</option>
                                    </select>
                                    @if($errors->has('type'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Size Name</label>
                                    <input type="text" class="form-control" name="name"  placeholder="Enter Cloth Size" value="{{ $cloth_size->name }}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Save', array('class'=>'btn btn-success')) }}
                            <a href="{{route('admin.cloth_size_list')}}" class="btn btn-warning">Back</a>
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
