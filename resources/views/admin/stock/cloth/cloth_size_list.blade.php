@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>List Of Cloth Sizes</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Cloth Type</th>
                                    <th class="column-title">Size</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($cloth_size) && !empty($cloth_size))
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($cloth_size as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>
                                        @if ($item->cloth_type == '1')
                                            T-Shirt
                                        @else
                                            Track Pant
                                        @endif
                                    </td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            <a class="btn btn-success">Enabled</a>
                                        @else
                                        <a class="btn btn-danger">Disabled</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('admin.edit_cloth_size',['class_id'=>encrypt($item->id)])}}" class="btn btn-warning">Edit</a>
                                        @if ($item->status == '1')
                                            <a class="btn btn-danger" href="{{route('admin.status_cloth_size',['size_id'=>$item->id,'status'=>2])}}">Disable</a>
                                        @else
                                        <a class="btn btn-success" href="{{route('admin.status_cloth_size',['size_id'=>$item->id,'status'=>1])}}">Enable</a>
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