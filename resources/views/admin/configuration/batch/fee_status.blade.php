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