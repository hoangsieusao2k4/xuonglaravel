<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/insert', function () {
    DB::table('products')->insert([
        ['id' => 1, 'name' => 'Bàn gỗ', 'price' => 2000000, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'name' => 'Ghế xoay', 'price' => 1500000, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'name' => 'Tủ quần áo', 'price' => 5000000, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 4, 'name' => 'Giường ngủ', 'price' => 8000000, 'created_at' => now(), 'updated_at' => now()],
    ]);
    DB::table('sales')->insert([
        ['id' => 1, 'product_id' => 1, 'quantity' => 3, 'price' => 2000000, 'tax' => 600000, 'total' => 6600000, 'sale_date' => '2024-09-15', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'product_id' => 2, 'quantity' => 1, 'price' => 1500000, 'tax' => 330000, 'total' => 1830000, 'sale_date' => '2024-09-16', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'product_id' => 1, 'quantity' => 1, 'price' => 5000000, 'tax' => 500000, 'total' => 5500000, 'sale_date' => '2024-09-18', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 4, 'product_id' => 2, 'quantity' => 2, 'price' => 1600000, 'tax' => 160000, 'total' => 1760000, 'sale_date' => '2024-09-20', 'created_at' => now(), 'updated_at' => now()],
    ]);
    DB::table('expenses')->insert([
        ['id' => 1, 'description' => 'Nhập hàng tháng 9', 'amount' => 500000, 'expense_date' => '2024-09-05', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'description' => 'Chi phí vận chuyển', 'amount' => 800000, 'expense_date' => '2024-09-10', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'description' => 'Bảo hành sản phẩm', 'amount' => 200000, 'expense_date' => '2024-09-12', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 4, 'description' => 'Lương nhân viên tháng 9', 'amount' => 1200000, 'expense_date' => '2024-09-30', 'created_at' => now(), 'updated_at' => now()],
    ]);
    DB::table('financial_reports')->insert([
        ['id' => 1, 'month' => 9, 'year' => 2024, 'total_sales' => 3200000, 'total_expenses' => 1880000, 'profit_before_tax' => 1320000, 'tax_amount' => 320000, 'profit_after_tax' => 1000000, 'created_at' => now(), 'updated_at' => now()],
    ]);
    DB::table('taxes')->insert([
        ['id' => 1, 'tax_name' => 'VAT', 'rate' => 10, 'created_at' => now(), 'updated_at' => now()],
    ]);


});
// doanh thu theo tháng
Route::get('/doanhthu', function () {
    $sales = DB::table('sales')
    ->select(
        DB::raw('SUM(total) as total_sales'),
        DB::raw('EXTRACT(MONTH FROM sale_date) as month'),
        DB::raw('EXTRACT(YEAR FROM sale_date) as year')
    )
    ->groupBy(DB::raw('EXTRACT(MONTH FROM sale_date)'), DB::raw('EXTRACT(YEAR FROM sale_date)'))
    ->get();
    // echo $sales;


        // dd($sales);
});
Route::get('/chiphi', function () {
    $expenses = DB::table('expenses')
        ->select(
            DB::raw('SUM(amount) as total_expenses'),
            DB::raw('EXTRACT(MONTH FROM expense_date) as month'),
            DB::raw('EXTRACT(YEAR FROM expense_date) as year')
        )
        ->groupBy(DB::raw('EXTRACT(MONTH FROM expense_date)'), DB::raw('EXTRACT(YEAR FROM expense_date)'))
        ->get();
        // dd($expenses);
});
Route::get('/baocao', function () {
    $sales = DB::table('sales')
    ->select(
        DB::raw('SUM(total) as total_sales'),
        DB::raw('EXTRACT(MONTH FROM sale_date) as month'),
        DB::raw('EXTRACT(YEAR FROM sale_date) as year')
    )
    ->groupBy(DB::raw('EXTRACT(MONTH FROM sale_date)'), DB::raw('EXTRACT(YEAR FROM sale_date)'))
    ->get();
    $expenses = DB::table('expenses')
    ->select(
        DB::raw('SUM(amount) as total_expenses'),
        DB::raw('EXTRACT(MONTH FROM expense_date) as month'),
        DB::raw('EXTRACT(YEAR FROM expense_date) as year')
    )
    ->groupBy(DB::raw('EXTRACT(MONTH FROM expense_date)'), DB::raw('EXTRACT(YEAR FROM expense_date)'))
    ->get();
    foreach ($sales as $sale) {
        $expense = $expenses->where('month', $sale->month)->where('year', $sale->year)->first();
        $profit_before_tax = $sale->total_sales - ($expense->total_expenses ?? 0);
        $tax_rate = DB::table('taxes')->where('tax_name', 'VAT')->first()->rate;
        $tax_amount = $profit_before_tax * ($tax_rate / 100);
        $profit_after_tax = $profit_before_tax - $tax_amount;

        DB::table('financial_reports')->insert([
            'month' => $sale->month,
            'year' => $sale->year,
            'total_sales' => $sale->total_sales,
            'total_expenses' => $expense->total_expenses ?? 0,
            'profit_before_tax' => $profit_before_tax,
            'tax_amount' => $tax_amount,
            'profit_after_tax' => $profit_after_tax,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
});
