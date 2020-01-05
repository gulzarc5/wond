@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Promote Student Search</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.student_promote_search']) }}
                        <div class="well" style="overflow: auto">
                        <div class="form-row mb-10">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="batch">Select Batch</label>
                                <select class="form-control" name="batch" id="batch">
                                    <option value="" selected>Please Select Batch</option>
                                    @if (isset($batch) && !empty($batch))
                                        @foreach ($batch as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
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
                                <label for="tag_name">Select Medium</label>
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
                                <label for="tag_name">Select Class</label>
                                <select class="form-control" name="class" id="class">
                                    <option value="" selected>Please Select Class</option>
                                </select>
                                @if($errors->has('class'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                @enderror
                            </div> 

                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <input class="btn btn-success" type="submit" value="Search" style="margin-top: 23px;width: 116px;" id="search_btn">
                            </div>

                        </div>
                        </div>
                        <div class="form-group" style="display:flex; justify-content:center">
                            
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($students) && !empty($students))
    @php
        $job_count = 1;
    @endphp
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12">
    	    <div class="x_panel">
    	        <div class="x_title">
                <h2>Promote Student Of Class {{$class_name}}</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <div class="table-responsive">
                            
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">               
                                        <th class="column-title">Sl No. </th>
                                        <th class="column-title">Name</th>
                                        <th class="column-title">Father Name</th>
                                        <th class="column-title">Class</th>
                                        <th class="column-title">Medium</th>    
                                        <th class="column-title">Batch</th>     
                                        <th class="column-title">Admission Type</th>   
                                        <th class="column-title">Action</th>                          
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $item)
                                        <tr>
                                            <td>{{$job_count++}}</td>
                                            <td>{{$item->s_name}}</td>
                                            <td>{{$item->f_name}}</td>
                                            <td>{{$item->class_name}}</td>
                                            <td>
                                                @if ($item->medium == '1')
                                                    Bengali
                                                @else
                                                    English
                                                @endif
                                            </td>
                                            <td>{{$item->batch_name}}</td>
                                            <td>
                                                @if ($item->is_paid == '1')
                                                    --
                                                @else
                                                    Free
                                                @endif
                                            </td>
                                            <td>
                                            <button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm{{$item->id}}">Promote</button>
                                            <div class="modal fade bs-example-modal-sm{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel2">Are You Sure To Promote</h4>
                                                        </div>
                                                        <div class="form-group" style="margin: 17px;">
                                                            <label for="tag_name">Student Name</label>
                                                            <input class="form-control" value="{{$item->s_name}}" disabled>
                                                        </div>
                                                        <div class="form-group" style="margin: 17px;">
                                                            <label for="tag_name">From Class</label>
                                                            <input class="form-control" value="{{$item->class_name}}" disabled>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{route('admin.student_promote_form',[encrypt($item->id)])}}" class="btn btn-primary">Yes</a>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>                              
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
    	            </div>
                </div>
    	    </div>
    	</div>
    </div>
    @endif
</div>


@endsection

@section('script')
     
     <script type="text/javascript">

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
       
     </script>
    
 @endsection