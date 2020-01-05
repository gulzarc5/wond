@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">

                <div class="x_title" style="border:0;">
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
                            {{ Form::open(['method' => 'post','route'=>'admin.prmsn_fee_report_search']) }}
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
                                    <option value="2" {{ old('medium') == 1 ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Class</label>
                                    <select class="form-control" name="class" id="class">
                                        <option value="" selected>Please Select Class</option>
                                    </select>
                                </div> 

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <input class="btn btn-success" type="submit" value="Search" style="margin-top: 23px;width: 116px;" id="search_btn">
                                </div>

                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (isset($student_fees) && !empty($student_fees))
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        {{--//////////// Last Ten Sellers //////////////--}}
                        <div class="table-responsive">
                            <h2>Admission Fees Report</h2>
                            <table class="table table-striped jambo_table bulk_action" style="border:0;">
                                <thead>
                                    <tr class="headings">  
                                        <th  class="column-title">Sl</th>
                                        <th  class="column-title">Student Id</th>
                                        <th  class="column-title">Name</th>
                                        <th  class="column-title">Class</th>
                                        <th  class="column-title">Medium</th>
                                        <th  class="column-title">Batch</th>
                                        <th  class="column-title">Receive Amount</th>
                                        <th  class="column-title">Scholarship</th>
                                        <th  class="column-title">Pending Amount</th>
                                        <th  class="column-title">Amount</th>
                                        <th  class="column-title">Status</th>
                                        <th  class="column-title">Received By</th>
                                        <th  class="column-title">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $job_count = 1;
                                        $receive_amount = 0;
                                        $discount = 0;
                                        $pending_amount = 0;
                                        $fees_amount = 0;
                                    @endphp
                                    @foreach ($student_fees as $item)
                                        <tr>
                                        <td>{{$job_count++}}</td>
                                        <td>{{$item->s_student_id}}</td>
                                        <td>{{$item->s_name}}</td>
                                        <td>{{$item->class_name}}</td>
                                        <td>
                                            @if ($item->st_medium == '1')
                                                Bengali
                                            @else
                                                English
                                            @endif
                                        </td>
                                        <td>{{$item->batch_name}}</td>
                                        <td>{{$item->receive_amount}}</td>
                                        <td>{{$item->discount}}</td>
                                        <td>{{$item->pending_amount}}</td>
                                        <td>{{$item->fees_amount}}</td>
                                        <td>
                                            @if ($item->pending_amount > 0)
                                                <button class="btn btn-sm btn-danger" style="margin: 0;padding: 3px;">Not Paid</button>
                                            @else
                                                <button class="btn btn-sm btn-primary" style="margin: 0;padding: 3px;">Paid</button>
                                            @endif
                                        </td>
                                        <td>{{$item->received_by}}</td>
                                        <td>{{$item->created_at}}</td>
                                        </tr>    
                                        @php
                                            $receive_amount += $item->receive_amount;
                                            $discount += $item->discount;
                                            $pending_amount += $item->pending_amount;
                                            $fees_amount += $item->fees_amount;
                                        @endphp                          
                                    @endforeach    
                                    <tr>
                                        <td colspan="10" align="right">Receive Amount</td>
                                        <td  colspan="5">{{$receive_amount}}</td>
                                    </tr>  
                                    <tr>
                                        <td colspan="10" align="right">Scholarship Amount</td>
                                        <td  colspan="5">{{$discount}}</td>
                                    </tr>  
                                    <tr>
                                        <td colspan="10" align="right">Pending Amount</td>
                                        <td  colspan="5">{{$pending_amount}}</td>
                                    </tr>  
                                    <tr>
                                        <td colspan="10" align="right">Total Amount</td>
                                        <td  colspan="5">{{$fees_amount}}</td>
                                    </tr>                            
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
                        <h2>Promotion Fees List</h2>
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
                                <th>Class</th>
                                <th>Receive Amount</th>
                                <th>Scholarship Amount</th>
                                <th>Pending Amount</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Medium</th>
                                <th>Batch</th>
                                <th>Received By</th>
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
     
     <script type="text/javascript">
         $(function () {    
            var table = $('#size_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.promotion_fee_report_ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'st_student_id', name: 'st_student_id',searchable: true},
                    {data: 's_name', name: 's_name',searchable: true},
                    {data: 'class_name', name: 'class_name',searchable: true},
                    
                    {data: 'receive_amount', name: 'receive_amount',searchable: true}, 
                    {data: 'discount', name: 'discount',searchable: true}, 
                    {data: 'pending_amount', name: 'pending_amount',searchable: true}, 
                    {data: 'fees_amount', name: 'fees_amount',searchable: true}, 
                    {data: 'status_tab', name: 'status_tab',searchable: true}, 
                    {data: 'st_medium', name: 'st_medium', render:function(data, type, row){
                      if (row.st_medium == '1') {
                        return "Bengali"
                      }else{
                        return "English"
                      }                        
                    }}, 
                    {data: 'batch_name', name: 'batch_name',searchable: true},  
                    {data: 'rec_by', name: 'rec_by' ,searchable: true},
                    {data: 'created_at', name: 'created_at' ,searchable: true},     
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
     </script>
    
 @endsection