<?php

namespace App\Http\Controllers\Admin\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;

class AdmsnFeesController extends Controller
{
    public function addFeeForm()
    {
        $fee_type = DB::table('admsn_fee_type')->get();
        return view('admin.configuration.admsnFee.add_new_fee_form',compact('fee_type'));
    }

    public function addAdmsnFee(Request $request)
    {
        
        $request->validate([
            'medium' => 'required',
            'class' => 'required',
            'fee_id' => 'required',
            'fee_amount' => 'required',
        ]);
        
        $medium = $request->input('medium');
        $class = $request->input('class');
        $fee_id = $request->input('fee_id');
        $fee_amount = $request->input('fee_amount');
        for ($i=0; $i < count($fee_id) ; $i++) { 
            $check = DB::table('admsn_fee_structure')
                ->where('fee_name_id',$fee_id[$i])
                ->where('medium',$medium)
                ->where('class_id',$class)
                ->where('fee_type',1)
                ->count();
            if ($check < 1 ) {
                $fees = DB::table('admsn_fee_structure')
                ->insert([
                    'fee_name_id' => $fee_id[$i],
                    'medium' => $medium,
                    'class_id' => $class,
                    'fee_type' => 1,
                    'amount' => $fee_amount[$i],
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
            }
        }
        return redirect()->back()->with('message','Fees Added Successfully');
    }

    public function FeesList()
    {
        $class = DB::table('class')->where('status',1)->whereNull('deleted_at')->get();
        
        $fees = [];
        foreach ($class as $key => $value) {
            $amount = DB::table('admsn_fee_structure')
                ->where('class_id',$value->id)
                ->where('medium',$value->medium)
                ->where('fee_type',1)
                ->sum('amount');
            if ($amount > 0) {
                $fees[] = [
                    'class_name' => $value->name,
                    'medium' => $value->medium,
                    'amount' => $amount,
                    'class_id' => $value->id,
                    'medium' => $value->medium,
                ];
            }
        }

        return view('admin.configuration.admsnFee.fee_list',compact('fees'));
    }

    public function searchFees(Request $request)
    {
        $request->validate([
            'medium' => 'required',
            'class' => 'required',
        ]);
        $medium = $request->input('medium');
        $class_name = DB::table('class')->where('id',$request->input('class'))->first();
        $fees_search = DB::table('admsn_fee_structure')
            ->select('admsn_fee_structure.*','admsn_fee_type.name as fee_type_name')
            ->leftjoin('admsn_fee_type','admsn_fee_type.id','=','admsn_fee_structure.fee_name_id')
            ->whereNull('admsn_fee_structure.deleted_at')
            ->where('admsn_fee_structure.fee_type',1)
            ->where('admsn_fee_structure.medium',$request->input('medium'))
            ->where('admsn_fee_structure.class_id',$request->input('class'))
            ->orderBy('admsn_fee_structure.id')
            ->get();
        $fees_total = DB::table('admsn_fee_structure')
            ->whereNull('admsn_fee_structure.deleted_at')
            ->where('admsn_fee_structure.fee_type',1)
            ->where('admsn_fee_structure.status',1)
            ->where('admsn_fee_structure.medium',$request->input('medium'))
            ->where('admsn_fee_structure.class_id',$request->input('class'))
            ->sum('amount');
        return view('admin.configuration.admsnFee.fee_list',compact('fees_search','fees_total','class_name','medium') );
    }

    public function admsnFeeEditForm($class_id,$medium)
    {
        try {
            $class_id = decrypt($class_id);
            $medium = decrypt($medium);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $fees = DB::table('admsn_fee_structure')
            ->select('admsn_fee_type.name as fee_type_name','admsn_fee_structure.*')
            ->leftjoin('admsn_fee_type','admsn_fee_type.id','=','admsn_fee_structure.fee_name_id')
            ->where('class_id',$class_id)
            ->where('medium',$medium)
            ->where('fee_type',1)
            ->get();
        $amount = DB::table('admsn_fee_structure')
            ->where('class_id',$class_id)
            ->where('medium',$medium)
            ->where('fee_type',1)
            ->sum('amount');
        $class_list = DB::table('class')->where('medium',$medium)->get();
        return view('admin.configuration.admsnFee.admsn_fee_edit_form',compact('fees','class_list','medium','class_id','amount'));
    }

    public function admsnFeeUpdate(Request $request)
    {
        $request->validate([
            'fee_id' => 'required',
            'fee_amount' => 'required',
        ]);
        $fee_id = $request->input('fee_id');
        $fee_amount = $request->input('fee_amount');

        for ($i=0; $i < count($fee_id) ; $i++) { 
            $fees = DB::table('admsn_fee_structure')
                ->where('id',$fee_id[$i])
                ->update([
                    'amount' => $fee_amount[$i],
                ]);
        }

        return redirect()->back()->with('message','Fees Updated Successfully');
    }

    public function admsnFeeStatus($id,$status)
    {
        try {
            $id = decrypt($id);
            $status = decrypt($status);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $fees = DB::table('admsn_fee_structure')
            ->where('id',$id)
            ->update([
                'status' => $status,
            ]);
        
        if ($fees) {
            return redirect()->back()->with('message','Status Updated Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }
}
