<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/get-antrian/{group}/{queue}', function ($group,$queue) {
    $antiran = DB::table('daily_transaction')->where('id_group_print',$group)->where('queue_number',$queue)->whereDate('print_time',date('Y-m-d',strtotime('+7 hour')))->first();
    if($antiran){
        if($antiran->paging_time == "0000-00-00 00:00:00"){
            return response()->json(['status'=> 'failed','message'=> 'antiran belum di panggil']); 
        }
        return response()->json(['status'=> 'success','message'=> 'antrian ditemukan','print_time'=> $antiran->print_time,'paging_time'=> $antiran->paging_time,]);
    }else{
        return response()->json(['status'=> 'failed','message'=> 'antiran tidak ada']);
    }
});