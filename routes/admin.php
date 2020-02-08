<?php

Route::group(['namespace'=>'Admin'],function(){
    Route::get('/admin/login','LoginController@index')->name('admin.login');

    Route::post('/admin/login', 'LoginController@adminLogin');
    Route::post('/admin/logout', 'LoginController@logout')->name('admin.logout');

    Route::get('ajax/class/fees/{class_id}/{medium}','StudentController@classFeesAjax');
    Route::get('ajax/class/promotion/fees/{class_id}/{medium}','StudentController@classPromotionFeesAjax');

    Route::group(['middleware'=>'auth:admin','prefix'=>'admin'],function(){
        Route::get('/deshboard', 'DeshboardController@index')->name('admin.deshboard');

        Route::group(['namespace'=>'Configuration'],function(){
            Route::get('Add/Class/Form', 'ClassController@addClassForm')->name('admin.add_class_form');
            Route::post('Add/Class', 'ClassController@addClass')->name('admin.add_class');
            Route::get('Class/List', 'ClassController@classList')->name('admin.class_list');
            Route::get('Class/Edit/{class_id}', 'ClassController@classEdit')->name('admin.class_edit_form');
            Route::post('Class/Update', 'ClassController@classUpdate')->name('admin.class_update');

            Route::get('Ajax/Class/List/{medium}', 'ClassController@classListAjax')->name('admin.class_list_ajax');

            Route::group(['prefix'=>'Batch'],function(){
                Route::get('Add/New', 'ClassController@addBatchForm')->name('admin.add_new_batch_form');
                Route::post('Insert/New', 'ClassController@batchInsert')->name('admin.insert_new_batch');
                Route::get('/List', 'ClassController@BatchList')->name('admin.Batch_list');
                Route::get('/Fee/Status/{batch_id}', 'ClassController@BatchFeeStatus')->name('admin.Batch_fee_status');
            });
        });

        Route::group(['namespace'=>'Configuration'],function(){
            Route::get('Add/New/Admission/Fee', 'AdmsnFeesController@addFeeForm')->name('admin.add_new_fee_form');
            Route::post('Add/Admission/Fee', 'AdmsnFeesController@addAdmsnFee')->name('admin.add_admsn_fee');
            Route::get('Admsn/Fees/List', 'AdmsnFeesController@FeesList')->name('admin.admsn_fees_list');
            Route::post('Admsn/Search/Fees', 'AdmsnFeesController@searchFees')->name('admin.search_admsn_fees');
            Route::get('Admsn/Fees/Edit/Form/{class_id}/{medium}', 'AdmsnFeesController@admsnFeeEditForm')->name('admin.admsn_fee_edit_form');
            Route::post('Admsn/Fee/Update', 'AdmsnFeesController@admsnFeeUpdate')->name('admin.admsn_fee_update');
            Route::get('Admsn/Fee/Status/{id}/{status}', 'AdmsnFeesController@admsnFeeStatus')->name('admin.admsn_fee_status');

            Route::group(['prefix'=>'Promotion'],function(){
                Route::get('Add/New/Fee', 'PromotionFeeController@addFeeForm')->name('admin.add_new_promotion_fee_form');
                Route::post('Add/Fee', 'PromotionFeeController@addFee')->name('admin.add_promotion_fee');
                Route::get('Fees/List', 'PromotionFeeController@FeesList')->name('admin.promotion_fees_list');
                Route::post('Search/Fees', 'PromotionFeeController@searchFees')->name('admin.search_promotion_fees');
                Route::get('Fees/Edit/Form/{class_id}/{medium}', 'PromotionFeeController@FeeEditForm')->name('admin.promotion_fee_edit_form');
                Route::post('Fee/Update', 'PromotionFeeController@FeeUpdate')->name('admin.promotion_fee_update');
                Route::get('Fee/Status/{id}/{status}', 'PromotionFeeController@FeeStatus')->name('admin.promotion_fee_status');
            });
        });

        Route::group(['prefix'=>'Employee'],function(){
            Route::get('Add/New/', 'EmployeeController@addEmployeeForm')->name('admin.add_employee_form');
            Route::post('Add/Emp', 'EmployeeController@addEmployee')->name('admin.add_employee');
            Route::get('List/', 'EmployeeController@employeeList')->name('admin.employee_list');
            Route::get('Edit/Employee/{emp_id}', 'EmployeeController@editEmployee')->name('admin.edit_employee');
            Route::post('update/Emp', 'EmployeeController@updateEmployee')->name('admin.update_employee');
            Route::get('Status/Update/{emp_id}/{status}', 'EmployeeController@statusEmployee')->name('admin.status_employee');
        });

        Route::group(['prefix'=>'Cloth'],function(){
            Route::get('Add/Size/Form', 'StockController@addClothSizeForm')->name('admin.add_cloth_size_form');
            Route::post('Add/Size', 'StockController@addClothSize')->name('admin.add_cloth_size');
            Route::get('Size/List/', 'StockController@ClothSizList')->name('admin.cloth_size_list');
            Route::get('Edit/Cloth/Size/{size_id}', 'StockController@editClothSize')->name('admin.edit_cloth_size');
            Route::post('update/Cloth/Size', 'StockController@updateClothSize')->name('admin.update_cloth_size');
            Route::get('Status/Update/Cloth/Size/{size_id}/{status}', 'StockController@statusClothSize')->name('admin.status_cloth_size');
            Route::get('size/ajax/{type}','StockController@ajaxClothSize')->name('admin.ajax_cloth_size');
            Route::get('stock/fetch/ajax/{type}/{cloth_size}','StockController@ajaxClothStockFetch')->name('admin.ajax_cloth_stock_fetch');

            Route::get('Add/Form', 'StockController@addClothForm')->name('admin.add_cloth_form');
            Route::post('Add/Stock', 'StockController@addClothStock')->name('admin.add_Stock');
            Route::get('Stock/List', 'StockController@ClothStockList')->name('admin.cloth_stock_list');
            Route::get('Stock/Details/List', 'StockController@ClothStockDetailsList')->name('admin.cloth_stock_details_list');
            Route::get('Stock/Details/List/Ajax', 'StockController@ClothStockDetailsListAjax')->name('admin.cloth_stock_details_list_ajax');

        });

        Route::group(['prefix'=>'Book'],function(){
            Route::get('Add/Book/Form', 'StockController@addBookForm')->name('admin.add_book_form');
            Route::post('Add/New', 'StockController@addBook')->name('admin.add_book');
            Route::get('Stock/List/', 'StockController@bookStockList')->name('admin.book_stock_list');
            Route::get('Stock/List/Ajax', 'StockController@bookStockListAjax')->name('admin.book_stock_list_ajax');
            Route::get('List/Ajax/{class_id}', 'StockController@bookListAjax')->name('admin.book_list_ajax');

            Route::get('Add/Stock/Form', 'StockController@addBookStockForm')->name('admin.add_book_stock_form');
            Route::post('Add/Stock', 'StockController@addBookStock')->name('admin.add_book_Stock');

            Route::get('Stock/History/', 'StockController@bookStockHistory')->name('admin.book_stock_history');
            Route::get('Stock/History/Ajax', 'StockController@bookStockHistoryAjax')->name('admin.book_stock_history_ajax');
        });

        Route::group(['prefix'=>'Other'],function(){
            Route::get('Stock/Update', 'StockController@otherStockUpdateForm')->name('admin.update_other_stock_form');
            Route::post('stock/update', 'StockController@otherStockUpdate')->name('admin.otherStockUpdate');

            Route::get('Stock/History/', 'StockController@otherStockHistory')->name('admin.other_stock_history');
            Route::get('Stock/History/Ajax', 'StockController@otherStockHistoryAjax')->name('admin.other_stock_history_ajax');
        });

        Route::group(['prefix'=>'Student'],function(){
            Route::get('Add/New', 'StudentController@addStudentForm')->name('admin.add_student_form');
            Route::post('add/New/st', 'StudentController@addNewStudent')->name('admin.add_new_student');

            Route::get('List/', 'StudentController@studentList')->name('admin.student_list');
            Route::get('List/Ajax/{medium?}/{batch?}/{class?}', 'StudentController@studentListAjax')->name('admin.student_list_ajax');
            Route::get('details/{student_id}', 'StudentController@studentDetails')->name('admin.student_details');
            Route::get('Edit/{student_id}', 'StudentController@studentEdit')->name('admin.student_edit');
            Route::post('update/data', 'StudentController@studentUpdate')->name('admin.update_student');

            Route::get('Promote/', 'StudentController@studentPromote')->name('admin.student_promote');
            Route::post('Promote/Search', 'StudentController@studentPromoteSearch')->name('admin.student_promote_search');
            Route::get('Promote/Form/{student_id}', 'StudentController@studentPromoteForm')->name('admin.student_promote_form');
            Route::post('Promote/Student/Insert', 'StudentController@studentPromoteInsert')->name('admin.student_promote_insert');

            Route::get('Add/Prev', 'StudentController@addPrevStudentForm')->name('admin.add_prev_student_form');
            Route::post('add/Prev/st', 'StudentController@addPrevStudent')->name('admin.add_prev_student');


            Route::get('Generate/Fee', 'StudentController@GenerateMonthlyFee')->name('admin.student_generate_monthly_fee_form');
            Route::post('Generate/Monthly/Fee', 'StudentController@GenerateMonthlyFeeInsert')->name('admin.student_generate_monthly_fee_insert');

            Route::get('Receive/Fee/Form', 'StudentController@feeReceiveStudentForm')->name('admin.student_fee_receive_form');
            Route::get('/Fee/search/{std_id}', 'StudentController@studentFeeSearch')->name('admin.student_fee_search');
            Route::post('Receive/Fee/', 'StudentController@feeReceiveStudent')->name('admin.student_fee_receive');

            Route::get('fee/receive/receipt/{student_id}','StudentController@feeReceiveReceipt')->name('web.fee_receive_receipt');
        });


        
        Route::group(['prefix'=>'Report'],function(){
            Route::get('admission/fees', 'ReportController@admissionFee')->name('admin.admsn_fee_report');
            Route::get('admission/fees/ajax/{batch?}/{medium?}/{class?}', 'ReportController@admissionFeeAjax')->name('admin.admsn_fee_report_ajax');
            Route::post('admission/fees/report/search', 'ReportController@admissionFeeReportSearch')->name('admin.admsn_fee_report_search');

            Route::get('promotion/fees', 'ReportController@promotionFee')->name('admin.promotion_fee_report');
            Route::get('promotion/fees/ajax/{batch?}/{medium?}/{class?}', 'ReportController@promotionFeeAjax')->name('admin.promotion_fee_report_ajax');
            Route::post('promotion/fees/report/search', 'ReportController@promotionFeeReportSearch')->name('admin.prmsn_fee_report_search');

            Route::get('monthly/fees', 'ReportController@monthlyFee')->name('admin.monthly_fee_report');
            Route::get('monthly/fees/ajax/', 'ReportController@monthlyFeeAjax')->name('admin.monthly_fee_report_ajax');
            Route::post('monthly/fees/search', 'ReportController@monthlyFeeSearch')->name('admin.monthly_fee_search');
            Route::get('month/fetch/ajax/{batch_id}', 'ReportController@MonthFetchAjax')->name('admin.month_fetch_ajax');

            Route::get('Student/thankyou/{student_id}/{batch_id}', 'ReportController@thankYou')->name('admin.student_thank_you');
            Route::get('Student/promotion/thankyou/{student_id}/{batch_id}', 'ReportController@promotionThankYou')->name('admin.student_promotion_thank_you');
        });
    });
});