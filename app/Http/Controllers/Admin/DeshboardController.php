<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class DeshboardController extends Controller
{
    public function index()
    {
        $student = 0;
        $class_b = 0;
        $class_e = 0;
        $employee = 0;
        $total_admsn_fees = 0;
        $total_admsn_fees_received = 0;
        $total_admsn_fees_pending = 0;
        $total_admsn_fees_scholarship = 0;

        $total_prmsn_fees = 0;
        $total_prmsn_fees_received = 0;
        $total_prmsn_fees_pending = 0;
        $total_prmsn_fees_scholarship = 0;

        $total_fees = 0;
        $total_fees_received = 0;
        $total_fees_pending = 0;
        $total_fees_scholarship = 0;

        $batch = DB::table('student_batch')->orderBy('id','desc')->limit(1)->first();
        if ($batch) {
            $student = DB::table('students')->where('batch_id',$batch->id)->count();
            $class_b = DB::table('class')->where('medium',1)->count();
            $class_e = DB::table('class')->where('medium',2)->count();
            $employee = DB::table('employee')->where('status',1)->whereNull('deleted_at')->count();

            $total_admsn_student = DB::table('student_admsn_fees')
                ->where('batch_id',$batch->id)
                ->whereNull('deleted_at');
            $total_admsn_fees = $total_admsn_student->sum('fees_amount');
            $total_admsn_fees_received = $total_admsn_student->sum('receive_amount');
            $total_admsn_fees_pending = $total_admsn_student->sum('pending_amount');
            $total_admsn_fees_scholarship = $total_admsn_student->sum('discount');

            $total_prmsn_student = DB::table('student_promotion_fees')
                ->where('batch_id',$batch->id)
                ->whereNull('deleted_at');
            $total_prmsn_fees = $total_prmsn_student->sum('fees_amount');
            $total_prmsn_fees_received = $total_prmsn_student->sum('receive_amount');
            $total_prmsn_fees_pending = $total_prmsn_student->sum('pending_amount');
            $total_prmsn_fees_scholarship = $total_prmsn_student->sum('discount');

            $total_fees_data = DB::table('student_monthly_fees')
                ->join('fees_month','fees_month.id','=','student_monthly_fees.month_id')
                ->where('fees_month.batch_id',$batch->id);
            $total_fees = $total_fees_data->sum('student_monthly_fees.amount');
            $total_fees_received = $total_fees_data->sum('student_monthly_fees.receive_amount');
            $total_fees_pending = $total_fees_data->sum('student_monthly_fees.pending_amount');
            $total_fees_scholarship = $total_fees_data->sum('student_monthly_fees.discount');
        }
        return view('admin.admindeshboard',compact('student','class_b','class_e','employee','total_admsn_fees','total_admsn_fees_received','total_admsn_fees_pending','total_admsn_fees_scholarship','total_prmsn_fees','total_prmsn_fees_received','total_prmsn_fees_pending','total_prmsn_fees_scholarship','total_fees','total_fees_received','total_fees_pending','total_fees_scholarship'));
    }
}
