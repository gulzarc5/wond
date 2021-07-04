<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;

class ReportController extends Controller
{
    public function admissionFee()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.fees_report.admsn_fee',compact('batch'));
    }

    public function admissionFeeAjax($batch = null,$medium = null,$class = null)
    {
        $query = DB::table('student_admsn_fees')
            ->select('student_admsn_fees.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','students.medium as st_medium','students.student_id as s_student_id')
            ->leftjoin('students','students.id','=','student_admsn_fees.student_id')
            ->leftjoin('student_details','student_details.student_id','=','student_admsn_fees.student_id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->leftjoin('class','class.id','=','student_admsn_fees.class_id');
           
        if (!empty($medium)) {
            $query = $query->where('students.medium',$medium);
        }
        if (!empty($batch)) {
            $query = $query->where('students.batch_id',$batch);
        }
        if (!empty($class)) {
            $query = $query->where('students.class_id',$class);
        }    
        $query = $query->orderBy('student_admsn_fees.id','desc');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('rec_by', function($row){
            if ($row->received_by == 'A') {
                $btn = 'Admin';
            }else{
                $btn = 'Employee';
            }
            return $btn;
        })
        ->addColumn('status_tab', function($row){
            if ($row->pending_amount == 0) {
                $btn = 'Paid';
            }else{
                $btn = '--';
            }
            return $btn;
        })
        ->rawColumns(['rec_by','status_tab'])
        ->make(true);
    }

    public function admissionFeeReportSearch(Request $request)
    {
        $request->validate([
            'batch' => 'required',
        ]);
        $batch = $request->input('batch');
        $medium = $request->input('medium');
        $class = $request->input('class');

        $query = DB::table('student_admsn_fees')
        ->select('student_admsn_fees.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','students.medium as st_medium','students.student_id as s_student_id')
        ->leftjoin('students','students.id','=','student_admsn_fees.student_id')
        ->leftjoin('student_details','student_details.student_id','=','student_admsn_fees.student_id')
        ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
        ->leftjoin('class','class.id','=','student_admsn_fees.class_id');
       
        if (!empty($medium)) {
            $query = $query->where('students.medium',$medium);
        }
        if (!empty($batch)) {
            $query = $query->where('students.batch_id',$batch);
        }
        if (!empty($class)) {
            $query = $query->where('students.class_id',$class);
        }    
        $student_fees = $query->orderBy('student_admsn_fees.id','desc')->get();
        $batch = DB::table('student_batch')->get();
        return view('admin.fees_report.admsn_fee',compact('student_fees','batch'));
    }

    public function promotionFee()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.fees_report.promotion_fee',compact('batch'));
    }

    public function promotionFeeAjax($batch = null,$medium = null,$class = null)
    {
        $query = DB::table('student_promotion_fees')
            ->select('student_promotion_fees.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','students.medium as st_medium','students.student_id as st_student_id')
            ->leftjoin('students','students.id','=','student_promotion_fees.student_id')
            ->leftjoin('student_details','student_details.student_id','=','student_promotion_fees.student_id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->leftjoin('class','class.id','=','student_promotion_fees.class_id');
           
        if (!empty($medium)) {
            $query = $query->where('students.medium',$medium);
        }
        if (!empty($batch)) {
            $query = $query->where('students.batch_id',$batch);
        }
        if (!empty($class)) {
            $query = $query->where('students.class_id',$class);
        }    
        $query = $query->orderBy('student_promotion_fees.id','desc');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('rec_by', function($row){
            if ($row->received_by == 'A') {
                $btn = 'Admin';
            }else{
                $btn = 'Employee';
            }
            return $btn;
        })
        ->addColumn('status_tab', function($row){
            if ($row->pending_amount == 0) {
                $btn = 'Paid';
            }else{
                $btn = '--';
            }
            return $btn;
        })
        ->rawColumns(['rec_by','status_tab'])
        ->make(true);
    }

    public function promotionFeeReportSearch(Request $request)
    {
        $request->validate([
            'batch' => 'required',
        ]);
        $batch = $request->input('batch');
        $medium = $request->input('medium');
        $class = $request->input('class');
        
        $query = DB::table('student_promotion_fees')
            ->select('student_promotion_fees.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','students.medium as st_medium','students.student_id as s_student_id')
            ->leftjoin('students','students.id','=','student_promotion_fees.student_id')
            ->leftjoin('student_details','student_details.student_id','=','student_promotion_fees.student_id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->leftjoin('class','class.id','=','student_promotion_fees.class_id');
       
        if (!empty($medium)) {
            $query = $query->where('students.medium',$medium);
        }
        if (!empty($batch)) {
            $query = $query->where('students.batch_id',$batch);
        }
        if (!empty($class)) {
            $query = $query->where('students.class_id',$class);
        }    
        $student_fees = $query->orderBy('student_promotion_fees.id','desc')->get();
        $batch = DB::table('student_batch')->get();
        return view('admin.fees_report.promotion_fee',compact('student_fees','batch'));

    }

    public function monthlyFee()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.fees_report.monthly_fee',compact('batch'));
    }

    public function monthlyFeeAjax()
    {
        $query = DB::table('student_monthly_fees')
            ->select('student_monthly_fees.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','students.medium as st_medium')
            ->leftjoin('students','students.id','=','student_monthly_fees.student_id')
            ->leftjoin('student_details','student_details.student_id','=','student_monthly_fees.student_id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->leftjoin('class','class.id','=','student_monthly_fees.class_id')
            ->orderBy('student_monthly_fees.id','desc');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->rawColumns(['rec_by'])
        ->make(true);
    }

    public function MonthFetchAjax($batch_id)
    {
        $batch =  DB::table('fees_month')->where('batch_id',$batch_id)->get();
        return $batch;
    }

    public function monthlyFeeSearch(Request $request)
    {
        $request->validate([
            'batch' => 'required',
            'month' => 'required',
        ]);
        $batch = $request->input('batch');
        $month = $request->input('month');
        $medium = $request->input('medium');
        $class = $request->input('class');
        
        $med_view  = null;
        $class_data = null;
        if (isset($medium) && !empty($medium)) {
            $med_view  = "Bengali";
            if ($medium == '2') {
                $med_view  = "English";
            }
        }
        if (isset($class) && !empty($class)) {
            $class_data = DB::table('class')->where('id',$class)->first();
            $class_name = $class_data->name;
        }       
        
        $month_data = DB::table('fees_month')->where('id',$month)->first();
        $month_name = $month_data->month;


        $query = DB::table('student_monthly_fees')
            ->select('student_monthly_fees.*','students.student_id as std_id','student_details.name as std_name')
            ->leftjoin('students','students.id','=','student_monthly_fees.student_id')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->where('student_monthly_fees.month_id',$month);
            if (!empty($class)) {
                $query = $query->where('student_monthly_fees.class_id',$class);
            }
        $monthly_fees = $query->orderby('student_monthly_fees.id','desc')->get();
        $batch = DB::table('student_batch')->get();
        return view('admin.fees_report.monthly_fee',compact('batch','monthly_fees','med_view','class_name','month_name'));


    }

    public function thankYou($student_id,$batch_id)
    {
        try {
            $student_id = decrypt($student_id);
            $batch_id = decrypt($batch_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $student = DB::table('students')
            ->select('students.*','class.name as c_name','student_batch.name as b_name','student_details.name as s_name')
            ->leftjoin('class','class.id','=','students.class_id')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->where('students.id',$student_id)
            ->where('students.batch_id',$batch_id)
            ->first();
        $admsn = DB::table('student_admsn_fees')
            ->where('student_id',$student_id)
            ->first();
        return view('admin.student.thank_you',compact('student','admsn'));
    }

    public function promotionThankYou($student_id,$batch_id)
    {
        try {
            $student_id = decrypt($student_id);
            $batch_id = decrypt($batch_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $student = DB::table('students')
            ->select('students.*','class.name as c_name','student_batch.name as b_name','student_details.name as s_name')
            ->leftjoin('class','class.id','=','students.class_id')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->where('students.id',$student_id)
            ->where('students.batch_id',$batch_id)
            ->first();
        
        $prmsn = null;
        if ($student) {
            $prmsn = DB::table('student_promotion_fees')
                ->where('student_id',$student_id)
                ->where('class_id',$student->class_id)
                ->first();
        }        
        return view('admin.student.promotion_thank',compact('student','prmsn'));
    }
}
