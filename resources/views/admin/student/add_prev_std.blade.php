
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

                <div class="x_title">
                    <h2>Add Previous Batch Student</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.add_new_student']) }}

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
                                        <option value="1" {{ old('admission_type') == 1 ? 'selected' : '' }} selected>Paid</option>
                                        <option value="2" {{ old('admission_type') == 2 ? 'selected' : '' }}>Free</option>
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
                                        <option value="1" {{ old('medium') == 1 ? 'selected' : '' }}>Bengali</option>
                                        <option value="2" {{ old('medium') == 2 ? 'selected' : '' }}>English</option>
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
                                    </select>
                                    @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Name Of Student <span class="required-color">*</span></label>
                                  <input type="text" class="form-control" name="name"  placeholder="Enter Student Name" value="{{ old('name')}}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Father Name <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="father_name"  placeholder="Enter Father Name" value="{{ old('name')}}" >
                                    @if($errors->has('father_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('father_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mother_name">Mother Name <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="mother_name"  placeholder="Enter Mother Name" value="{{ old('name')}}" >
                                    @if($errors->has('mother_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mother_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="size_wearing">Gender <span class="required-color">*</span></label>
                                    <p style="padding-bottom: 6px; margin-top: 8px;">
                                        Male:
                                        <input type="radio" class="flat" name="gender" id="genderM" value="M" checked="" required /> FeMale:
                                        <input type="radio" class="flat" name="gender" id="genderF" value="F" />
                                    </p>
                                    @if($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @enderror
                                </div> 

                                

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="dob">Date Of Birth <span class="required-color">*</span></label>
                                    <input type="date" class="form-control" name="dob"   value="{{ old('dob')}}" >
                                    @if($errors->has('dob'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="size_wearing">Caste</label>
                                    <p style="padding-bottom: 6px; margin-top: 8px;">
                                        SC:
                                        <input type="radio" class="flat" name="caste"  value="SC" /> 
                                        ST:
                                        <input type="radio" class="flat" name="caste"  value="ST" />
                                        OBC:
                                        <input type="radio" class="flat" name="caste"  value="OBC" />
                                        GENERAL:
                                        <input type="radio" class="flat" name="caste"  value="GENERAL"  checked=""/>
                                    </p>
                                    @if($errors->has('caste'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @enderror
                                </div> 

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mobile">Contact Number <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="mobile"  placeholder="Enter Contact Number" value="{{ old('mobile')}}" >
                                    @if($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                         </div>
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="fother_qualification">Father Qualification</label>
                                    <input type="text" class="form-control" name="fother_qualification"  placeholder="Enter Father Qualification" value="{{ old('name')}}" >
                                    @if($errors->has('fother_qualification'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('fother_qualification') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mother_qualification">Mother Qualification</label>
                                    <input type="text" class="form-control" name="mother_qualification"  placeholder="Enter Mother Qualification" value="{{ old('name')}}" >
                                    @if($errors->has('mother_qualification'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mother_qualification') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="f_occupation">Father Occupation</label>
                                    <input type="text" class="form-control" name="f_occupation"  placeholder="Enter Father Occupation" value="{{ old('name')}}" >
                                    @if($errors->has('f_occupation'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('f_occupation') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="size_wearing">Annual Income</label>
                                <input type="number" class="form-control" name="annual_income"  placeholder="Enter Annual Income" value="{{old('annual_income')}}" >

                                  @if($errors->has('annual_income'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('annual_income') }}</strong>
                                        </span>
                                    @enderror
                                </div>                                                             
                            </div>
                        </div>

                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="village">Village <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="village"  placeholder="Enter Village Name" value="{{ old('village')}}" >
                                    @if($errors->has('village'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('village') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="po">P.O. <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="po"  placeholder="Enter Post Office Name" value="{{ old('po')}}" >
                                    @if($errors->has('po'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('po') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="ps">P.S. <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="ps"  placeholder="Enter Police Station Name" value="{{ old('ps')}}" >
                                    @if($errors->has('ps'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('ps') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="dist">District <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="dist"  placeholder="Enter District Name" value="{{ old('dist')}}" >
                                    @if($errors->has('dist'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('dist') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="pin">PIN <span class="required-color">*</span></label>
                                    <input type="text" class="form-control" name="pin"  placeholder="Enter Pin Number" value="{{ old('pin')}}" >
                                    @if($errors->has('pin'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('pin') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="lase_exam">Last Exam Passed Class Name</label>
                                    <input type="text" class="form-control" name="lase_exam"  placeholder="Enter Last Exam Passed Class Name" value="{{ old('lase_exam')}}" >
                                    @if($errors->has('lase_exam'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('lase_exam') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="last_school">Name Of The School</label>
                                    <input type="text" class="form-control" name="last_school"  placeholder="Enter Name Of School" value="{{ old('last_school')}}" >
                                    @if($errors->has('last_school'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('last_school') }}</strong>
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

	});
</script>
@endsection
