<?php

namespace App\Http\Controllers\Admin\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;

class ClassController extends Controller
{
    public function addClassForm()
    {
        return view('admin.configuration.class.add_class_form');
    }

    public function addClass(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'medium' => 'required',
            'fees' => 'required',
        ]);

        $class = DB::table('class')
            ->insert([
                'name' => $request->input('name'),
                'medium' => $request->input('medium'),
                'monthly_fees' => $request->input('fees'),
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        
        if ($class) {
            return redirect()->back()->with('message','Class Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function classList()
    {
        $class =  DB::table('class')->whereNull('deleted_at')->get();
        return view('admin.configuration.class.class_list',compact('class'));
    }

    public function classEdit($class_id)
    {
        try {
            $class_id = decrypt($class_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $class =  DB::table('class')->where('id',$class_id)->first();
        return view('admin.configuration.class.edit_class',compact('class'));
    }

    public function classUpdate(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required',
            'medium' => 'required',
            'fees' => 'required',
        ]);

        $class = DB::table('class')
            ->where('id',$request->input('class_id'))
            ->update([
                'name' => $request->input('name'),
                'medium' => $request->input('medium'),
                'monthly_fees' => $request->input('fees'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        
        if ($class) {
            return redirect()->back()->with('message','Class Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function classListAjax($medium)
    {
        $class =  DB::table('class')->whereNull('deleted_at')->where('medium',$medium)->get();
        return $class;
    }

    public function addBatchForm()
    {
        return view('admin.configuration.batch.add_batch_form');
    }

    public function batchInsert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $name = $request->input('name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');


        $carb_s_date = Carbon::parse($start_date)->setTimezone('Asia/Kolkata');
        $carb_e_date = Carbon::parse($end_date)->setTimezone('Asia/Kolkata');
        if ($carb_s_date->greaterThanOrEqualTo($carb_e_date)) {
            return redirect()->back()->with('error','Start Date Can Not Be Greater Then End Date');
        }
        
        $std_batch = DB::table('student_batch')->orderBy('id','desc')->limit(1)->first();
        if ($std_batch) {
            $last_date = Carbon::parse($std_batch->end_date)->setTimezone('Asia/Kolkata');
            if ($carb_s_date->greaterThanOrEqualTo($last_date)) {
                $batch = DB::table('student_batch')
                ->insertGetId([
                    'name' => $name,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
                if ($batch) {
                    $month = [
                        '01' => 'JAN',
                        '02' => 'FEB',
                        '03' => 'MAR',
                        '04' => 'APR',
                        '05' => 'MAY',
                        '06' => 'JUN',
                        '07' => 'JULY',
                        '08' => 'AUG',
                        '09' => 'SEP',
                        '10' => 'OCT',
                        '11' => 'NOV',
                        '12' => 'DEC',
                    ];
                    foreach ($month as $key => $value) {
                        DB::table('fees_month')
                            ->insert([
                                'month' => $value,
                                'priority' => $key,
                                'batch_id' => $batch,
                                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            ]);
                    }
                    return redirect()->back()->with('message','Batch Created SuccessFully');
                }else{
                    return redirect()->back()->with('error','Something Went Wrong Please Try Again');
                }
            }else{
                return redirect()->back()->with('error','Please Check Batch Start Date With Previous Batch End Date');
            }
        }else{
            return redirect()->back()->with('error','Previous Batch Not Found');
        }

    }

    public function BatchList()
    {
        $batch = DB::table('student_batch')->orderBy('id','desc')->get();
        return view('admin.configuration.batch.batch_list',compact('batch'));
    }

    public function BatchFeeStatus($batch_id)
    {
        try {
            $batch_id = decrypt($batch_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $month = DB::table('fees_month')
            ->select('fees_month.*','student_batch.name as batch_name')
            ->leftjoin('student_batch','student_batch.id','=','fees_month.batch_id')
            ->where('batch_id',$batch_id)->get();
        return view('admin.configuration.batch.fee_status',compact('month'));
    }
}
