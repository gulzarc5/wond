<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;

class StockController extends Controller
{
    public function addClothSizeForm(Request $request)
    {
        return view('admin.stock.cloth.add_cloth_size');
    }

    public function addClothSize(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);
        
        $check_cloth_size = DB::table('cloth_size')
            ->where('cloth_type',$request->input('type'))
            ->where('name',$request->input('name'))
            ->count();
        if ($check_cloth_size > 0) {
            return redirect()->back()->with('error','Cloth Size Already Exist');
        }
        $cloth_size = DB::table('cloth_size')
            ->insertGetId([
                'cloth_type' => $request->input('type'),
                'name' => strtoupper($request->input('name')),
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);        
        if ($cloth_size) {
            DB::table('product_cloths')
            ->insert([
                'cloth_type' => $request->input('type'),
                'size_id' => $cloth_size,
                'stock' => 0,
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);      
            return redirect()->back()->with('message','Cloth Size Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function ClothSizList()
    {
        $cloth_size = DB::table('cloth_size')->whereNull('deleted_at')->get();
        return view('admin.stock.cloth.cloth_size_list',compact('cloth_size'));
    }

    public function editClothSize($size_id)
    {
        try {
            $size_id = decrypt($size_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $cloth_size = DB::table('cloth_size')->where('id',$size_id)->first();
        return view('admin.stock.cloth.edit_cloth_size',compact('cloth_size'));
    }

    public function updateClothSize(Request $request)
    {
        $request->validate([
            'size_id' => 'required',
            'type' => 'required',
            'name' => 'required',
        ]);

        $cloth_size = DB::table('cloth_size')
            ->where('id',$request->input('size_id'))
            ->update([
                'cloth_type' => $request->input('type'),
                'name' => $request->input('name'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);        
        if ($cloth_size) {
            return redirect()->back()->with('message','Cloth Size Updated Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function statusClothSize($size_id,$status)
    {
        $cloth_size = DB::table('cloth_size')
            ->where('id',$size_id)
            ->update([
                'status' => $status,
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);        
        if ($cloth_size) {
            return redirect()->back()->with('message','Size Status Updated Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function addClothForm()
    {
        return view('admin.stock.cloth.add_cloth_stock');
    }

    public function ajaxClothSize($type)
    {
        $cloth_size = DB::table('cloth_size')->where('cloth_type',$type)->whereNull('deleted_at')->orderBy('name','asc')->get();
        return $cloth_size;
    }

    public function ajaxClothStockFetch($type,$cloth_size)
    {
        $cloth_stock = DB::table('product_cloths')->select('stock')->where('cloth_type',$type)->where('size_id',$cloth_size)->whereNull('deleted_at')->first();
        return $cloth_stock->stock;
    }

    public function addClothStock(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'cloth_size' => 'required',
            'quantity' => 'required',
        ]);
        $clothStock = DB::table('product_cloths')
            ->where('cloth_type',$request->input('type'))
            ->where('size_id',$request->input('cloth_size'))
            ->update([
                'stock' => DB::raw("`stock`+".($request->input('quantity'))),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);
        if ($clothStock) {
            $stock_id =  DB::table('product_cloths')
            ->where('cloth_type',$request->input('type'))
            ->where('size_id',$request->input('cloth_size'))
            ->first();
            $clothStock_details = DB::table('cloth_stock_details')
                ->insert([  
                    'product_cloth_id' => $stock_id->id,
                    'stock' => $request->input('quantity'),
                    'stock_type' => 2,
                    'comments' => 'stock Added By Admin',
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
            return redirect()->route('admin.add_cloth_form')->with('message','Stock Added Successfully');
        } else {
            return redirect()->back()->with('error','Something Went Wrong Please try Again');
        }
        
        
    }

    public function ClothStockList()
    {
        $cloth_stock_list = DB::table('product_cloths')
            ->select('product_cloths.*','cloth_size.name as size_name')
            ->leftjoin('cloth_size','cloth_size.id','=','product_cloths.size_id')
            ->whereNull('product_cloths.deleted_at')
            ->get();
        return view('admin.stock.cloth.cloth_stock_list',compact('cloth_stock_list'));
    }

    public function ClothStockDetailsList()
    {
        return view('admin.stock.cloth.cloth_stock_details');
    }

    public function ClothStockDetailsListAjax()
    {
        $query = DB::table('cloth_stock_details')
            ->select('cloth_stock_details.*','product_cloths.cloth_type as cloth_type','cloth_size.name as size_name')
            ->leftjoin('product_cloths','product_cloths.id','=','cloth_stock_details.product_cloth_id')
            ->leftjoin('cloth_size','cloth_size.id','=','product_cloths.size_id')
            ->orderBy('cloth_stock_details.id','desc');
            return datatables()->of($query->get())
            ->addIndexColumn()
            ->toJson();
    }

    public function addBookForm()
    {
        return view('admin.stock.books.add_new_book');
    }

    public function addBook(Request $request)
    {
        $request->validate([
            'medium' => 'required',
            'class' => 'required',
            'book_name.*' => 'required',
        ]);

        $book_name = $request->input('book_name'); //Array Of Books

        foreach ($book_name as $key => $value) {
            $check_book =  DB::table('product_books')->where('class_id',$request->input('class'))->where('name',$value)->whereNull('deleted_at')->count();

            if ($check_book < 1) {
                DB::table('product_books')
                ->insert([
                    'name' => $value,
                    'class_id' => $request->input('class'),
                    'stock' => 0,
                    'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);
            }            
        }

        return redirect()->back()->with('message','Book Added Successfully');
    }

    public function bookStockList()
    {
        return view('admin.stock.books.book_list');
    }

    public function bookStockListAjax(Request $request)
    {
        $query = DB::table('product_books')
            ->select('product_books.*','class.name as class_name')
            ->leftjoin('class','class.id','=','product_books.class_id')
            ->orderBy('product_books.id','desc');
        return datatables()->of($query->get())
            ->addIndexColumn()
            ->toJson();
    }

    public function addBookStockForm()
    {
        return view('admin.stock.books.add_book_stock');
    }

    public function bookListAjax($class_id)
    {
        $query = DB::table('product_books')
            ->where('class_id',$class_id)
            ->orderBy('name','asc')
            ->get();
        return $query;
    }

    public function addBookStock(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'book' => 'required',
            'stock' => 'required',
        ]);

        $book = $request->input('book'); //an array of book id
        $stock = $request->input('stock'); //an array of stock

        // $job_type = array_unique($request->input('job_type'));
        for ($i=0; $i < count($book); $i++) { 
            if (!empty($book[$i]) && !empty($stock[$i])) {
                $bookStock = DB::table('product_books')
                ->where('id',$book[$i])
                ->update([
                    'stock' => DB::raw("`stock`+".$stock[$i]),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

                if ($bookStock) {
                    DB::table('books_stock_details')
                        ->insert([
                            'product_book_id' => $book[$i],
                            'stock' => $stock[$i],
                            'stock_tupe' => 1,
                            'comments' => 'Stock Added By Admin',
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                }
            }
        }

        return redirect()->back()->with('message','Book Stock Added Successfully');
    }

    public function bookStockHistory()
    {
        return view('admin.stock.books.book_stock_history');
    }

    public function bookStockHistoryAjax(Request $request)
    {
        $query = DB::table('books_stock_details')
            ->select('books_stock_details.*','class.name as class_name','product_books.name as book_name')
            ->leftjoin('product_books','product_books.id','=','books_stock_details.product_book_id')
            ->leftjoin('class','class.id','=','product_books.class_id')
            ->orderBy('books_stock_details.id','desc');
        return datatables()->of($query->get())
            ->addIndexColumn()
            ->toJson();
    }

    public function otherStockUpdateForm()
    {
        $stock = DB::table('other_product')->whereNull('deleted_at')->get();
        return view('admin.stock.other.update_stock',compact('stock'));
    }

    public function otherStockUpdate(Request $request)
    {
        $stock_id = $request->input('id');
        $stock = $request->input('stock');
        for ($i=0; $i < count($stock_id) ; $i++) { 
            if (!empty($stock_id[$i]) && $stock[$i] > 0) {
                $stock_update = DB::table('other_product')
                ->where('id',$stock_id[$i])
                ->update([
                    'stock' => DB::raw("`stock`+".$stock[$i]),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]);

                if ($stock_update) {
                    DB::table('other_stock_details')
                        ->insert([
                            'other_product_id' => $stock_id[$i],
                            'stock' => $stock[$i],
                            'stock_type' => 2,
                            'comments' => 'Stock Added By Admin',
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                }
            }
        }
        return redirect()->back()->with('message','Stock Updated Successfully');
    }

    public function otherStockHistory()
    {
        return view('admin.stock.other.stock_history');
    }

    public function otherStockHistoryAjax()
    {
        $query = DB::table('other_stock_details')
            ->select('other_stock_details.*','other_product.name as name')
            ->leftjoin('other_product','other_product.id','=','other_stock_details.other_product_id')
            ->orderBy('other_stock_details.id','desc');
        return datatables()->of($query->get())
            ->addIndexColumn()
            ->toJson();
    }
}
