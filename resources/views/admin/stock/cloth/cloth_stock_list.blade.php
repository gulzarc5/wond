@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>Cloth STock List</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Cloth Type</th>
                                    <th class="column-title">Size</th>
                                    <th class="column-title">Stock</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($cloth_stock_list) && !empty($cloth_stock_list))
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($cloth_stock_list as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>
                                        @if ($item->cloth_type == '1')
                                            T-Shirt
                                        @else
                                            Track Pant
                                        @endif
                                    </td>
                                    <td>{{$item->size_name}}</td>
                                    <td>{{$item->stock}}</td>
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