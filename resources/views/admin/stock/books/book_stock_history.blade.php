@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Book Stock History</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="size_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Class</th>
                              <th>Book Name</th>
                              <th>Stock</th>
                              <th>Stock Type</th>
                              <th>Comments</th>
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
</div>


@endsection

@section('script')
     
     <script type="text/javascript">
         $(function () {
    
            var table = $('#size_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.book_stock_history_ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'class_name', name: 'class_name',searchable: true},
                    {data: 'book_name', name: 'book_name' ,searchable: true}, 
                    {data: 'stock', name: 'stock' ,searchable: true},       
                    {data: 'stock_type', name: 'stock_type', render:function(data, type, row){
                      if (row.stock_type == '1') {
                        return "<a class='btn-sm btn-info'>Purchase</a>"
                      }else{
                        return "<a class='btn-sm btn-warning'>Sale</a>"
                      }                        
                    }}, 
                    {data: 'comments', name: 'comments' ,searchable: true},
                    {data: 'created_at', name: 'created_at' ,searchable: true},
                ]
            });
            
        });
     </script>
    
 @endsection