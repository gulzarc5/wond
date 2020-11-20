@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Search Student Class Wise</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.expense_search']) }}
                            <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="batch">From Date</label>
                                    <input type="date" class="form-control" name="from_date" required>
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">To Date</label>
                                    <input type="date" class="form-control" name="to_date" required>
                                    
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Expense Type</label>
                                    <select class="form-control" name="expense_id" >
                                        <option value="" selected>Please Select Class</option>
                                        @if (isset($expense) && !empty($expense))
                                            @foreach ($expense as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                   
                                </div> 

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3" style="display:flex;justify-content:center;">
                                    <input class="btn btn-info" type="submit" value="Search" style="margin-top: 23px;width: 116px;">
                                </div>

                            </div>
                        </div>
                        <div class="form-group" style="display:flex; justify-content:center">
                            
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($expense_report) && !empty($expense_report))
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        {{--//////////// Last Ten Sellers //////////////--}}
                        <div class="table-responsive">
                            <h2>Expense Details</h2>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">  
                                        <th  class="column-title">Sl</th>
                                        <th  class="column-title">Expense Name</th>
                                        <th  class="column-title">Amount</th>
                                        <th  class="column-title">Comment</th>
                                        <th  class="column-title">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $job_count = 1;
                                        $total_amount = 0;
                                    @endphp
                                    @foreach ($expense_report as $item)
                                        <tr>
                                        <td>{{$job_count++}}</td>
                                        <td>{{$item->expense_name}}</td>
                                        <td>{{$item->amount}}</td>
                                        <td>{{$item->comment}}</td>
                                        <td>{{$item->created_at}}</td>
                                        </tr>    
                                        @php
                                            $total_amount += $item->amount;
                                        @endphp                          
                                    @endforeach    
                                    <tr>
                                        <td colspan="2" align="right">Total Expense</td>
                                        <td  colspan="3">{{$total_amount}}</td>
                                    </tr>                             
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="x_panel">

                    <div class="x_title">
                        <h2>Expense Detail List</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="x_content">
                            <table id="size_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Sl</th>
                                <th>Expense Name</th>
                                <th>Amount</th>
                                <th>Comment</th>
                                <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>                       
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    

    
</div>


@endsection

@section('script')
@if (isset($expense_report) && !empty($expense_report))   
@else
     <script type="text/javascript">
         $(function () {    
            var table = $('#size_list').DataTable({
                processing: true,
                serverSide: true,                
                iDisplayLength: 50,
                ajax: "{{ route('admin.expense_details_list_ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'expense_name', name: 'expense_name',searchable: true},
                    {data: 'amount', name: 'amount',searchable: true},
                    {data: 'comment', name: 'comment',searchable: true}, 
                    {data: 'created_at', name: 'created_at',searchable: true},   
                ]
            });
            
        });
    </script>
@endif
    
 @endsection