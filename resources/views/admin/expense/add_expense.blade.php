@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-2" style="margin-top:50px;display:flex;justify-content:center;"></div>
        <div class="col-md-8" style="margin-top:50px;display:flex;justify-content:center;">
            <div class="x_panel">

                 <div>
                    @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div>
                    <div class="x_content">
                        {{ Form::open(['method' => 'post','route'=>'admin.expense_add']) }}
                        <h2>Receive Student Fees</h2>
                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                  <label for="expense_id">Select Expense Type</label>
                                  <select class="form-control" name="expense_id" >
                                    <option value="">---Select Expense Type-</option>
                                    @if (isset($expense) && !empty($expense))
                                        @foreach ($expense as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    @endif
                                  </select>
                                    @if($errors->has('expense_id'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('expense_id') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="amount">Enter Expense Amount</label>
                                    <input type="number" cast="any" class="form-control" name="amount"  placeholder="Enter Amount In RS.">
                                    @if($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <button type="submit" class="btn btn-info" style="margin-top: 12px;">Submit</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
@endsection