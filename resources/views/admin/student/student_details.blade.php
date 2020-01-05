@extends('admin.template.admin_master')
@section('content')
<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Student Detail</h3>
                </div>
            </div>
    
            <div class="clearfix"></div>
    
            <div class="row vpanel">
                @if (isset($student) && !empty($student) && isset($student_details) && !empty($student_details))
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Admission Details </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">    
                                <section class="content invoice">
                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Batch : </strong>{{$student->batch_name}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Admission Type : </strong>
                                            @if ($student->is_paid == '1')
                                                <button class="btn-sm btn-success">Paid</button>
                                            @else
                                                <button class="btn btn-warning">Free</button>
                                            @endif
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Class : </strong>{{$student->class_name}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Medium : </strong>
                                            @if ($student->medium == '1')
                                                Bengali
                                            @else
                                                English
                                            @endif
                                            </address>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Personal Details </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">    
                                <section class="content invoice">
                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Name : </strong>{{$student_details->name}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Father Name : </strong>{{$student_details->f_name}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Mother Name : </strong>{{$student_details->m_name}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Gender : </strong>
                                            @if ($student_details->gender == 'M')
                                                Male
                                            @else
                                                Female
                                            @endif
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Date Of Birth : </strong>{{$student_details->dob}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Caste : </strong>{{$student_details->caste}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Contact Number : </strong>{{$student_details->mobile}}
                                            </address>
                                        </div>

                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Last Exam Passed : </strong>{{$student_details->last_exam}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Last Attended School : </strong>{{$student_details->last_school}}
                                            </address>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Parrent Details </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">    
                                <section class="content invoice">
                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Father Qualification : </strong>{{$student_details->f_qualification}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Mother Qualification : </strong>{{$student_details->m_qualification}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Father Occupation : </strong>{{$student_details->f_occupaction}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Annual Income : </strong>{{$student_details->annual_income}}
                                            </address>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Address </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">    
                                <section class="content invoice">
                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Village : </strong>{{$student_details->village}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Post Office : </strong>{{$student_details->po}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Police Station : </strong>{{$student_details->ps}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>District : </strong>{{$student_details->dist}}
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address class="font-15">
                                            <strong>Pin : </strong>{{$student_details->pin}}
                                            </address>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                @endif
            </div>

            <div class="row no-print">
                <div class="col-xs-12">
                    <button class="btn btn-success pull-left" onclick="closeWindow()"><i class="fa fa-credit-card"></i> Close Window</button>
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
 @endsection