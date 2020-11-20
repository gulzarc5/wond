<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('web/assets/images/favicon.png')}}" type="image/ico" />

    <title>Wonderland National School</title>
    <link rel="icon" href="{{asset('web/assets/images/favicon.png')}}" type="image/icon type">


    <!-- Bootstrap -->
    <link href="{{asset('admin/src_files/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('admin/src_files/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('admin/src_files/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('admin/src_files/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="{{asset('admin/src_files/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('admin/src_files/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('admin/src_files/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    {{-- Datatables --}}
     <link href="{{asset('admin/src_files/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/src_files/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/src_files/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/src_files/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/src_files/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/src_files/build/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{route('admin.deshboard')}}" class="site_title">
                {{-- <img src="{{asset('admin/logo/logo.jpeg')}}" height="50" style=" width: 60%;margin-left:20px;"> --}}
                WONDERLAND NATIONAL SCHOOL
              </a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                <span>Welcome,<b>Admin</b></span>
                
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ route('admin.deshboard')}}"><i class="fa fa-home"></i> Home </span></a>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Student <span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">
                      <li class="sub_menu"><a href="{{route('admin.add_student_form')}}">New Admission</a></li>
                      <li class="sub_menu"><a href="{{route('admin.student_promote')}}">Promote Student</a></li>
                      <li class="sub_menu"><a href="{{route('admin.add_prev_student_form')}}">Previous Student Add</a></li>
                      <li class="sub_menu"><a href="{{route('admin.student_list')}}">Student List</a></li>
                      <li class="sub_menu"><a href="{{route('admin.student_generate_monthly_fee_form')}}">Generate Fees</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> Expense <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">                     
                      <li><a href="{{route('admin.expense_add_form')}}"><i class="fa fa-edit"></i>Add Expense</a></li>
                      <li><a href="{{route('admin.expense_details_list')}}"><i class="fa fa-edit"></i>Expense Report</a></li>
                   </ul>
                 </li>


                  <li><a><i class="fa fa-edit"></i> Fees Report<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     <li class="sub_menu"><a href="{{route('admin.admsn_fee_report')}}">Admission Fees</a></li>
                     <li class="sub_menu"><a href="{{route('admin.promotion_fee_report')}}">Promotion Fees</a></li>
                     <li class="sub_menu"><a href="{{route('admin.monthly_fee_report')}}">Monthly Fees</a></li>
                     <li class="sub_menu"><a href="#">Summary Report</a></li>
                   </ul>
                  </li>

                  <li><a><i class="fa fa-desktop"></i>Stock<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a>Clothes<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li class="sub_menu"><a href="{{route('admin.add_cloth_form')}}">Add Cloth Stock</a></li>
                          <li class="sub_menu"><a href="{{route('admin.cloth_stock_list')}}">View Cloth Stocks</a></li>
                          <li><a href="{{route('admin.cloth_stock_details_list')}}">Stock Details</a></li>
                        </ul>
                      </li>

                      <li><a>Books<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li class="sub_menu"><a href="{{route('admin.add_book_form')}}">Add New Book</a></li>
                          <li><a href="{{route('admin.add_book_stock_form')}}">Update Books Stock </a></li>
                          <li><a href="{{route('admin.book_stock_list')}}">Book Stocks </a></li>
                          <li><a href="{{route('admin.book_stock_history')}}">Books Stock History </a></li>
                        </ul>
                      </li>

                      <li><a>Other Stock<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="{{route('admin.update_other_stock_form')}}">Update Stock </a></li>
                          <li><a href="{{route('admin.other_stock_history')}}">Stock History </a></li>
                        </ul>
                      </li>
                      <li><a href="{{route('admin.other_stock_history')}}">Stock Summery </a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-desktop"></i>Employee<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('admin.add_employee_form')}}">Add New Employee</a></li>
                      <li><a href="{{route('admin.employee_list')}}">Employee List</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-bar-chart-o"></i> Configuration <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                      <li><a></i>Class <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="{{route('admin.add_class_form')}}">Add New Class</a></li>
                          <li><a href="{{route('admin.class_list')}}">Class List</a></li>
                        </ul>
                      </li>

                      <li><a></i>Batch <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="{{route('admin.add_new_batch_form')}}">Add Batch</a></li>
                          <li><a href="{{route('admin.Batch_list')}}">Batch List</a></li>
                        </ul>
                      </li>

                      <li><a></i>Admission Fees<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="{{route('admin.add_new_fee_form')}}">Add New Fees</a></li>
                          <li><a href="{{route('admin.admsn_fees_list')}}">Fees List</a></li>
                        </ul>
                      </li>

                      <li><a></i>Promotion Fees<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="{{route('admin.add_new_promotion_fee_form')}}">Add New Fees</a></li>
                          <li><a href="{{route('admin.promotion_fees_list')}}">Fees List</a></li>
                        </ul>
                      </li>

                      <li><a></i>Cloth Size<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="{{route('admin.add_cloth_size_form')}}">Add New Size</a></li>
                          <li><a href="{{route('admin.cloth_size_list')}}">Size List</a></li>
                        </ul>
                      </li>
                      <li><a href="{{route('admin.expense_list')}}">Add New Expense Name</a></li>

                    </ul>
                  </li>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="#">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
             <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
              
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->