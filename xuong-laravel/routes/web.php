<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\select;

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



    $query1 = DB::table('users', 'u');

    $user1 = $query1->select(DB::raw('sum(o.amount) as total_spent, u.name'))
        ->join('orders as o', 'u.id', '=', 'o.user_id')
        ->groupBy('u.name')
        ->havingRaw('total_spent > ?', [1000])
        ->toRawSql();
    //  dd($user1);
    $query2 = DB::table('orders');
    $user2 = $query2->select(DB::raw('DATE(order_date) as date,COUNT(*) as orders_count,SUM(total_amount as total_sales)'))
        ->whereBetween('order_date', ['2024-01-01', '2024-09-30'])
        ->groupByRaw('order_date')
        ->toRawSql();
    // dd($user2);
    $orders3 = DB::table('orders', '0')
        ->select(DB::raw(1))
        ->where('o.product_id', '=', 'p.id');


    $product3 = DB::table('products', 'p')
        ->select('product_name')
        ->whereNotExists($orders3)
        ->toRawSql();
    // dd($product3);
    $salesSubquery = DB::table('sales')
        ->select('product_id', DB::raw('SUM(quantity) AS total_sold'))
        ->groupBy('product_id');

    $products4 = DB::table('products AS p')
        ->joinSub($salesSubquery, 's', function ($join) {
            $join->on('p.id', '=', 's.product_id');
        })
        ->select('p.product_name', 's.total_sold')
        ->where('s.total_sold', '>', 100)
        ->toSql();

    // dd($products4);


    // dd($products4);

    // dd($product3);
    $user5 = DB::table('users')
        ->select('users.name,products.product_name,orders.order_date')
        ->join('orders', 'users.id', '=', 'order.user_id')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('products', 'orders_items.product_id', '=', 'product_id')
        ->where('orders.oder_date', '>=', DB::raw('NOW()-INTERVAL 30 DAY'))
        ->toRawSql();
    // dd($user5);
    $order6 = DB::table('orders')
        ->select(DB::raw('DATE_FORMAT(orders.order_date,"%Y-%m") as order_month,SUM(order_item.quantity*order_items.price) as total_revenue '))
        ->join('orders_items', 'orders.id', '=', 'order_items.order_id')
        ->where('order.status', '=', 'completed')
        ->groupBy('order_month')
        ->orderByDesc('order_month')
        ->toRawSql();
    // dd($order6);
    $products7 = DB::table('products')
        ->select('products.product_name')
        ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        ->where('order_items.product_id', null)
        ->toRawSql();
    // dd($products7);
    $subQuery = DB::table('order_items')
        ->select('product_id', DB::raw('SUM(quantity * price) as total'))
        ->groupBy('product_id');
    $products8 = DB::table('products as p')
        ->joinSub($subQuery, 'oi', function ($join) {
            $join->on('p.id', '=', 'oi.product_id');
        })
        ->select('p.category_id', 'p.product_name', DB::raw('MAX(order_items.total) as max_revenue'))
        ->groupBy('p.category_id', 'p.product_name')
        ->orderByDesc('max_revenue')
        ->toRawSql();
    // dd($products8);
    $total9 = DB::table('order_items')
        ->select(DB::raw('SUM(quantity*price) as total'))
        ->groupBy('order_id')
        ->toRawSql();

    $avg9 = DB::table("($total9) as avg_order_value")
        ->selectRaw('AVG(total)')
        ->toRawSql();
    $orders9 = DB::table('orders')
        ->select('orders.id', 'users.name', 'orders.order_date', DB::raw('SUM(order_items.quantity * order_items.price) as total_value'))
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->groupBy('orders.id', 'users.name', 'orders.order_date')
        ->havingRaw(
            "total_value >($avg9)"


        )
        ->toRawSql();
    // dd($orders9);
    $total10 = DB::table('order_items')
        ->select('product_name', DB::raw('SUM(order_items.quantity) as total_sold'))
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->groupBy('products.product_name')
        ->toRawSql();

    $avg10 = DB::table(DB::raw("($total10) as sub"))
        ->selectRaw("MAX(sub.total_sold) as max_sold")
        ->toRawSql();

    $products10 = DB::table('products as p')
        ->select('p.category_id', 'p.product_name', DB::raw('SUM(oi.quantity) as total_sold'))
        ->join('order_items as oi', 'p.id', '=', 'oi.product_id')
        ->groupBy('p.category_id', 'p.product_name')
        ->havingRaw("total_sold = ($avg10)")
        ->toRawSql();

    // dd($products10);







    // ->toRawSql(); // Thay toRawSql() bằng toSql()

    // dd($products8);
    // return view('welcome');
});
