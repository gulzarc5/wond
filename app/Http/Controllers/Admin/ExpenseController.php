<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;

class ExpenseController extends Controller
{
    public function expenseList()
    {
        $expense = DB::table('expense_items')->get();
        return view('admin.configuration.expense.expense',compact('expense'));
    }

    public function expenseItemAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        DB::table('expense_items')
            ->insert([
                'name' => $request->input('name'),
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        return redirect()->back()->with('message','Expense Item Added Successfully');
    }

    public function expenseAddForm()
    {
        $expense = DB::table('expense_items')->get();
        return view('admin.expense.add_expense',compact('expense'));
    }

    public function expenseAdd(Request $request)
    {
        $request->validate([
            'expense_id' => 'required',
            'amount' => 'required',
        ]);

        $expense = DB::table('expense_details')
            ->insert([
                'expense_item_id' => $request->input('expense_id'),
                'amount' => $request->input('amount'),
                'comment' => $request->input('comment'),
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        if ($expense) {
            return redirect()->back()->with('message','Expense Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function expenseDetailList()
    {
        $expense = DB::table('expense_items')->get();
        return view('admin.expense.expense_report',compact('expense'));
    }

    public function expenseDetailListAjax()
    {
        $query = DB::table('expense_details')
            ->select('expense_details.*','expense_items.name as expense_name')
            ->leftjoin('expense_items','expense_items.id','=','expense_details.expense_item_id')
            ->orderBy('expense_details.id','desc');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->make(true);
    }

    public function expenseSearch(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $s_date = $request->input('from_date');
        $e_date = $request->input('to_date');
        $expense_id = $request->input('expense_id');
        $start = Carbon::parse($s_date)->startOfDay();
        $end = Carbon::parse($e_date)->endOfDay();

        $expense_report = DB::table('expense_details')
            ->select('expense_details.*','expense_items.name as expense_name')
            ->leftjoin('expense_items','expense_items.id','=','expense_details.expense_item_id')            
            ->whereBetween('expense_details.created_at',[$start, $end]);
        if (isset($expense_id) && !empty($expense_id)) {
            $expense_report =  $expense_report->where('expense_item_id',$expense_id);
        }
        $expense_report =  $expense_report->orderBy('expense_details.id','desc')->get();
    
        $expense = DB::table('expense_items')->get();
        return view('admin.expense.expense_report',compact('expense','expense_report'));
    }
}
