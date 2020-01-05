
@extends('admin.template.admin_master')

@section('content')
<style>
    .required-color{
        color:red;
        font-weight: bold;
    }
</style>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <h2 class="x_title">
                    <h2>Promote Student</h2>
                    <div class="clearfix"></div>

                 <div>
                    @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div>
                    <div class="x_content">
                        {{ Form::open(['method' => 'post','route'=>'admin.student_promote_insert']) }}
                        @if (isset($students) && !empty($students))
                        <input type="hidden" class="form-control"  value="{{ $students->id }}" name="student_id" >
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">    
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Name Of Student</label>
                                    <input type="text" class="form-control"  value="{{ $students->s_name }}" disabled >
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Father Name </label>
                                    <input type="text" class="form-control"  value="{{ $students->f_name }}" disabled>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mother_name">Mother Name </label>
                                    <input type="text" class="form-control"  value="{{ $students->m_name }}" disabled>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="size_wearing">Gender</label>
                                    @if ($students->gender == 'M')
                                        <input type="text" class="form-control"  value="Male" disabled>
                                    @else
                                        <input type="text" class="form-control"  value="Female" disabled>
                                    @endif
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Current Class </label>
                                    <input type="text" class="form-control"  value="{{ $students->class_name }}" disabled>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mother_name">Current Batch </label>
                                    <input type="text" class="form-control"  value="{{ $students->batch_name }}" disabled>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Medium </label>
                                    @if ($students->medium == '1')
                                        <input type="text" class="form-control"  value="Bengali" disabled>
                                    @else
                                        <input type="text" class="form-control"  value="English" disabled>
                                    @endif
                                    
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mother_name">Type </label>
                                    @if ($students->is_paid == '1')
                                        <input type="text" class="form-control"  value="Paid" disabled>
                                    @else
                                        <input type="text" class="form-control"  value="Free" disabled>
                                    @endif
                                </div>

                            </div>
                        </div>
                        @endif
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Batch <span class="required-color">*</span></label>
                                    <select class="form-control" name="batch" >
                                        <option value="" selected>Please Select Batch</option>
                                        @if (isset($batch) && !empty($batch))
                                            @foreach ($batch as $item)
                                                <option value="{{$item->id}}" {{ old('batch') == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('batch'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('batch') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Admission Type <span class="required-color">*</span></label>
                                    <select class="form-control" name="admission_type" id="admission_type">
                                        <option value="1" {{ $students->is_paid == 1 ? 'selected' : '' }} selected>Paid</option>
                                        <option value="2" {{ $students->is_paid == 2 ? 'selected' : '' }}>Free</option>
                                    </select>
                                    @if($errors->has('admission_type'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('admission_type') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Medium <span class="required-color">*</span></label>
                                    <select class="form-control" name="medium" id="medium">
                                        <option value="" selected>Please Select Medium</option>
                                        <option value="1" {{ $students->medium == 1 ? 'selected' : '' }}>Bengali</option>
                                        <option value="2" {{ $students->medium == 2 ? 'selected' : '' }}>English</option>
                                    </select>
                                    @if($errors->has('medium'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('medium') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Class <span class="required-color">*</span></label>
                                    <select class="form-control" name="class" id="class">
                                        <option value="" selected>Please Select Class</option>
                                        @if (isset($class) && !empty($class))
                                            @foreach ($class as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3" style="display: flex;justify-content: center;padding: 20px;font-size: 32px;" id="fee_show"></div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="receive_amount">Receive Amount<span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="receive_amount" id="receive_amount"  placeholder="Enter Amount of Rs." value="{{ old('receive_amount')}}" >
                                      @if($errors->has('receive_amount'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('receive_amount') }}</strong>
                                          </span>
                                      @enderror
                                </div>
  
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="scholarship_amount">Scholarship Amount<span class="required-color">*</span></label>
                                <input type="text" class="form-control" name="scholarship_amount"  placeholder="Enter Scholarship Amount Of Rs" value="{{ old('scholarship_amount')}}" >
                                    @if($errors->has('scholarship_amount'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('scholarship_amount') }}</strong>
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
		$("#medium").change(function(){
            
			var medium = $(this).val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type:"GET",
				url:"{{ url('admin/Ajax/Class/List/')}}"+"/"+medium+"",
				success:function(data){
                    
					$("#class").html("<option value=''>Please Select Class</option>");

					$.each( data, function( key, value ) {
						$("#class").append("<option value='"+value.id+"'>"+value.name+"</option>");
					});
				}
			});
		});

        $("#class").change(function(){
            var admission_type = $("#admission_type").val();
            if (admission_type == 1) {
                fetchFees();
            }else{
                $("#fee_show").html("Total Admission Fees : Free");
                $("#receive_amount").val(0);
            }
		});

        $("#admission_type").change(function(){
            var admission_type = $("#admission_type").val();
            if (admission_type == 1) {
                fetchFees();
            }else{
                $("#fee_show").html("Total Admission Fees : Free");
                $("#receive_amount").val(0);
            }
		});


	});

    function fetchFees() {
        var classes = $("#class").val();
        var medium = $("#medium").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (classes && medium){
            $.ajax({
                type:"GET",
                url:"{{ url('ajax/class/promotion/fees/')}}"+"/"+classes+"/"+medium,
                success:function(data){                    
                    $("#fee_show").html("Total Admission Fees : "+data);
                    $("#receive_amount").val(data);
                }
            });
        }
    }
</script>
@endsection
