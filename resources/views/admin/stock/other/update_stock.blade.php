@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>Other Stock Update</h2>
                        @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                        @endif @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif
                        {{ Form::open(['method' => 'post','route'=>'admin.otherStockUpdate']) }}

                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">                
                                        <th class="column-title">Sl No. </th>
                                        <th class="column-title">Name</th>
                                        <th class="column-title">Stock</th>         
                                        <th class="column-title">New Stock</th>                             
                                    </tr>
                                </thead>
                                <tbody>
                                @if (isset($stock) && !empty($stock))
                                    @php
                                        $job_count = 1;
                                    @endphp
                                    @foreach ($stock as $item)
                                        <tr>
                                            <td>{{$job_count++}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->stock}}</td>
                                            <td>
                                                <input type="text" name="stock[]"/>
                                                <input type="hidden" name="id[]" value="{{$item->id}}"/>
                                            </td>                                        
                                        </tr>                              
                                    @endforeach
                                @endif
                                        <tr>
                                            <td colspan="4"><button class="btn btn-success">Update Stock</button></td>
                                        </tr>
                                </tbody>
                            </table>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection