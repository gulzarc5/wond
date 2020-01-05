@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>Employee List</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Name</th>
                                    <th class="column-title">Mobile</th>
                                    <th class="column-title">Email</th>
                                    <th class="column-title">Designation</th>
                                    <th class="column-title">Salary</th> 
                                    <th class="column-title">Status</th> 
                                    <th class="column-title">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($employee) && !empty($employee))
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($employee as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->mobile}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->designation}}</td>
                                    <td>{{ number_format($item->salary,2,".",'') }}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            <a class="btn btn-success">Enabled</a>
                                        @else
                                            <a class="btn btn-danger">Disabled</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('admin.edit_employee',['emp_id'=>encrypt($item->id)])}}" class="btn btn-warning">Edit</a>
                                        @if ($item->status == '1')
                                            <a class="btn btn-danger" href="{{route('admin.status_employee',['emp_id'=>encrypt($item->id),'status'=>encrypt(2)])}}">Disable</a>
                                        @else
                                            <a class="btn btn-success" href="{{route('admin.status_employee',['emp_id'=>encrypt($item->id),'status'=>encrypt(1)])}}">Enable</a>
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