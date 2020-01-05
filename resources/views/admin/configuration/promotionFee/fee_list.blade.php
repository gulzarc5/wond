@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
     <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Search Fees Of A Selected Class</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.search_promotion_fees']) }}

                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="tag_name">Select Medium</label>
                                  <select class="form-control" name="medium" id="medium">
                                    <option value="" selected>Please Select Medium</option>
                                    <option value="1" {{ old('medium') == 1 ? 'selected' : '' }}>Bengali</option>
                                    <option value="2" {{ old('medium') == 1 ? 'selected' : '' }}>English</option>
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

                            </div>
                        </div>
                        <div class="form-group" style="display:flex; justify-content:center">
                            {{ Form::submit('Search', array('class'=>'btn btn-success')) }}
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    {{--//////////// Last Ten Sellers //////////////--}}
                    <div class="table-responsive">
                        
                        @if (isset($fees) && !empty($fees))
                        <h2>Promotion Fees List</h2>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">                
                                    <th class="column-title">Sl No. </th>
                                    <th class="column-title">Class</th>
                                    <th class="column-title">Medium</th>
                                    <th class="column-title">Fees Amount</th>    
                                    <th class="column-title">Action</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $job_count = 1;
                                @endphp
                                @foreach ($fees as $item)
                                    <tr>
                                    <td>{{$job_count++}}</td>
                                    <td>{{$item['class_name']}}</td>
                                    <td>
                                        @if ($item['medium'] == '1')
                                            Bengali
                                        @else
                                            English
                                        @endif
                                    </td>                                    
                                    <td>{{ number_format($item['amount'],2,".",'') }}</td>
                                    <td>
                                        <a href="{{route('admin.promotion_fee_edit_form',['class_id'=>encrypt($item['class_id']),'medium'=>encrypt($item['medium'])])}}" class="btn btn-warning">Edit</a>
                                    </td>
                                    </tr>                              
                                @endforeach
                            
                            </tbody>
                        </table>
                        @elseif(isset($fees_search) && !empty($fees_search))
                        <h2>Promotion Fee Details Of Class {{$class_name->name}} in 
                            @if ($medium == 1)
                                Bengali
                            @else
                                English
                            @endif Medium</h2>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">                
                                        <th class="column-title">Sl No. </th>
                                        <th class="column-title">Particulars</th>
                                        <th class="column-title">Fees Amount</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $fee_search_count = 1;
                                    @endphp
                                    @foreach ($fees_search as $item)
                                        <tr>
                                            <td>{{$fee_search_count++}}</td>
                                            <td>{{$item->fee_type_name}}</td>
                                            <td>{{ number_format($item->amount,2,".",'') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" align="right" style="font-size: 30px;">Total : </td>
                                        <td style="font-size: 30px;">{{ number_format($fees_total,2,".",'') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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