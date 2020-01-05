@extends('admin.template.admin_master')

@section('content')

  <div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
      <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Student</span>
        <div class="count green">
          @if (isset($student))
              {{$student}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Total Class (Bengali)</span>
        <div class="count green">
          @if (isset($class_b))
              {{$class_b}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Total Class (English)</span>
        <div class="count green">
          @if (isset($class_e))
              {{$class_e}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
          <span class="count_top"><i class="fa fa-user"></i> Total Employee</span>
          <div class="count green">
            @if (isset($employee))
                {{$employee}}
            @endif
          </div>
      </div>
    </div>

    <div class="row tile_count">
      <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count">
        <b style="font-size: 26px;display: flex;justify-content: center;">Admission</b>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Admission Fees</span>
        <div class="count green">
          @if (isset($total_admsn_fees))
              {{$total_admsn_fees}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Admission Fees Received</span>
        <div class="count green">
          @if (isset($total_admsn_fees_received))
              {{$total_admsn_fees_received}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Admission Fees Pending</span>
        <div class="count green">
          @if (isset($total_admsn_fees_pending))
              {{$total_admsn_fees_pending}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Admission Fees Scholarship</span>
        <div class="count green">
          @if (isset($total_admsn_fees_scholarship))
              {{$total_admsn_fees_scholarship}}
          @endif
        </div>
      </div>
    </div>
    <div class="row tile_count">
      <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count">
        <b style="font-size: 26px;display: flex;justify-content: center;">Promotion</b>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Promotion Fees</span>
        <div class="count green">
          @if (isset($total_prmsn_fees))
              {{$total_prmsn_fees}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Promotion Fees Received</span>
        <div class="count green">
          @if (isset($total_prmsn_fees_received))
              {{$total_prmsn_fees_received}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Promotion Fees Pending</span>
        <div class="count green">
          @if (isset($total_prmsn_fees_pending))
              {{$total_prmsn_fees_pending}}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Promotion Fees Scholarship</span>
        <div class="count green">
          @if (isset($total_prmsn_fees_scholarship))
              {{$total_prmsn_fees_scholarship}}
          @endif
        </div>
      </div>
    </div>
    <!-- /top tiles -->

    {{-- <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_content">
                 <div class="table-responsive">
                    <h2>Last 10 Added Jobs</h2>
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">                
                                <th class="column-title">Sl No. </th>
                                <th class="column-title">Post Name</th>
                                <th class="column-title">Department</th>
                                <th class="column-title">Job Location</th>
                                <th class="column-title">Last Date</th>
                                <th class="column-title">Posted Date</th>
                                <th class="column-title">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
              </div>
          </div>
      </div>
    </div> --}}

  </div>

 @endsection