@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>List Of Classes</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Class</th>
                                    <th class="column-title">Medium</th>
                                    <th class="column-title">Monthly Fees</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title">Date Added</th> 
                                    <th class="column-title">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($class) && !empty($class))
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($class as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if ($item->medium == '1')
                                            Bengali
                                        @else
                                            English
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->monthly_fees,2,".",'') }}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            <a class="btn btn-success">Enabled</a>
                                        @else
                                        <a class="btn btn-success">Disabled</a>
                                        @endif
                                    </td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="{{route('admin.class_edit_form',['class_id'=>encrypt($item->id)])}}" class="btn btn-warning">Edit</a>
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