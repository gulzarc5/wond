@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Search Student Monthly Fees Class Wise</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.monthly_fee_search']) }}
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="batch">Select Batch</label>
                                    <select class="form-control" name="batch" id="batch" required>
                                        <option value="" selected>Please Select Batch</option>
                                        @if (isset($batch) && !empty($batch))
                                            @foreach ($batch as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select> 
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="month">Select Month</label>
                                    <select class="form-control" name="month" id="month" required>
                                        <option value="" selected>Please Select Month</option>
                                    </select> 
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Medium</label>
                                    <select class="form-control" name="medium" id="medium">
                                    <option value="" selected>Please Select Medium</option>
                                    <option value="1" {{ old('medium') == 1 ? 'selected' : '' }}>Bengali</option>
                                    <option value="2" {{ old('medium') == 1 ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" id="class-div">
                                    <label for="tag_name">Select Class</label>
                                    <select class="form-control" name="class" id="class">
                                        <option value="" selected>Please Select Class</option>
                                    </select>
                                </div> 

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <input class="btn btn-success" type="submit" value="Search" style="margin-top: 23px;width: 116px;" id="search_btn">
                                </div>

                            </div>
                        </div>
                          {{ Form::close() }}
                        <div class="form-group" style="display:flex; justify-content:center"></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($monthly_fees))
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        <h2>Student Fees For The Month 
                            <b class="table-head-mark">
                                @if (isset($month_name) && !empty($month_name))
                                    {{$month_name}}
                                @endif
                            </b> 
                            
                            @if (isset($class_name) && !empty($class_name))
                                Of Class <b class="table-head-mark">{{$class_name}}</b>
                            @endif
                        
                        
                            @if (isset($med_view) && !empty($med_view))
                                    And Medium <b class="table-head-mark">{{$med_view}}</b>
                            @endif
                           </h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">ID</th>
                                    <th class="column-title">Name</th>
                                    <th class="column-title">Amount</th>      
                                    <th class="column-title">Receive-Amount</th>                              
                                    <th class="column-title">Pending-Amount</th>  
                                    <th class="column-title">Scholarship</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($monthly_fees) && !empty($monthly_fees))
                                @php
                                    $job_count = 1;
                                    $pending = 0;
                                    $receive = 0;
                                    $scholarship = 0;
                                    $amount = 0;
                                @endphp
                                @foreach ($monthly_fees as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>{{$item->std_id}}</td>
                                    <td>{{$item->std_name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->receive_amount}}</td>
                                    <td>{{$item->pending_amount}}</td>
                                    <td>{{$item->discount}}</td>
                                    <td>
                                        @if ($item->is_paid == '1')
                                            Paid
                                        @else
                                            Pending
                                        @endif
                                    </td>
                                    <td>{{$item->created_at}}</td>
                                    </tr>     
                                    @php
                                        $pending = $pending+$item->pending_amount;
                                        $receive = $receive+$item->receive_amount;
                                        $scholarship = $scholarship+$item->discount;
                                        $amount = $amount+$item->amount;
                                    @endphp                         
                                @endforeach
                                <tr>
                                    <td colspan="6" align="right">Total Pending Amount</td>
                                    <td colspan="3">{{$pending}}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right">Total Receive Amount</td>
                                    <td colspan="3">{{$receive}}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right">Total Scholarship Amount</td>
                                    <td colspan="3">{{$scholarship}}</td>
                                </tr>                                
                                <tr>
                                    <td colspan="6" align="right">Total Amount</td>
                                    <td colspan="3">{{$amount}}</td>
                                </tr>
                            @endif                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Monthly Fees List</h2>
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
                              <th>Amount</th>
                              <th>Receive Amount</th>
                              <th>Pending Amount</th>
                              <th>Discount Amount</th>
                              <th>Status</th>
                              <th>Date</th>
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
    @endif
</div>


@endsection

@section('script')
     @if (!isset($monthly_fees))
         <script>
            $(function () {    
                var table = $('#size_list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.monthly_fee_report_ajax') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'id', name: 'id',searchable: true},
                        {data: 's_name', name: 's_name',searchable: true},
                        {data: 'f_name', name: 'f_name',searchable: true},
                        {data: 'class_name', name: 'class_name',searchable: true},
                        {data: 'st_medium', name: 'st_medium', render:function(data, type, row){
                        if (row.st_medium == '1') {
                            return "Bengali"
                        }else{
                            return "English"
                        }                        
                        }}, 
                        {data: 'batch_name', name: 'batch_name',searchable: true},
                        {data: 'amount', name: 'amount',searchable: true}, 
                        {data: 'receive_amount', name: 'receive_amount',searchable: true}, 
                        {data: 'pending_amount', name: 'pending_amount',searchable: true}, 
                        {data: 'discount', name: 'discount',searchable: true}, 
                        {data: 'is_paid', name: 'is_paid', render:function(data, type, row){
                        if (row.is_paid == '1') {
                            return "Paid"
                        }else{
                            return "Pending"
                        }                        
                        }},    
                        {data: 'created_at', name: 'created_at' ,searchable: true},     
                    ]
                });            
            });
         </script>
     @endif
     <script type="text/javascript">
        $("#medium").change(function(){            
			var medium = $(this).val();
            if (medium) {
                $("#class-div").html('<label for="tag_name">Select Class</label><select class="form-control" name="class" id="class" required><option value="" selected>Please Select Class</option></select>');

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
            }else{
                $("#class-div").html('<label for="tag_name">Select Class</label><select class="form-control" name="class" id="class"><option value="" selected>Please Select Class</option></select>');
            }
		});

        $("#batch").change(function(){
            
			var batch = $(this).val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type:"GET",
				url:"{{ url('admin/Report/month/fetch/ajax/')}}"+"/"+batch+"",
				success:function(data){
                    
					$("#month").html("<option value=''>Please Select Month</option>");

					$.each( data, function( key, value ) {
						$("#month").append("<option value='"+value.id+"'>"+value.month+"</option>");
					});
				}
			});
		});
     </script>
    
 @endsection