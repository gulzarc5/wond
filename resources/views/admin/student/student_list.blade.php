@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Search Student Class Wise</h2>
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
                                    <span class="invalid-feedback" id="batch_err" role="alert" style="color:red"></span>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Medium</label>
                                    <select class="form-control" name="medium" id="medium">
                                    <option value="" selected>Please Select Medium</option>
                                    <option value="1" {{ old('medium') == 1 ? 'selected' : '' }}>Bengali</option>
                                    <option value="2" {{ old('medium') == 1 ? 'selected' : '' }}>English</option>
                                    </select>
                                    <span class="invalid-feedback" id="medium_err" role="alert" style="color:red"></span>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Class</label>
                                    <select class="form-control" name="class" id="class">
                                        <option value="" selected>Please Select Class</option>
                                    </select>
                                    <span class="invalid-feedback" id="class_err" role="alert" style="color:red"></span>
                                </div> 

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <input class="btn btn-success" type="button" value="Search" style="margin-top: 23px;width: 116px;" id="search_btn">
                                </div>

                            </div>
                        </div>
                        <div class="form-group" style="display:flex; justify-content:center">
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Student List</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="size_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Father Name</th>
                              <th>Class</th>
                              <th>Medium</th>
                              <th>Batch</th>
                              <th>Gender</th>
                              <th>Admission Type</th>
                              <th>Registered Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>                       
                          </tbody>
                        </table>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>
</div>


@endsection

@section('script')
     
     <script type="text/javascript">
         $(function () {    
            var table = $('#size_list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 50,
                ajax: "{{ route('admin.student_list_ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'student_id', name: 'student_id',searchable: true},
                    {data: 's_name', name: 's_name',searchable: true},
                    {data: 'f_name', name: 'f_name',searchable: true},
                    {data: 'class_name', name: 'class_name',searchable: true},
                    {data: 'medium', name: 'medium', render:function(data, type, row){
                      if (row.medium == '1') {
                        return "Bengali"
                      }else{
                        return "English"
                      }                        
                    }}, 
                    {data: 'batch_name', name: 'batch_name',searchable: true},
                    {data: 'gender', name: 'gender', render:function(data, type, row){
                      if (row.gender == 'M') {
                        return "Male"
                      }else{
                        return "Female"
                      }                        
                    }}, 
                    {data: 'is_paid', name: 'is_paid', render:function(data, type, row){
                      if (row.is_paid == '1') {
                        return "--"
                      }else{
                        return "Free"
                      }                        
                    }},    
                    {data: 'created_at', name: 'created_at' ,searchable: true},       
                    {data: 'action', name: 'action' ,searchable: true},
                ]
            });
            
        });


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


        $("#search_btn").click(function(){
            var batch = $("#batch").val();
            var medium = $("#medium").val();
            var class_id = $("#class").val();

            if (!batch) {
                $("#medium_err").html("");
                $("#class_err").html("");
                $("#batch_err").html("<strong>Batch Field Required</strong>");
                $("#batch").focus();
            }else if(!medium){
                $("#batch_err").html("");
                $("#class_err").html("");
                $("#medium_err").html("<strong>Medium Field Required</strong>");
                $("#medium").focus();
            }else if(!class_id){
                $("#medium_err").html("");
                $("#batch_err").html("");
                $("#class_err").html("<strong>Class Field Required</strong>");
                $("#class").focus();
            }else{
                $("#medium_err").html("");
                $("#batch_err").html("");
                $("#class_err").html("");
                searchData(medium,batch,class_id);
            }
        });

        function searchData(medium,batch,class_id){
            $("#size_list").dataTable().fnDestroy();
            var table = $('#size_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.student_list_ajax') }}/"+medium+"/"+batch+"/"+class_id+"/",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'student_id', name: 'student_id',searchable: true},
                    {data: 's_name', name: 's_name',searchable: true},
                    {data: 'f_name', name: 'f_name',searchable: true},
                    {data: 'class_name', name: 'class_name',searchable: true},
                    {data: 'medium', name: 'medium', render:function(data, type, row){
                      if (row.medium == '1') {
                        return "Bengali"
                      }else{
                        return "English"
                      }                        
                    }}, 
                    {data: 'batch_name', name: 'batch_name',searchable: true},
                    {data: 'gender', name: 'gender', render:function(data, type, row){
                      if (row.gender == 'M') {
                        return "Male"
                      }else{
                        return "Female"
                      }                        
                    }}, 
                    {data: 'is_paid', name: 'is_paid', render:function(data, type, row){
                      if (row.is_paid == '1') {
                        return "--"
                      }else{
                        return "Free"
                      }                        
                    }},    
                    {data: 'created_at', name: 'created_at' ,searchable: true},       
                    {data: 'action', name: 'action' ,searchable: true},
                ]
            });
        }
     </script>
    
 @endsection