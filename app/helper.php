<?php
 use App\Models\Category;
 use App\Models\Unit;
 use App\Models\CurrencySetting;
 use App\Models\Role;
 use App\Models\CommissionSetting;
 use App\Models\Subcategory;
 use App\Models\User;

 function user()
 {
 	$user = auth()->user();
 	return $user;
 }

 function categories()
 {
 	$categories = Category::where('status','Active')->latest()->get();
 	return $categories;
 }

 function units()
 {
 	$units = Unit::latest()->get();
 	return $units;
 }

 function successMessage($section,$action)
 {  
 	$article = "the";
 	if($action == "add")
 	{
 		$action="added";
 		$article = "a";
 	}else if($action == "update"){
 		$action="updated";
 	}else{
 	    $action = "deleted";
 	}	
 	
 	$message = "Successfully {$article} {$section} has been {$action}";
 	return $message;
 }

 function errorMessage($section,$action)
 {   
 	//$action.="ed";
 	$message = "Failed to {$action}";
 	return $message;
 }

function categorySlug($category_name)
{
    $slug = \Str::slug($category_name);

    $count = \App\Models\Category::where('slug', 'LIKE', $slug . '%')->count();

    return $count ? $slug . '-' . ($count + 1) : $slug;
}

function currency(){
	$data = CurrencySetting::find(1);
	return $data;
}

function roles()
{   
	$ids = [1,2,3];
	$roles = Role::whereNotIn('id',$ids)->latest()->get();
	return $roles;
	
}

function fee()
{
	$data = CommissionSetting::find(1);
	return $data;
}

function subcategories()
{
	$subcategories = Subcategory::where('status','Active')->latest()->get();
	return $subcategories;
}

function vendors()
{
	$vendors = User::where('role_id',2)->latest()->get();
	return $vendors;
}

function getUserCurrencyKey()
{
    $cur = null;
    if (function_exists('request') && request()) {
        $cur = request()->input('currency') 
            ?? request()->query('currency') 
            ?? request()->header('X-Currency') 
            ?? request()->header('currency');
    }

    if (!$cur && class_exists(\Illuminate\Support\Facades\Session::class)) {
        $cur = \Illuminate\Support\Facades\Session::get('currency');
    }

    if ($cur) {
        $normalized = strtolower(trim((string)$cur));
        if (in_array($normalized, ['bdt', 'bdt_rate', 'taka', '৳'])) $key = 'bdt_rate';
        elseif (in_array($normalized, ['usd', 'usd_rate', '$', 'dollar'])) $key = 'usd_rate';
        elseif (in_array($normalized, ['sar', 'ksa_riyal', 'riyal'])) $key = 'ksa_riyal';
        elseif (in_array($normalized, ['aed', 'uae_rate', 'dirham'])) $key = 'uae_rate';
        elseif (in_array($normalized, ['jpy', 'jpn_rate', 'yen', '¥'])) $key = 'jpn_rate';
        elseif (in_array($normalized, ['usd_rate', 'jpn_rate', 'ksa_riyal', 'bdt_rate', 'uae_rate'])) $key = $normalized;
        else $key = 'usd_rate';

        if (class_exists(\Illuminate\Support\Facades\Session::class) && \Illuminate\Support\Facades\Session::isStarted()) {
            \Illuminate\Support\Facades\Session::put('currency', $key);
        }
        return $key;
    }

    return 'usd_rate';
}

function getUserCurrencyRate()
{
    $key = getUserCurrencyKey();
    $currency = currency();
    if (!$currency || !isset($currency->$key)) {
        return 1.0;
    }
    return (float) $currency->$key;
}

function getUserCurrencySymbol()
{
    $key = getUserCurrencyKey();
    $currency = currency();
    if ($key == 'usd_rate') return $currency->usd_symbol ?? '$';
    if ($key == 'jpn_rate') return $currency->jpn_symbol ?? '¥';
    if ($key == 'ksa_riyal') return $currency->riyal_symbol ?? 'SAR';
    if ($key == 'bdt_rate') return $currency->bdt_symbol ?? '৳';
    if ($key == 'uae_rate') return $currency->uae_symbol ?? 'AED';
    return '$';
}

function getVendorCurrencySymbol($vendor_id)
{
    if (!$vendor_id) return '$';
    $data = \Illuminate\Support\Facades\DB::table('vendor_currency_settings')->where('vendor_id', $vendor_id)->first();
    if ($data && !empty($data->currency)) {
        if ($data->currency == 'BDT' || $data->currency == '৳') return '৳';
        if ($data->currency == 'USD' || $data->currency == '$') return '$';
        if ($data->currency == 'JPY' || $data->currency == '¥') return '¥';
        return $data->currency;
    }
    return '$';
}

function getVendorCurrencyRate($vendor_id)
{
    if (!$vendor_id) return 1.0;
    $data = \Illuminate\Support\Facades\DB::table('vendor_currency_settings')->where('vendor_id', $vendor_id)->first();
    $currency = currency();
    if (!$currency) return 1.0;
    if ($data && !empty($data->currency)) {
        if ($data->currency == '$' || $data->currency == 'USD') {
            return (float) ($currency->usd_rate ?? 1.0);
        } elseif ($data->currency == '¥' || $data->currency == 'JPY') {
            return (float) ($currency->jpn_rate ?? 1.0);
        } elseif ($data->currency == 'SAR') {
            return (float) ($currency->ksa_riyal ?? 1.0);
        } elseif ($data->currency == 'AED') {
            return (float) ($currency->uae_rate ?? 1.0);
        } elseif ($data->currency == '৳' || $data->currency == 'BDT') {
            return (float) ($currency->bdt_rate ?? 1.0);
        }
    }
    return 1.0;
}

function vendorCurrency()
{
    if (!auth()->check() || !user() || !user()->vendor) {
        return null;
    }
    return getVendorCurrencySymbol(user()->vendor->id);
}

function vendorCurrencyRate()
{
    if (!auth()->check() || !user() || !user()->vendor) {
        return 1.0;
    }
    return getVendorCurrencyRate(user()->vendor->id);
}

function parentCurrencyRate()
{
    $currency = currency();
    if (!$currency) return 1.0;
    if ($currency->parent_currency == 'usd') return (float) ($currency->usd_rate ?? 1.0);
    if ($currency->parent_currency == 'jpy') return (float) ($currency->jpn_rate ?? 1.0);
    if ($currency->parent_currency == 'sar') return (float) ($currency->ksa_riyal ?? 1.0);
    if ($currency->parent_currency == 'bdt') return (float) ($currency->bdt_rate ?? 1.0);
    if ($currency->parent_currency == 'aed') return (float) ($currency->uae_rate ?? 1.0);
    return 1.0;
}

function makeParent($price)
{   
    $vendorRate = vendorCurrencyRate();
    $parentRate = parentCurrencyRate();
    if ($vendorRate > 0) {
        return ($price / $vendorRate) * $parentRate;
    }
    return $price;
}

function moqPrice($mainPrice, $price, $vendor_id)
{
    $vendorRate = getVendorCurrencyRate($vendor_id);
    $userRate = getUserCurrencyRate();
    if ($vendorRate > 0) {
        $converted = ($price / $vendorRate) * $userRate;
        return number_format($converted, 2, '.', '');
    }
    return number_format($price, 2, '.', '');
}