<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;

/**
 * Department wise report
 */
Route::get('/department_wise_report', [
    ReportController::class, 'department_wise_report'
])
->name('department_wise_report')
->middleware('auth');