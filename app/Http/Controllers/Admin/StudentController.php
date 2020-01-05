<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;

class StudentController extends Controller
{
    public function addPrevStudentForm()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.student.add_prev_std',compact('batch'));
    }

    public function addPrevStudent(Request $request)
    {
        $request->validate([
            'batch' => 'required',
            'admission_type' => 'required',
            'medium' => 'required',
            'class' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'mobile' => 'required',
            'village' => 'required',
            'po' => 'required',
            'ps' => 'required',
            'dist' => 'required',
            'pin' => 'required',
        ]);

        try {
            DB::transaction(function () use($request) {
              $student = DB::table('students')
                ->insertGetId([
                    'class_id' => $request->input('class'),
                    'batch_id' => $request->input('batch'),
                    'is_paid' => $request->input('admission_type'),
                    'medium' => $request->input('medium'),
                    'registered_by_id' => 'A',
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

                if ($student) {
                    $student_id = "WNS".$request->input('batch');
                    $length = 5 - intval(strlen((string) $student));
                    for ($i=0; $i < $length; $i++) { 
                        $student_id.='0';
                    } 
                    $student_id = $student_id.$student;
                    $update_student_id = DB::table('students')
                        ->where('id', $student)
                        ->update([
                            'student_id' =>  $student_id,
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);

                    $student_details = DB::table('student_details')
                        ->insert([
                            'student_id' => $student,
                            'name' => $request->input('name'),
                            'f_name' => $request->input('father_name'),
                            'm_name' => $request->input('mother_name'),
                            'gender' => $request->input('gender'),
                            'dob' => $request->input('dob'),
                            'caste' => $request->input('caste'),
                            'mobile' => $request->input('mobile'),
                            'f_qualification' => $request->input('fother_qualification'),

                            'm_qualification' => $request->input('mother_qualification'),
                            'f_occupaction' => $request->input('f_occupation'),
                            'annual_income' => $request->input('annual_income'),
                            'village' => $request->input('village'),
                            'po' => $request->input('po'),
                            'ps' => $request->input('ps'),
                            'dist' => $request->input('dist'),
                            'pin' => $request->input('pin'),
                            'last_exam' => $request->input('lase_exam'),
                            'last_school' => $request->input('last_school'),
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                    $student_class = DB::table('student_class')
                        ->insert([
                            'student_id' => $student,
                            'class_id' => $request->input('class'),
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                    
                }else {
                    return redirect()->back()->with('error','Something Went Wrong Please Try Again');
                }
     
            });
            return redirect()->back()->with('message','Student Added Successfully'); 
        }catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }
    public function addStudentForm()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.student.add_new_student',compact('batch'));
    }

    public function classFeesAjax($class,$medium)
    {
        $fees_total = DB::table('admsn_fee_structure')
            ->whereNull('admsn_fee_structure.deleted_at')
            ->where('admsn_fee_structure.fee_type',1)
            ->where('admsn_fee_structure.status',1)
            ->where('admsn_fee_structure.medium',$medium)
            ->where('admsn_fee_structure.class_id',$class)
            ->sum('amount');
        if ($fees_total > 0) {
            return number_format($fees_total,2,".",'');
        }else{
            return "0.00";
        }
    }

    public function classPromotionFeesAjax($class,$medium)
    {
        $fees_total = DB::table('admsn_fee_structure')
            ->whereNull('admsn_fee_structure.deleted_at')
            ->where('admsn_fee_structure.fee_type',2)
            ->where('admsn_fee_structure.status',1)
            ->where('admsn_fee_structure.medium',$medium)
            ->where('admsn_fee_structure.class_id',$class)
            ->sum('amount');
        if ($fees_total > 0) {
            return number_format($fees_total,2,".",'');
        }else{
            return "0.00";
        }
    }

    public function addNewStudent(Request $request)
    {
        $request->validate([
            'batch' => 'required',
            'admission_type' => 'required',
            'medium' => 'required',
            'class' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'mobile' => 'required',
            'village' => 'required',
            'po' => 'required',
            'ps' => 'required',
            'dist' => 'required',
            'pin' => 'required',
            'receive_amount' => 'required',
        ]);

        $admission_type = $request->input('admission_type');

        $fee_amount = DB::table('admsn_fee_structure')
            ->whereNull('admsn_fee_structure.deleted_at')
            ->where('admsn_fee_structure.fee_type',1)
            ->where('admsn_fee_structure.status',1)
            ->where('admsn_fee_structure.medium', $request->input('medium'))
            ->where('admsn_fee_structure.class_id',$request->input('class'))
            ->sum('amount');
        
        $fee_total_amount = 0;
        $discount = $request->input('scholarship_amount');
        if (empty($discount)) {
            $discount = 0;
        }
        $receive_amount = $request->input('receive_amount');
        if ($admission_type == 1) {
            if ($fee_amount < 1) {
                return redirect()->back()->with('error','Selected Class Fees Not Found');
            }else{
                $fee_total_amount = $fee_amount;
                if ($fee_total_amount < $receive_amount) {
                    return redirect()->back()->with('error','Receive Amount Can Not Be Greater Then Fees Amount');
                }
            }         
        }else{
            $discount =  $fee_amount;
        }
        
        $student = null;
        try {
            DB::transaction(function () use($request,$fee_total_amount,$discount,$admission_type,$receive_amount,&$student) {
              $student = DB::table('students')
                ->insertGetId([
                    'class_id' => $request->input('class'),
                    'batch_id' => $request->input('batch'),
                    'is_paid' => $request->input('admission_type'),
                    'medium' => $request->input('medium'),
                    'registered_by_id' => 'A',
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

                if ($student) {
                    $batch = DB::table('student_batch')->where('id',$request->input('batch'))->first();
                    $student_id = "WNS".$batch->name;
                    $length = 5 - intval(strlen((string) $student));
                    for ($i=0; $i < $length; $i++) { 
                        $student_id.='0';
                    } 
                    $student_id = $student_id.$student;
                    $update_student_id = DB::table('students')
                        ->where('id', $student)
                        ->update([
                            'student_id' =>  $student_id,
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);

                    $student_details = DB::table('student_details')
                        ->insert([
                            'student_id' => $student,
                            'name' => $request->input('name'),
                            'f_name' => $request->input('father_name'),
                            'm_name' => $request->input('mother_name'),
                            'gender' => $request->input('gender'),
                            'dob' => $request->input('dob'),
                            'caste' => $request->input('caste'),
                            'mobile' => $request->input('mobile'),
                            'f_qualification' => $request->input('fother_qualification'),

                            'm_qualification' => $request->input('mother_qualification'),
                            'f_occupaction' => $request->input('f_occupation'),
                            'annual_income' => $request->input('annual_income'),
                            'village' => $request->input('village'),
                            'po' => $request->input('po'),
                            'ps' => $request->input('ps'),
                            'dist' => $request->input('dist'),
                            'pin' => $request->input('pin'),
                            'last_exam' => $request->input('lase_exam'),
                            'last_school' => $request->input('last_school'),
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                    $student_admsn_fee = DB::table('student_admsn_fees')
                            ->insert([
                                'student_id' => $student,
                                'class_id' => $request->input('class'),
                                'batch_id' => $request->input('batch'),
                                'receive_amount' => $receive_amount,
                                'pending_amount' => ($fee_total_amount - $receive_amount - $discount),
                                'fees_amount' => $fee_total_amount,
                                'discount' => $discount,
                                'is_paid' => $admission_type,
                                'received_by' => 'A',
                                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                        if ($admission_type == 1) {
                            $student_admsn_fee = DB::table('student_admsn_fees_details')
                            ->insert([
                                'student_id' => $student,
                                'fee_type' => 2,
                                'amount' => $receive_amount,
                                'comments' => "Amount Received By Admin",
                                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                        }
                    $student_class = DB::table('student_class')
                        ->insert([
                            'student_id' => $student,
                            'class_id' => $request->input('class'),
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                    
                }else {
                    return redirect()->back()->with('error','Something Went Wrong Please Try Again');
                }
     
            });
            $batch = $request->input('batch');
            return redirect()->route('admin.student_thank_you',['student_id'=>encrypt($student),'batch_id'=>encrypt($batch)]);      
        }catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function studentList()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.student.student_list',compact('batch'));
    }

    public function studentListAjax($medium = null,$batch = null, $class = null)
    {
        $query = DB::table('students')
            ->select('students.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','student_details.gender as gender')
            ->leftjoin('class','class.id','=','students.class_id')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id');
        if (!empty($medium)) {
            $query = $query->where('students.medium',$medium);
        }
        if (!empty($batch)) {
            $query = $query->where('students.batch_id',$batch);
        }
        if (!empty($class)) {
            $query = $query->where('students.class_id',$class);
        }
        $query = $query->orderBy('students.id','desc');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="'.route('admin.student_details',['student_id'=>encrypt($row->id)]).'" class="btn btn-primary btn-sm" target="_blank">View</a>
            <a href="'.route('admin.student_edit',['student_id'=>encrypt($row->id)]).'" class="btn btn-success btn-sm">Edit</a>';
            
             return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function studentDetails($student_id)
    {
        try {
            $student_id = decrypt($student_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $student = DB::table('students')
            ->select('students.*','class.name as class_name','student_batch.name as batch_name')
            ->leftjoin('class','class.id','=','students.class_id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->where('students.id',$student_id)
            ->first();
        $student_details =  DB::table('student_details')->where('student_id',$student_id)->first();
        return view('admin.student.student_details',compact('student','student_details'));
    }

    public function studentEdit($student_id)
    {
        try {
            $student_id = decrypt($student_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $batch = DB::table('student_batch')->get();
        $student = DB::table('students')
        ->where('id',$student_id)
        ->first();
        $class = null;
        if ($student) {
            $class = DB::table('class')->where('medium',$student->medium)->whereNull('deleted_at')->get();
        }
        $student_details =  DB::table('student_details')->where('student_id',$student_id)->first();
        return view('admin.student.edit_student',compact('batch','student','student_details','class'));
    }

    public function studentUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'mobile' => 'required',
            'village' => 'required',
            'po' => 'required',
            'ps' => 'required',
            'dist' => 'required',
            'pin' => 'required',
            'student_id' => 'required',
        ]);

        $student_details = DB::table('student_details')
            ->where('student_id',$request->input('student_id'))
            ->update([
                'name' => $request->input('name'),
                'f_name' => $request->input('father_name'),
                'm_name' => $request->input('mother_name'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
                'caste' => $request->input('caste'),
                'mobile' => $request->input('mobile'),
                'f_qualification' => $request->input('fother_qualification'),

                'm_qualification' => $request->input('mother_qualification'),
                'f_occupaction' => $request->input('f_occupation'),
                'annual_income' => $request->input('annual_income'),
                'village' => $request->input('village'),
                'po' => $request->input('po'),
                'ps' => $request->input('ps'),
                'dist' => $request->input('dist'),
                'pin' => $request->input('pin'),
                'last_exam' => $request->input('lase_exam'),
                'last_school' => $request->input('last_school'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        return redirect()->back()->with('message','Student Data Updated Successfully');     
    }

    public function studentPromote()
    {
        $batch = DB::table('student_batch')->get();
        return view('admin.student.promote_student_search',compact('batch'));
    }

    public function studentPromoteSearch(Request $request)
    {
        $request->validate([
            'batch' => 'required',
            'medium' => 'required',
            'class' => 'required',
        ]);

        $batch = DB::table('student_batch')->get();
        $students = DB::table('students')
            ->select('students.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','student_details.gender as gender')
            ->leftjoin('class','class.id','=','students.class_id')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->where('students.medium',$request->input('medium'))
            ->where('students.batch_id',$request->input('batch'))
            ->where('students.class_id',$request->input('class'))
            ->get();
        $promote_class = null;
        $class_name = null;
        $class_order = DB::table('class')
            ->where('id',$request->input('class'))
            ->first();
        if ($class_order) {            
            $promote_class = DB::table('class')
                ->where('medium',$request->input('medium'))
                ->where('class_order','>',$class_order->class_order)
                ->get();
            $class_name = $class_order->name;
        }
        
        return view('admin.student.promote_student_search',compact('batch','students','class_name'));
    }

    public function studentPromoteForm($student_id)
    {
        
        try {
            $student_id = decrypt($student_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        
        $students = DB::table('students')
            ->select('students.*','class.name as class_name','student_batch.name as batch_name','student_details.name as s_name','student_details.f_name as f_name','student_details.m_name as m_name','student_details.gender as gender')
            ->leftjoin('class','class.id','=','students.class_id')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
            ->where('students.id',$student_id)
            ->first();
        $batch = null;
        $class = null;
        if ($students) {
            $batch = DB::table('student_batch')->where('name','>',$students->batch_name)->get();
            $current_class = DB::table('class')->where('id',$students->class_id)->first();
            if ($current_class) {
                $class =  DB::table('class')->where('class_order','>',$current_class->class_order)->get();
            }
        }
        
        return view('admin.student.promote_student_form',compact('batch','students','class'));
    }

    public function studentPromoteInsert(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'batch' => 'required',
            'admission_type' => 'required',
            'medium' => 'required',
            'class' => 'required',
            'receive_amount' => 'required',
        ]);
        $student_id = $request->input('student_id');
        $batch = $request->input('batch');
        $admission_type = $request->input('admission_type');
        $medium = $request->input('medium');
        $class = $request->input('class');
        $promotion_fees =  $fees_total = DB::table('admsn_fee_structure')
            ->whereNull('admsn_fee_structure.deleted_at')
            ->where('admsn_fee_structure.fee_type',2)
            ->where('admsn_fee_structure.status',1)
            ->where('admsn_fee_structure.medium',$medium)
            ->where('admsn_fee_structure.class_id',$class)
            ->sum('amount');
        $discount = $request->input('scholarship_amount');
        if (empty($discount)) {
            $discount = 0;
        }
        
        $receive_amount = $request->input('receive_amount');
       $scholarship = $request->input('');
        if ($admission_type == 1) {
            if ($promotion_fees < 1) {
                return redirect()->back()->with('error','Please Set Promotion Fees For The Class Before Promote');
            }
            if ($promotion_fees < $receive_amount) {
                return redirect()->back()->with('error','Promotion Fees Can Not Be Greater Then Receive Amount');
            }
        }
        try {
            DB::transaction(function () use($student_id,$batch,$admission_type,$medium,$class,$promotion_fees,$receive_amount,$discount) {

                if ($promotion_fees > 0) {
                    DB::table('student_promotion_fees')
                        ->insert([
                            'student_id' => $student_id,
                            'class_id' => $class,
                            'batch_id' => $batch,
                            'fees_amount' => $promotion_fees,
                            'receive_amount' => $receive_amount,
                            'discount' => $discount,
                            'pending_amount' => ($promotion_fees - $receive_amount),
                            'is_paid' => 2,
                            'received_by'=>'A',
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
        
                    DB::table('student_promotion_fees_details')
                        ->insert([
                            'student_id' => $student_id,
                            'fee_type' => 2,
                            'amount' => $receive_amount,
                            'comments' => "Fees Received By Admin",
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
        
                }
                DB::table('students')
                ->where('id',$student_id)
                ->update([
                    'class_id' => $class,
                    'batch_id' => $batch,
                    'is_paid' => $admission_type,
                    'medium' => $medium,
                    'fee_status' => 2,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

                DB::table('student_class')
                    ->insert([
                        'student_id' => $student_id,
                        'class_id' => $class,
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);
            });
            return redirect()->route('admin.student_promotion_thank_you',['student_id'=>encrypt($student_id),'batch_id'=>encrypt($batch)]); 
            
        }catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }

    }

    public function GenerateMonthlyFee()
    {
        $batch = DB::table('student_batch')->orderBy('id','desc')->limit(1)->first();
     
        $month = null;
        if ($batch) {
            $month = DB::table('fees_month')
            ->select('fees_month.*','student_batch.name as batch_name')
            ->join('student_batch','student_batch.id','=','fees_month.batch_id')
            ->where('fees_month.batch_id',$batch->id)->get();
        }
        return view('admin.student.generate_fee',compact('batch','month'));
    }

    public function GenerateMonthlyFeeInsert(Request $request)
    {
        $request->validate([
            'batch_id' => 'required',
            'month_id' => 'required',
        ]);

        $batch_id = $request->input('batch_id');
        $month_id = $request->input('month_id');

        $class = DB::table('class')->where('status',1)->whereNull('deleted_at')->get();
        if ($class) {
            try {
                DB::transaction(function () use($class,$batch_id,$month_id) {
                    foreach ($class as $key => $value) {
                        $students = DB::table('students')
                            ->where('class_id',$value->id)
                            ->where('batch_id',$batch_id)
                            ->whereNull('deleted_at')
                            ->get();
                        foreach ($students as  $student) {
                            if ($student->is_paid == '2') {
                                DB::table('student_monthly_fees')
                                    ->insert([
                                        'student_id' => $student->id,
                                        'class_id' => $value->id,
                                        'month_id' => $month_id,
                                        'receive_amount' => 0,
                                        'pending_amount' => 0,
                                        'amount' => 0,
                                        'is_paid' => 1,
                                        'discount' => $value->monthly_fees,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } else {
                                DB::table('student_monthly_fees')
                                ->insert([
                                    'student_id' => $student->id,
                                    'class_id' => $value->id,
                                    'month_id' => $month_id,
                                    'receive_amount' => 0,
                                    'pending_amount' => $value->monthly_fees,
                                    'amount' => $value->monthly_fees,
                                    'discount' => 0,
                                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                                DB::table('student_monthly_fee_details')
                                    ->insert([
                                        'student_id' => $student->id,
                                        'fee_type' => 1,
                                        'amount' => $value->monthly_fees,
                                        'comments' => "Monthly Fee Generated By Admin",
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            }
                            
                        }
                    }

                    DB::table('fees_month')
                        ->where('id',$month_id)
                        ->update(['status'=>2]);
                });
                return redirect()->back()->with('message','This Month Fees Generated');
            }catch (\Exception $e) {
                dd($e);
                return redirect()->back()->with('error','Something Went Wrong Please Try Again');
            }
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }
}
