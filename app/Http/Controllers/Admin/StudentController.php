<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;
use SmsHelpers;

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
                    $arr1 = explode(' ',trim($request->input('name')));
                    $name =  $arr1[0];
                    $sym = "Mr.";
                    if ($request->input('gender') == 'F') {
                         $sym = "Miss.";
                    }
                    $request_info = urldecode("Dear Parent, updates related to your ward and school will be sent to you via SMS.Wonderland National School,Latakandi.");
                    SmsHelpers::smsSend($request->input('mobile'),$request_info);
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
                    $arr1 = explode(' ',trim($request->input('name')));
                    $name =  $arr1[0];
                    $class_name = DB::table('class')->where('id',$request->input('class'))->first();
                    $request_info = urldecode("Dear Parent, updates related to your ward and school will be sent to you via SMS.Wonderland National School,Latakandi.");
                    SmsHelpers::smsSend($request->input('mobile'),$request_info);
                    
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
                            'pending_amount' => ($promotion_fees - $receive_amount - $discount),
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
            $student_name = DB::table('students')
                ->select('student_details.name as s_name','student_details.mobile as mobile')
                ->leftjoin('student_details','student_details.student_id','=','students.id')
                ->where('students.id',$student_id)
                ->first();
            $arr1 = explode(' ',trim($student_name->s_name));
            $name =  $arr1[0];
            $class_name = DB::table('class')->where('id',$class)->first();
            $request_info = urldecode("Dear Parent, updates related to your ward and school will be sent to you via SMS.Wonderland National School,Latakandi.");
            SmsHelpers::smsSend($student_name->mobile,$request_info);
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
                                        'amount' => $value->monthly_fees,
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

    public function feeReceiveStudentForm()
    {
        return view('admin.student.receive_student_fee');
    }

    public function studentFeeSearch($student_id)
    {
        $student = DB::table('students')
            ->select('students.*','student_details.name as s_name','student_details.f_name as f_name','class.name as c_name')
            ->leftjoin('student_details','student_details.student_id','=','students.id')
            ->leftjoin('class','class.id','=','students.class_id')
            ->where('students.student_id',$student_id)
            ->first();
        if ($student) {
            $admsnFees = DB::table('student_admsn_fees')
                ->where('student_id',$student->id)
                ->sum('pending_amount');        
            $promotion_fees = DB::table('student_promotion_fees')
                ->where('student_id',$student->id)
                ->sum('pending_amount');
            $monthly_fees = DB::table('student_monthly_fees')
                ->where('student_id',$student->id)
                ->sum('pending_amount');
            $html = '<div class="row invoice-info" style="padding: 20px;font-size: 16px;">
                    <div class="col-sm-12 invoice-col">
                        <address class="font-15"><strong>Student Name : </strong>'.$student->s_name.'</address>
                    </div>
                    <div class="col-sm-12 invoice-col">
                        <address class="font-15"><strong>Father Name : </strong>'.$student->f_name.'</address>
                    </div>
                    <div class="col-sm-12 invoice-col">
                        <address class="font-15"><strong>Class Name : </strong>'.$student->c_name.'</address>
                    </div>';
            if ($admsnFees > 0) {
                $html .='<div class="col-sm-12 invoice-col">
                <address class="font-15"><strong>Admission Fees : </strong>'.number_format($admsnFees,2,".",'').'</address>
                </div>';
            }  
            if ($promotion_fees > 0) {
                $html .='<div class="col-sm-12 invoice-col">
                <address class="font-15"><strong>Promotion Fees : </strong>'.number_format($promotion_fees,2,".",'').'</address>
                </div>';
            }  
            if ($monthly_fees > 0) {
                $html .='<div class="col-sm-12 invoice-col">
                <address class="font-15"><strong>Monthly Fees : </strong>'.number_format($monthly_fees,2,".",'').'</address>
                </div>';
            } 
            if (($admsnFees < 1) && ($promotion_fees < 1 )  && ($monthly_fees < 1) ) {
                $html.= '<div class="col-sm-12 invoice-col" style="color: #00b8ff;font-size: 21px;">
                    <address class="font-15"><strong> The Student Have No Pending Fees </strong></address>
                </div>';
            }else{
                $html .='<div class="col-sm-12 invoice-col">
                <address class="font-15"><strong>Total Pending Fees : </strong><b style="color:red">'.number_format(($admsnFees+$promotion_fees+$monthly_fees),2,".",'').'</b></address>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 mb-3" style="color:#ff00a5;font-size: 15px;"><label for="name">Enter Receive Amount :</label></div>
                <div class="col-md-8 col-sm-12 col-xs-12 mb-3"><input type="number" class="form-control"  placeholder="Enter Receive Amount" min="1" max="'.intval($admsnFees+$promotion_fees+$monthly_fees).'" id="std_id" required name="receive_amt"></div>
                
                <div class="col-sm-12 invoice-col" style="padding-top: 26px;text-align: center;">
                    <button type="submit" class="btn btn-primary">Receive Fees</button>
                </div>';
            }            
            $html .='</div>';
            return $html;
        } else {
            return 1;
        } 
    }

    public function feeReceiveStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'receive_amt' => 'required',
        ]);

        $admsn_fee_status = null;
        $prmsn_fee_status = null;
        $monthly_fee_status = null;

        $student_id = $request->input('student_id');
        $receive_amount = $request->input('receive_amt');

        if ($receive_amount < 1) {
            return redirect()->back()->with('error','Receive Amount Should Be Greater Then Zero');
        }

        $student = DB::table('students')->where('student_id',$student_id)->first();
        if (!$student) {
            return redirect()->back()->with('error','Student Not Found');
        }
        // Admission Fees
        $admsnFees = DB::table('student_admsn_fees')->where('student_id',$student->id)->sum('pending_amount'); 
        if ($admsnFees > 0) {
            $admsnRcvAmt = 0;
            if ($admsnFees < $receive_amount) {
                $receive_amount = $receive_amount - $admsnFees;
                $admsnRcvAmt = $admsnFees;
            }else{
                $admsnRcvAmt = $receive_amount;
                $receive_amount = 0;
            }
            if ($admsnRcvAmt > 0) {
                $adms_fee_student= DB::table('student_admsn_fees')
                    ->where('student_id',$student->id)
                    ->where('pending_amount','>',0)
                    ->get();
                $admsn_rcv_amt = 0;
                foreach ($adms_fee_student as $key => $value) {
                    if ($admsnRcvAmt  > 0) {
                        if ($value->pending_amount < $admsnRcvAmt){
                            $admsnRcvAmt = $admsnRcvAmt - $value->pending_amount;
                            DB::table('student_admsn_fees')
                                ->where('id',$value->id)
                                ->update([
                                    'receive_amount' => DB::raw("`receive_amount`+".($value->pending_amount)),
                                    'pending_amount' => 0,
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                            $admsn_rcv_amt = $admsn_rcv_amt + $value->pending_amount;
                        }else{
                            DB::table('student_admsn_fees')
                                ->where('id',$value->id)
                                ->update([
                                    'receive_amount' => DB::raw("`receive_amount`+".($admsnRcvAmt)),
                                    'pending_amount' => DB::raw("`pending_amount`-".($admsnRcvAmt)),
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                            $admsn_rcv_amt = $admsn_rcv_amt +  $admsnRcvAmt;
                            $admsnRcvAmt = 0;
                        }
                    }
                }
                DB::table('student_admsn_fees_details')
                    ->insert([
                        'student_id' => $student->id,
                        'fee_type' => 2,
                        'amount' => $admsn_rcv_amt,
                        'comments' => 'Pending Amount Received By Admin',
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);
                $admsn_fee_status = 1;
            }
        }
        // Promotion Fees
        if ($receive_amount > 0) {
            $promotion_fees = DB::table('student_promotion_fees')->where('student_id',$student->id)->sum('pending_amount');
            $prmsnRcvAmt = 0;
            if ($promotion_fees > 0) {
                if ($promotion_fees < $receive_amount) {
                    $receive_amount = $receive_amount - $promotion_fees;
                    $prmsnRcvAmt = $promotion_fees;
                }else{
                    $prmsnRcvAmt = $receive_amount;
                    $receive_amount = 0;
                }
            }

            if ($prmsnRcvAmt > 0) {
                $prmsn_fee_student= DB::table('student_promotion_fees')
                    ->where('student_id',$student->id)
                    ->where('pending_amount','>',0)
                    ->get();
                $prmsn_rcv_amt = 0;

                foreach ($prmsn_fee_student as $key => $value) {
                    if ($prmsnRcvAmt  > 0) {
                        if ($value->pending_amount < $prmsnRcvAmt){
                            $prmsnRcvAmt = $prmsnRcvAmt - $value->pending_amount;
                            DB::table('student_promotion_fees')
                                ->where('id',$value->id)
                                ->update([
                                    'receive_amount' => DB::raw("`receive_amount`+".($value->pending_amount)),
                                    'pending_amount' => 0,
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                            $prmsn_rcv_amt = $prmsn_rcv_amt + $value->pending_amount;
                        }else{
                            DB::table('student_promotion_fees')
                                ->where('id',$value->id)
                                ->update([
                                    'receive_amount' => DB::raw("`receive_amount`+".($prmsnRcvAmt)),
                                    'pending_amount' => DB::raw("`pending_amount`-".($prmsnRcvAmt)),
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                            $prmsn_rcv_amt = $prmsn_rcv_amt +  $prmsnRcvAmt;
                            $prmsnRcvAmt = 0;
                        }
                    }
                }
                DB::table('student_promotion_fees_details')
                    ->insert([
                        'student_id' => $student->id,
                        'fee_type' => 2,
                        'amount' => $prmsn_rcv_amt,
                        'comments' => 'Pending Amount Received By Admin',
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);
                $prmsn_fee_status = 1;
            }
        }

        //Monthly Fees
        if ($receive_amount > 0) {
            $monthly_fees = DB::table('student_monthly_fees')->where('student_id',$student->id)->sum('pending_amount');
            $monthlyRcvAmt = 0 ;
            if ($monthly_fees > 0) {
                if ($monthly_fees < $receive_amount) {
                    $receive_amount = $receive_amount - $monthly_fees;
                    $monthlyRcvAmt = $monthly_fees;
                }else{
                    $monthlyRcvAmt = $receive_amount;
                    $receive_amount = 0;
                }
            }

            if ($monthlyRcvAmt > 0) {
                $monthly_fee_student= DB::table('student_monthly_fees')
                    ->where('student_id',$student->id)
                    ->where('pending_amount','>',0)
                    ->get();
                $monthly_rcv_amt = 0;

                foreach ($monthly_fee_student as $key => $value) {
                    if ($monthlyRcvAmt  > 0) {
                        if ($value->pending_amount < $monthlyRcvAmt){
                            $monthlyRcvAmt = $monthlyRcvAmt - $value->pending_amount;
                            DB::table('student_monthly_fees')
                                ->where('id',$value->id)
                                ->update([
                                    'receive_amount' => DB::raw("`receive_amount`+".($value->pending_amount)),
                                    'pending_amount' => 0,
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                            $monthly_rcv_amt = $monthly_rcv_amt + $value->pending_amount;
                        }else{
                            DB::table('student_monthly_fees')
                                ->where('id',$value->id)
                                ->update([
                                    'receive_amount' => DB::raw("`receive_amount`+".($monthlyRcvAmt)),
                                    'pending_amount' => DB::raw("`pending_amount`-".($monthlyRcvAmt)),
                                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                ]);
                            $monthly_rcv_amt = $monthly_rcv_amt +  $monthlyRcvAmt;
                            $monthlyRcvAmt = 0;
                        }
                    }
                }
                DB::table('student_monthly_fee_details')
                    ->insert([
                        'student_id' => $student->id,
                        'fee_type' => 2,
                        'amount' => $monthly_rcv_amt,
                        'comments' => 'Pending Amount Received By Admin',
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);
                $monthly_fee_status = 1;
            }
        }

        return redirect()->route('web.fee_receive_receipt',['student_id'=>$student_id]);
        
    }

    public function feeReceiveReceipt($student_id)
    {
        $student = DB::table('students')->where('student_id',$student_id)->first();
        $admsn_fees_pending = 0 ;
        $promsn_fees_pending = 0 ;
        $month_fees_pending = 0 ;
        $receive_fees = 0;
        $balance = 0;
        if ($student) {
            $student = DB::table('students')
                ->select('students.*','class.name as c_name','student_batch.name as b_name','student_details.name as s_name')
                ->leftjoin('class','class.id','=','students.class_id')
                ->leftjoin('student_details','student_details.student_id','=','students.id')
                ->leftjoin('student_batch','student_batch.id','=','students.batch_id')
                ->where('students.id',$student->id)
                ->first();
            $date = Carbon::now()->setTimezone('Asia/Kolkata')->startOfDay();
            // dd($date);
            $admsn_fee = DB::table('student_admsn_fees_details')->where('student_id',$student->id)->whereDate('created_at',$date)->where('fee_type',2)->get();
            if ($admsn_fee) {
                $admsn_fees_pending = DB::table('student_admsn_fees')->where('student_id',$student->id)->sum('pending_amount');
               
                $balance += $admsn_fees_pending;
                foreach ($admsn_fee as $key => $value) {
                    if ($value->fee_type == '2') {
                        $admsn_fees_pending = $admsn_fees_pending+$value->amount;
                        $receive_fees = $receive_fees + $value->amount;
                    }                    
                }
            }

            $promsn_fee = DB::table('student_promotion_fees_details')->where('student_id',$student->id)->whereDate('created_at',$date)->where('fee_type',2)->get();
            if ($promsn_fee) {
                $promsn_fees_pending = DB::table('student_promotion_fees')->where('student_id',$student->id)->sum('pending_amount');
                $balance += $promsn_fees_pending;
                foreach ($promsn_fee as $key => $value) {
                    if ($value->fee_type == '2') {
                        $promsn_fees_pending = $promsn_fees_pending+$value->amount;
                        $receive_fees = $receive_fees + $value->amount;
                    }                    
                }
            }

            $month_fee = DB::table('student_monthly_fee_details')->where('student_id',$student->id)->whereDate('created_at',$date)->where('fee_type',2)->get();
            if ($month_fee) {
                $month_fees_pending = DB::table('student_monthly_fees')->where('student_id',$student->id)->sum('pending_amount');
                $balance += $month_fees_pending;
                foreach ($month_fee as $key => $value) {
                    if ($value->fee_type == '2') {
                        $month_fees_pending = $month_fees_pending+$value->amount;
                        $receive_fees = $receive_fees + $value->amount;
                    }                    
                }
            }

        $total_pending_fees = $admsn_fees_pending+$promsn_fees_pending+$month_fees_pending;
        return view('admin.student.fee_receive_receipt',compact('student','admsn_fees_pending','promsn_fees_pending','month_fees_pending','total_pending_fees','receive_fees','balance'));
        }
    }
}
