@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>Batch List</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Name</th>
                                    <th class="column-title">Start Date</th>
                                    <th class="column-title">End Date</th>
                                    <th class="column-title">Date Added</th> 
                                    <th class="column-title">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($batch) && !empty($batch))
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($batch as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->start_date}}</td>
                                    <td>{{$item->end_date}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="{{route('admin.Batch_fee_status',['batch_id'=>encrypt($item->id)])}}" class="btn btn-info">View Fee Status</a>
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