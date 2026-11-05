<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Session;
session_start();

class IndexController extends Controller
{
    public function loginPage()
    {
    	return view('admin_login');
    }

    public function indexPage()
    {   
        $cur = Session::get('currency');
        //return $cur;
        //return $cur;
    	$categories = Category::where('status','Active')->latest()->take(10)->get();
    	$getCurrency = Session::get('currency');
    	if($getCurrency == 'usd_rate'){
    		$currency = 'USD';
    	}elseif($getCurrency == 'jpn_rate'){
    		$currency = 'JPY';
    	}elseif($getCurrency == 'ksa_riyal'){
    		$currency = 'SAR';
    	}elseif($getCurrency == 'uae_rate'){
            $currency = 'AED';
        }else{
    		$currency = 'BDT';
    	} 
    	$recentProducts = Product::where('status','Active')->take(12)->latest()->get();
    	//return $recentProducts;
    	$bestSellProducts = Product::where('status','Active')->take(12)->get();
    	$popularProducts = Product::where('status','Active')->orderBy('hit_count','DESC')->get();
    	$verifyProducts = Product::where('status','Active')->where('admin_verify','Yes')->latest()->take(12)->get();
    	$homeCategories = Category::whereHas('products')->with([
				    'products' => function ($query) {
				        $query->where('status', 'Active')
				              ->latest()
				              ->take(12);
				    }
				])
				->where('status', 'Active')
				->latest()
				->take(3)
				->get();

    	return view('layouts.front_app',compact('categories','currency','recentProducts','bestSellProducts','popularProducts','verifyProducts','homeCategories'));
    }

    public function setCurrency($currency)
    {   
        // echo $currency;
        // exit();
    	Session::put('currency',$currency);
    	return redirect('/');
    }

}
