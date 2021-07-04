@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add New Expense</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.expense_item_add']) }}

                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3"></div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Expense Name</label>
                                  <input type="text" class="form-control" name="name"  placeholder="Enter Expense Name" value="{{ old('name')}}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    {{ Form::submit('Submit', array('class'=>'btn btn-success','style'=>'margin-top: 24px;')) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                        {{ Form::close() }}

                        <div class="table-responsive">
                            <h2>Expense Item List</h2>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">                
                                        <th class="column-title">Sl No. </th>
                                        <th class="column-title">Name</th>
                                        <th class="column-title">Date Added</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                                @if (isset($expense) && !empty($expense))
                                    @php
                                        $job_count = 1;
                                    @endphp
                                    @foreach ($expense as $item)
                                        <tr>
                                        <td>{{$job_count++}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        
                                        </tr>                              
                                    @endforeach
                                @endif
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>



    <div class="clearfix"></div>

</div>


@endsection
