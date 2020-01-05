@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add New Book</h2>
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
                        {{ Form::open(['method' => 'post','route'=>'admin.add_book']) }}

                         <div class="well" style="overflow: auto">
                            <div class="form-row mb-6">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Medium</label>
                                    <select class="form-control" name="medium" id="medium">
                                            <option value="">Please Select Medium</option>
                                        <option value="1" {{ old('medium') == 1 ? 'selected' : '' }}>Bengali</option>
                                        <option value="2" {{ old('medium') == 1 ? 'selected' : '' }}>English</option>
                                    </select>
                                    @if($errors->has('medium'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('medium') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="tag_name">Select Class</label>
                                    <select class="form-control" name="class" id="class">
                                        <option value="">Please Select class</option>
                                    </select>
                                    @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-8 col-sm-8 col-xs-8 mb-3">
                                    <label for="book_name">Book Name</label>
                                    <input type="text" class="form-control" name="book_name[]"/>
                                    @if($errors->has('book_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('book_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 mb-3">
                                    <label for="book_name"></label>
                                    <button type="button" onclick="addMoreBook()" class="btn btn-sm btn-warning" style="margin-top: 26px;">Add More</button>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="add_more_div" style="padding: 0;"></div>
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
                        console.log(data);
                        if (data.length > 0) {
                            $("#class").html('<option value="">Please Select Class</option>');
                            $.each( data, function( key, value ) {
                                
                                $("#class").append("<option value='"+value.id+"'>"+value.name+"</option>");
                            });
                        }                        
                    }
                }); 
            });
        });

        var mor_book_count = 1;
        function addMoreBook(){
            var div_html = '<divn id=moreBook'+mor_book_count+'>'+
                    '<div class="col-md-8 col-sm-8 col-xs-8 mb-3">'+
                    '<label for="book_name">Book Name</label>'+
                    '<input type="text" class="form-control" name="book_name[]"/>'+
                '</div>'+
                '<div class="col-md-4 col-sm-4 col-xs-4 mb-3">'+
                    '<label for="book_name"></label>'+
                    '<button type="button" onclick="removeMoreBook('+mor_book_count+')" class="btn btn-sm btn-danger" style="margin-top: 26px;">Remove</button>'+
               ' </div>'+
            '</div>';
            $("#add_more_div").append(div_html);
            mor_book_count++;
        }

        function removeMoreBook(id){
            $("#moreBook"+id).remove();
        }
    </script>
@endsection
