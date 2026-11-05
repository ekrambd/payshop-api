<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Whishlist;

class WishlistController extends Controller
{
    public function myWishlists()
    {   
    	$data = Whishlist::with('product')->where('user_id',user()->id)->latest()->get();
    	return view('wishlist',compact('data')); 
    }
}
