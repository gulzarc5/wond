@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-2" style="margin-top:50px;display:flex;justify-content:center;"></div>
        <div class="col-md-8" style="margin-top:50px;display:flex;justify-content:center;">
            <div class="x_panel">

                 <div>
                    @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div>
                    <div class="x_content">
                        {{ Form::open(['method' => 'post','route'=>'admin.student_fee_receive']) }}
                        <h2>Receive Student Fees</h2>
                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Enter Student Id</label>
                                  <input type="text" class="form-control" name="student_id"  placeholder="Eg. WNS202100018" id="std_id">
                                    @if($errors->has('batch_id'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('batch_id') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="fees-div">

                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#std_id").blur(function(){
                var std_id = $("#std_id").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (std_id){
                    var loader = "{{asset('admin/logo/loader.gif')}}";
                    $.ajax({
                        type:"GET",
                        url:"{{url('admin/Student/Fee/search/')}}"+"/"+std_id,
                        beforeSend: function() {
                            $("#fees-div").html('<center><img src="'+loader+'"></center>');
                        },
                        success:function(data){                    
                            $("#fees-div").html(data);
                        }
                    });
                }
            })
        });
    </script>
@endsection