<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;

class EmployeeController extends Controller
{
    public function addEmployeeForm()
    {
        return view('admin.employee.add_new_employee');
    }

    public function addEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'salary' => 'required',
            'qualification' => 'required',
        ]);

        $employee = DB::table('employee')
            ->insert([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'designation' => $request->input('designation'),
                'salary' => $request->input('salary'),
                'qualification' => $request->input('qualification'),
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        
        if ($employee) {
            return redirect()->back()->with('message','Employee Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function employeeList()
    {
        $employee = DB::table('employee')->whereNull('deleted_at')->orderBy('id','desc')->get();
        return view('admin.employee.employee_list',compact('employee'));
    }

    public function editEmployee($emp_id)
    {
        try {
            $emp_id = decrypt($emp_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $employee = DB::table('employee')->where('id',$emp_id)->orderBy('id','desc')->first();
        return view('admin.employee.edit_new_employee',compact('employee'));
    }

    public function updateEmployee(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'salary' => 'required',
            'qualification' => 'required',
        ]);

        $employee = DB::table('employee')
            ->where('id',$request->input('id'))
            ->update([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'designation' => $request->input('designation'),
                'salary' => $request->input('salary'),
                'qualification' => $request->input('qualification'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        
        if ($employee) {
            return redirect()->back()->with('message','Employee Updated Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function statusEmployee($emp_id,$status)
    {
        try {
            $emp_id = decrypt($emp_id);
            $status = decrypt($status);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $employee = DB::table('employee')
            ->where('id',$emp_id)->update(['status'=>$status]);
        return redirect()->back()->with('message','Status Updated Successfully');
    }
}
