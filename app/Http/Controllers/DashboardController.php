<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function adminDashboard()
    {
    	try
    	{   
            if(user()->role_id == 1)
            {   
                // $totalVendors = User::where('role_id',2)->count();
                // $totalUsers = User::where('role_id',3)->count();
                // $totalProducts = Product::count();
                // $totalActiveProducts = Product::where('status','Active')->count();

                $stats = DB::selectOne("
                        SELECT
                            (SELECT COUNT(*) FROM users WHERE role_id = 2) AS total_vendors,
                            (SELECT COUNT(*) FROM users WHERE role_id = 3) AS total_users,
                            (SELECT COUNT(*) FROM products) AS total_products,
                            (SELECT COUNT(*) FROM products WHERE status = 'Active') AS total_active_products
                    ");

                return view('layouts.app', compact('stats'));
            }else{

                // $todayOrder = OrderDetail::whereDate('created_at',date('Y-m-d'))->where('user_id',user()->id)->count();
                // $todaycompletedOrder = OrderDetail::whereDate('created_at',date('Y-m-d'))->where('user_id',user()->id)->count();
                // $totalProducts = Product::where('user_id',user()->id)->count();
                // $totalVerifiedProduct = Product::where('user_id',user()->id)->where('admin_verify','Yes')->count();
                // $totalPendingProducts = Product::where('user_id',user()->id)->where('status','Inactive')->count();
                // $totalActiveProducts = Product::where('user_id',user()->id)->where('status','Active')->count();
                // $thisMonthOrders = OrderDetail::whereMonth('created_at',date('m'))->where('user_id',user()->id)->count();
                // $thisYearOrders = OrderDetail::whereMonth('created_at',date('Y'))->where('user_id',user()->id)->count();

                $stats = OrderDetail::selectRaw("
                        COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as today_orders,

                        COUNT(CASE WHEN DATE(created_at) = CURDATE() AND status = 'Completed' THEN 1 END) as today_completed_orders,

                        COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE())
                            AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 END) as this_month_orders,

                        COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN 1 END) as this_year_orders
                    ")
                    ->where('user_id', user()->id)
                    ->first();

                $productStats = Product::selectRaw("
                        COUNT(*) as total_products,

                        COUNT(CASE WHEN admin_verify = 'Yes' THEN 1 END) as verified_products,

                        COUNT(CASE WHEN status = 'Active' THEN 1 END) as active_products,

                        COUNT(CASE WHEN status = 'Inactive' THEN 1 END) as pending_products
                    ")
                    ->where('user_id', user()->id)
                    ->first();
                return view('layouts.vendor_app',compact('stats','productStats')); 
            }    
    		
    	}catch(Exception $e){
                  
                $message = $e->getMessage();
      
                $code = $e->getCode();       
      
                $string = $e->__toString();       
                return response()->json(['message'=>$message, 'execption_code'=>$code, 'execption_string'=>$string]);
                exit;
        }
    }


    
}
