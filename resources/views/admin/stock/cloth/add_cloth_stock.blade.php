@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add Cloth Stock</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.add_Stock']) }}

                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-6">

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Cloth Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="">Please Select Cloth Type</option>
                                        <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>T-Shirt</option>
                                        <option value="2" {{ old('type') == 1 ? 'selected' : '' }}>Track Pant</option>
                                    </select>
                                    @if($errors->has('type'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="cloth_size">Select Cloth Size</label>
                                    <select class="form-control" name="cloth_size" id="cloth_size">
                                        <option value="">Please Select Size</option>
                                    </select>
                                    @if($errors->has('cloth_size'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('cloth_size') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="stock_view"></div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                  <label for="quantity">Enter Quantity</label>
                                  <input type="text" class="form-control" name="quantity"  placeholder="Enter Cloth Quantity" value="{{ old('quantity')}}" >
                                    @if($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#type").change(function(){
                var type = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:"GET",
                    url:"{{ url('admin/Cloth/size/ajax/')}}"+"/"+type+"",
                    success:function(data){
                        console.log(data);
                        if (data.length > 0) {
                            $("#cloth_size").html('<option value="">Please Select Size</option>');
                            $.each( data, function( key, value ) {
                                
                                $("#cloth_size").append("<option value='"+value.id+"'>"+value.name+"</option>");
                            });
                        }                        
                    }
                }); 
            });
        });

        $("#cloth_size").change(function(){
            clothStockFetch(); 
        });


        function clothStockFetch(){
            var type = $("#type").val();
            var cloth_size = $("#cloth_size").val();
                if (type && cloth_size) {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                $.ajax({
                    type:"GET",
                    url:"{{ url('admin/Cloth/stock/fetch/ajax/')}}"+"/"+type+"/"+cloth_size,
                    success:function(data){
                        console.log(data);
                        $("#stock_view").html('<h3 style="color:blue">Stock Remaining :<b style="color:red"> '+data+' </b></h3>')                        
                    }
                });
            }
        }
    </script>
@endsection
