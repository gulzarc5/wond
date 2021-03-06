@extends('admin.template.admin_master')
@section('content')

<div class="right_col" role="main">
    <div class="row" style="display:flex;justify-content:center" id="print_div">
        <div class="col-md-10 col-sm-10 col-xs-12" style="background-color: white; text-align:center">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h3 style="padding: 18px;color: black;margin: 0;">Wonderland National School Hailakandi</h3>
                <h4 style="padding: 5px;margin-buttom: 5px;margin-top: 0px;">Admission Receipt</h4>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h5>Name : 
                        @if (isset($student->s_name))
                            {{$student->s_name}}
                        @endif
                    </h5>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h5>Registration Id : 
                        @if (isset($student->student_id))
                            {{$student->student_id}}
                        @endif
                    </h5>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h5>Date : 
                        @if (isset($student->created_at))
                            {{$student->created_at}}
                        @endif
                    </h5>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h5>Batch : 
                        @if (isset($student->b_name))
                            {{$student->b_name}}
                        @endif
                    </h5>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h5>Medium : 
                        @if (isset($student->medium))
                            @if ($student->medium == '1')
                                Bengali
                            @else
                                English
                            @endif
                        @endif
                    </h5>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h5>Class : 
                        @if (isset($student->c_name))
                            {{$student->c_name}}
                        @endif
                    </h5>
                </div>
            </div>
            @if (isset($admsn))
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped jambo_table bulk_action">
                    <tr>
                        <th style="text-align:center">Particulars</th>
                        <th style="text-align:center">Amount</th>
                    </tr>
                    <tr>
                        <td>Admission Fees</td>
                        <td>{{ number_format($admsn->fees_amount,2,".",'') }}</td>
                    </tr>
                    <tr>
                        <td>Scholarship Amount</td>
                        <td>{{ number_format($admsn->discount,2,".",'') }}</td>
                    </tr>
                    <tr>
                        <td>Paid Amount</td>
                        <td>{{ number_format($admsn->receive_amount,2,".",'') }}</td>
                    </tr>
                    <tr>
                        <td>Balance Amount</td>
                        <td>{{ number_format($admsn->pending_amount,2,".",'') }}</td>
                    </tr>
                </table>
            </div>
            @endif
           
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-8 col-sm-8 col-xs-8"></div>
                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 61px;">Principal/Cashier<br>Wonderland National School</div>
            </div>
            <div class="col-md-12 col-sm-12" id="div-hid">
                <button class="btn btn-sm btn-primary" onclick="printDiv()">Print</button>
                <a href="{{route('admin.add_student_form')}}" class="btn btn-sm btn-warning">Back</a>
            </div>
            
        </div>
    </div>
</div>    
@endsection

@section('script')
    <script>
        function closeWindow(){
            window.close();
        }
    </script>
     <script>
        var original_content = document.body.innerHTML;
       function printDiv(){
            document.getElementById("div-hid").style.display = "none";
           var print_content =  document.getElementById("print_div").innerHTML;
           
           document.body.innerHTML = print_content;
           window.print();
       }

       window.addEventListener("afterprint", function(event) { 
           document.body.innerHTML = original_content;
       })
   </script>
 @endsection