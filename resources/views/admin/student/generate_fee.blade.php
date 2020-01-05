@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add New Batch</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.student_generate_monthly_fee_insert']) }}
                       
                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                @if (isset($batch) && !empty($batch))
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Batch Name / Batch Year</label>
                                  <input type="text" class="form-control"  placeholder="Eg. 2020" value="{{ $batch->name}}" disabled>
                                  <input type="hidden" name="batch_id" value="{{$batch->id}}">
                                    @if($errors->has('batch_id'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('batch_id') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif
                                @if (isset($month) && !empty($month))
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Month</label>
                                    <select class="form-control" name="month_id" value="{{old('month_id')}}">
                                        <option value="">Please Select Month</option>
                                        @foreach ($month as $items)
                                            @if ($items->status == '1')
                                                <option value="{{$items->id}}">{{$items->month}}</option>
                                            @endif
                                        @endforeach                                        
                                    </select>
                                    @if($errors->has('month_id'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('month_id') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                 @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Generate Monthly Fees', array('class'=>'btn btn-success')) }}
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>Generate Monthly Fees</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Month</th>
                                    <th class="column-title">Batch Name</th>
                                    <th class="column-title">Status</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($month) && !empty($month))
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($month as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>{{$item->month}}</td>
                                    <td>{{$item->batch_name}}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            Fee Not Generated
                                        @else
                                            Fee Generated
                                        @endif
                                    </td>
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

@endsection