<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Variant;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use Auth;
use DB;
use Validator;
use App\Services\Product\ProductService;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\Variant\VariantService;
use App\Models\Slider;
use App\Models\Whishlist;
use App\Models\Whitelist;
use App\Models\ProductReview;
use App\Models\SteadfastOrder;
use App\Models\DeliveryChargeSetting;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{   

    public function __construct(
        protected ProductService $productService,
        protected VariantService $variantService
    ) {
        //$this->middleware('auth_check');
    }

    public function sliders()
    {
        try
        {
            $sliders = Slider::where('status','Active')->get();
            return response()->json(['status'=>count($sliders) > 0, 'data'=>$sliders]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $search = $request->search ?? $request->name ?? $request->keyword ?? '';
            $perPage = (int) ($request->input('per_page') ?? 10);
            $query = Product::with(['category', 'subcategory', 'productVariants', 'unit'])->where('status', 'Active');
            
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->filled('subcategory_id')) {
                $query->where('subcategory_id', $request->subcategory_id);
            }
            if (!empty($search)) {
                $query->where('product_name', 'LIKE', "%{$search}%");
            }
            
            $products = $query->latest('id')->paginate($perPage);
            return response()->json(['status' => true, 'data' => $products]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    protected function resolveUser(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user && $request->filled('user_id')) {
            $user = User::find($request->user_id);
        }
        return $user;
    }

    public function userAuth(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string',
                'name' => 'nullable|string|max:100',
                'email' => 'nullable|email',
                'phone' => 'nullable|string|max:50',
                'device_token' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please fill all requirement fields',
                    'data' => $validator->errors()
                ], 422);
            }

            $email = $request->input('email');
            $phone = $request->input('phone');
            $login = $request->input('login');

            if (!$email && filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $email = $login;
            } elseif (!$phone && $login) {
                $phone = $login;
            }

            if (empty($email) && empty($phone)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please provide an email or phone number.',
                    'token' => '',
                    'user' => new \stdClass()
                ], 422);
            }

            $password = $request->input('password');

            // Check if user exists by email or phone
            $user = User::where(function ($q) use ($email, $phone) {
                if (!empty($email)) {
                    $q->where('email', $email);
                }
                if (!empty($phone)) {
                    if (!empty($email)) {
                        $q->orWhere('phone', $phone);
                    } else {
                        $q->where('phone', $phone);
                    }
                }
            })->first();

            // IF USER ALREADY EXISTS -> SIGN IN
            if ($user) {
                if ($user->status == 'Inactive') {
                    return response()->json([
                        'status' => false,
                        'message' => 'Sorry, your account is inactive. Please contact support.',
                        'token' => '',
                        'user' => new \stdClass()
                    ], 403);
                }

                if (!Hash::check($password, $user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid password. If this is your account, please enter the correct password.',
                        'token' => '',
                        'user' => new \stdClass()
                    ], 401);
                }

                // Update device_token or missing details if provided
                if ($request->filled('device_token')) {
                    $user->device_token = $request->device_token;
                }
                if ($request->filled('name') && empty($user->name)) {
                    $user->name = $request->name;
                }
                if ($request->filled('phone') && empty($user->phone)) {
                    $user->phone = $phone;
                }
                if ($request->filled('email') && empty($user->email)) {
                    $user->email = $email;
                }
                $user->save();

                $token = $user->createToken('MyApp')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Logged IN',
                    'is_new_user' => false,
                    'token' => $token,
                    'user' => $user,
                    'data' => $user
                ], 200);
            }

            // IF USER DOES NOT EXIST -> REGISTER (SIGN UP) & SIGN IN
            $user = new User();
            $user->role_id = 3; // customer role
            $user->name = $request->input('name') ?? ($email ? explode('@', $email)[0] : 'User');
            $user->email = $email;
            $user->phone = $phone;
            $user->password = bcrypt($password);
            $user->status = 'Active';
            if ($request->filled('device_token')) {
                $user->device_token = $request->device_token;
            }
            $user->save();

            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Account created and successfully logged in',
                'is_new_user' => true,
                'token' => $token,
                'user' => $user,
                'data' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function userSignup(Request $request)
    {
        return $this->userAuth($request);
    }

    public function userSignin(Request $request)
    {
        return $this->userAuth($request);
    }

    public function userSignOut(Request $request)
    {
        try
        {
            $user = $this->resolveUser($request);
            if ($user && method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }
            return response()->json(['status'=>true, 'message'=>'Successfully Logged Out']);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }


    public function vendorSignup(Request $request)
    {
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Upload Files
            |--------------------------------------------------------------------------
            */

            $validator = Validator::make($request->all(), [

                // USER
                'name'                  => 'required|string|max:255',
                'email'                 => 'required|email|unique:users,email',
                'phone'                 => 'required|string|max:20|unique:users,phone',
                'password'              => 'required|string|min:6|confirmed',

                // VENDOR
                'shop_name'             => 'required|string|max:255',
                'nid_number'            => 'required|string|max:100|unique:vendors,nid_number',

                'nid_front'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'nid_back'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'selfie_photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

                'trade_license_no'      => 'nullable|string|max:255',

                'tin_no'                => 'nullable|string|max:255',
                'tin_file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

                'bin_no'                => 'nullable|string|max:255',
                'bin_file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

                'bank_name'             => 'nullable|string|max:255',
                'branch_name'           => 'nullable|string|max:255',
                'account_name'          => 'nullable|string|max:255',
                'account_number'        => 'nullable|string|max:255',

                'cancelled_cheque'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

                'pickup_address'        => 'nullable|string',
                'return_address'        => 'nullable|string',

            ], [

                'name.required'                 => 'Full name is required.',

                'email.required'                => 'Email is required.',
                'email.email'                   => 'Enter a valid email address.',
                'email.unique'                  => 'Email already exists.',

                'phone.required'                => 'Phone number is required.',
                'phone.unique'                  => 'Phone number already exists.',

                'password.required'             => 'Password is required.',
                'password.min'                  => 'Password must be at least 6 characters.',
                'password.confirmed'            => 'Password confirmation does not match.',

                'shop_name.required'            => 'Shop name is required.',

                'nid_number.required'           => 'NID number is required.',
                'nid_number.unique'             => 'This NID number is already registered.',

                'nid_front.image'               => 'NID Front must be an image.',
                'nid_back.image'                => 'NID Back must be an image.',
                'selfie_photo.image'            => 'Selfie must be an image.',

                'tin_file.mimes'                => 'TIN file must be JPG, PNG or PDF.',
                'bin_file.mimes'                => 'BIN file must be JPG, PNG or PDF.',
                'cancelled_cheque.mimes'        => 'Cancelled cheque must be JPG, PNG or PDF.',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }


            $nidFront = null;
            $nidBack = null;
            $selfie = null;
            $tinFile = null;
            $binFile = null;
            $cancelCheque = null;

            if ($request->hasFile('nid_front')) {

                $file = $request->file('nid_front');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $nidFront = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('nid_back')) {

                $file = $request->file('nid_back');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $nidBack = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('selfie_photo')) {

                $file = $request->file('selfie_photo');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $selfie = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('tin_file')) {

                $file = $request->file('tin_file');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $tinFile = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('bin_file')) {

                $file = $request->file('bin_file');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $binFile = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('cancelled_cheque')) {

                $file = $request->file('cancelled_cheque');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $cancelCheque = 'uploads/vendors/'.$name;
            }

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'phone' => $request->phone,

                'role_id' => 2,

                'password' => Hash::make($request->password),

            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Vendor
            |--------------------------------------------------------------------------
            */

            Vendor::create([

                'user_id' => $user->id,

                'shop_name' => $request->shop_name,

                'nid_number' => $request->nid_number,

                'nid_front' => $nidFront,

                'nid_back' => $nidBack,

                'selfie_photo' => $selfie,

                'trade_license_no' => $request->trade_license_no,

                'tin_no' => $request->tin_no,

                'tin_file' => $tinFile,

                'bin_no' => $request->bin_no,

                'bin_file' => $binFile,

                'bank_name' => $request->bank_name,

                'branch_name' => $request->branch_name,

                'account_name' => $request->account_name,

                'account_number' => $request->account_number,

                'cancelled_cheque' => $cancelCheque,

                'pickup_address' => $request->pickup_address,

                'return_address' => $request->return_address,

            ]);

            DB::commit();

            //return redirect('/vendor-login');

            // return redirect()
            //     ->route('vendor.signup.form')
            //     ->with('success', 'Vendor account created successfully.');

            return response()->json(['status'=>true, 'message'=>'Successfully Vendor Signup', 'data'=>$vendor]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);

        }
    }


    public function vendorSignin(Request $request)
    {
        try {

            
            $validator = Validator::make($request->all(), [
                'login' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Please fill all requirement fields', 
                    'data' => $validator->errors()
                ], 422);  
            }

            $vendor = User::where('email',$request->login)->orWhere('phone',$request->login)->where('role_id',2)->first();

            if($vendor)
            {
                Auth::login($vendor);
                $token = $vendor->createToken('MyApp')->plainTextToken;
                return response()->json(['status'=>true, 'message'=>'Successfully Logged IN', 'token'=>$token, 'data'=>$vendor]);
            }

            return response()->json(['status'=>false, 'message'=>"Email/Phone Or Password Invalid", 'token'=>"", 'data'=>new \stdClass()],401);    

        } catch (\Exception $e) {

            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
            // return back()
            //     ->withInput()
            //     ->with('error', $e->getMessage());
        }
    }

    public function vendorSignout(Request $request)
    {
        try
        {
            auth()->user()->tokens()->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully Logged Out']);
        }catch (\Exception $e) {

            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
            // return back()
            //     ->withInput()
            //     ->with('error', $e->getMessage());
        }
    }



    /**
     * Compute delivery charge for vendor items based on place_type (inside or outside).
     * Follows payshop_ecm_modify delivery charge calculation.
     */
    public function currencyLists(Request $request)
    {
        try {
            $currency = currency();
            if (!$currency) {
                return response()->json(['status' => false, 'message' => 'Currency settings not found'], 404);
            }

            $parent = strtolower((string)$currency->parent_currency);

            $data = [
                [
                    'code'         => 'USD',
                    'currency_key' => 'usd_rate',
                    'name'         => 'US Dollar',
                    'symbol'       => $currency->usd_symbol ?? '$',
                    'rate'         => (float)($currency->usd_rate ?? 1.0),
                    'is_parent'    => in_array($parent, ['usd', 'usd_rate']),
                ],
                [
                    'code'         => 'BDT',
                    'currency_key' => 'bdt_rate',
                    'name'         => 'Bangladeshi Taka',
                    'symbol'       => $currency->bdt_symbol ?? '৳',
                    'rate'         => (float)($currency->bdt_rate ?? 125.0),
                    'is_parent'    => in_array($parent, ['bdt', 'bdt_rate']),
                ],
                [
                    'code'         => 'SAR',
                    'currency_key' => 'ksa_riyal',
                    'name'         => 'Saudi Riyal',
                    'symbol'       => $currency->riyal_symbol ?? 'SAR',
                    'rate'         => (float)($currency->ksa_riyal ?? 3.8),
                    'is_parent'    => in_array($parent, ['sar', 'ksa_riyal']),
                ],
                [
                    'code'         => 'AED',
                    'currency_key' => 'uae_rate',
                    'name'         => 'UAE Dirham',
                    'symbol'       => $currency->uae_symbol ?? 'AED',
                    'rate'         => (float)($currency->uae_rate ?? 3.67),
                    'is_parent'    => in_array($parent, ['aed', 'uae_rate']),
                ],
                [
                    'code'         => 'JPY',
                    'currency_key' => 'jpn_rate',
                    'name'         => 'Japanese Yen',
                    'symbol'       => $currency->jpn_symbol ?? '¥',
                    'rate'         => (float)($currency->jpn_rate ?? 165.0),
                    'is_parent'    => in_array($parent, ['jpy', 'jpn_rate']),
                ],
            ];

            return response()->json([
                'status'  => true,
                'message' => 'Currency lists retrieved successfully',
                'data'    => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

/**
     * Compute delivery charge for vendor items based on place_type (inside_city or outside_city).
     * Follows payshop_ecm_modify delivery charge calculation.
     */
    protected function computeDeliveryChargeForVendors($vendorCartGroups, $placeType = 'inside_city')
    {
        $isOutside = in_array(strtolower((string)$placeType), ['outside', 'outside_city', 'outside_dhaka']);
        $normalizedPlace = $isOutside ? 'outside_city' : 'inside_city';
        $userRate = getUserCurrencyRate();
        $totalDelivery = 0;
        $vendorDeliveryCharges = [];

        foreach ($vendorCartGroups as $vId => $vItems) {
            $vObj = Vendor::find($vId);
            $vUserId = $vObj ? $vObj->user_id : null;
            $vendorRate = getVendorCurrencyRate($vId);

            $baseCharge = 0;
            if ($isOutside) {
                foreach ($vItems as $it) {
                    $prod = is_array($it) ? ($it['product'] ?? null) : ($it->product ?? null);
                    $charge = $prod ? $prod->productdeliverycharge : null;
                    $ob = $charge->outside_base_charge ?? 0;
                    if ($ob > $baseCharge) {
                        $baseCharge = $ob;
                    }
                }
                if ($baseCharge == 0 && $vUserId) {
                    $baseCharge = DeliveryChargeSetting::where('user_id', $vUserId)->value('outside_city_charge') ?? 0;
                }
            } else {
                foreach ($vItems as $it) {
                    $prod = is_array($it) ? ($it['product'] ?? null) : ($it->product ?? null);
                    $charge = $prod ? $prod->productdeliverycharge : null;
                    $ib = $charge->inside_base_charge ?? 0;
                    if ($ib > $baseCharge) {
                        $baseCharge = $ib;
                    }
                }
                if ($baseCharge == 0 && $vUserId) {
                    $baseCharge = DeliveryChargeSetting::where('user_id', $vUserId)->value('inside_city_charge') ?? 0;
                }
            }

            $weightCharge = 0;
            foreach ($vItems as $it) {
                $prod = is_array($it) ? ($it['product'] ?? null) : ($it->product ?? null);
                $qty = is_array($it) ? ($it['qty'] ?? 1) : ($it->cart_qty ?? 1);
                $charge = $prod ? $prod->productdeliverycharge : null;
                if ($charge) {
                    $weightCharge += ($charge->product_weight * $qty) * ($charge->per_weight_charge ?? 0);
                }
            }

            $vendorDelivery = round((float)$baseCharge + (float)$weightCharge, 2);
            $vendorDeliveryCharges[$vId] = $vendorDelivery;

            $vendorDeliveryInUserCur = $vendorRate > 0 ? ($vendorDelivery / $vendorRate) * $userRate : $vendorDelivery;
            $totalDelivery += $vendorDeliveryInUserCur;
        }

        return [
            'place_type'              => $normalizedPlace,
            'total_delivery'          => round($totalDelivery, 2),
            'vendor_delivery_charges' => $vendorDeliveryCharges,
        ];
    }

public function checkCartStock(Request $request)
    {
        try {
            $user = $this->resolveUser($request);

            // Set session currency if passed in request body
            if ($request->filled('currency')) {
                Session::put('currency', getUserCurrencyKey());
            }

            $items = $request->input('items') ?? $request->input('products') ?? $request->input('cart');
            if (!is_array($items)) {
                if ($request->has('product_id')) {
                    $items = [
                        [
                            'product_id' => $request->product_id,
                            'qty' => $request->qty ?? $request->quantity ?? 1,
                            'variant_id' => $request->variant_id,
                            'product_variant_id' => $request->product_variant_id,
                        ]
                    ];
                } else {
                    $items = [];
                }
            }

            if (empty($items)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart is empty. Please provide product items.'
                ], 422);
            }

            $stockErrors = [];
            $validatedItems = [];

            foreach ($items as $item) {
                $productId = $item['product_id'] ?? null;
                $qty = (int) ($item['qty'] ?? $item['quantity'] ?? $item['cart_qty'] ?? 1);
                $productVariantId = $item['product_variant_id'] ?? null;
                $variantId = $item['variant_id'] ?? null;
                $unitTotalProvided = (isset($item['unit_total']) && $item['unit_total'] !== null && $item['unit_total'] !== '') ? (float)$item['unit_total'] : null;

                if (!$productId || $qty <= 0) {
                    continue;
                }

                $product = Product::with(['user.vendor', 'productVariants', 'productdeliverycharge'])->find($productId);
                if (!$product) {
                    $stockErrors[] = [
                        'product_id' => $productId,
                        'product_name' => 'Unknown Product',
                        'requested_qty' => $qty,
                        'available_stock' => 0,
                        'message' => "Product with ID {$productId} not found."
                    ];
                    continue;
                }

                $availableStock = (int) ($product->stock_qty ?? 0);
                if ($availableStock < $qty) {
                    $stockErrors[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'requested_qty' => $qty,
                        'available_stock' => $availableStock,
                        'message' => "Insufficient stock for '{$product->product_name}'. Requested: {$qty}, Available: {$availableStock}"
                    ];
                }

                if ($productVariantId) {
                    $pv = ProductVariant::find($productVariantId);
                    if ($pv && !is_null($pv->stock_qty) && (int)$pv->stock_qty < $qty) {
                        $stockErrors[] = [
                            'product_id' => $product->id,
                            'product_variant_id' => $productVariantId,
                            'product_name' => $product->product_name . " ({$pv->variant_value})",
                            'requested_qty' => $qty,
                            'available_stock' => (int)$pv->stock_qty,
                            'message' => "Insufficient stock for '{$product->product_name}' ({$pv->variant_value}). Requested: {$qty}, Available: {$pv->stock_qty}"
                        ];
                    }
                }

                $validatedItems[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'unit_total' => $unitTotalProvided,
                    'variant_id' => $variantId,
                    'product_variant_id' => $productVariantId,
                ];
            }

            // Return multiple stock errors if any exist
            if (count($stockErrors) > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stock insufficient for one or more products in your cart.',
                    'errors' => $stockErrors
                ], 400);
            }

            // Generate unique cart reference ID
            $cartSessionId = 'CART-' . time() . '-' . rand(1000, 9999);

            $subtotal = 0;
            $itemsData = [];
            $vendorCartGroups = [];

            foreach ($validatedItems as $vItem) {
                $product = $vItem['product'];
                $qty = $vItem['qty'];

                // Unit total provided from body or calculated dynamically
                if (!is_null($vItem['unit_total'])) {
                    $unitTotal = round((float)$vItem['unit_total'], 2);
                    $unitPrice = $qty > 0 ? round($unitTotal / $qty, 2) : $unitTotal;
                } else {
                    $unitPrice = $product->calculatePriceForQty($qty);
                    $unitTotal = round($unitPrice * $qty, 2);
                }

                $subtotal += $unitTotal;

                $vendor = Vendor::where('user_id', $product->user_id)->first();
                $vendorId = $vendor ? $vendor->id : null;

                $cartRecord = Cart::create([
                    'cart_session_id'    => $cartSessionId,
                    'product_id'         => $product->id,
                    'vendor_id'          => $vendorId,
                    'variant_id'         => $vItem['variant_id'],
                    'product_variant_id' => $vItem['product_variant_id'],
                    'cart_price'         => $unitPrice,
                    'cart_qty'           => $qty,
                    'unit_total'         => $unitTotal,
                    'currency'           => getUserCurrencyKey(),
                ]);

                $vendorCartGroups[$vendorId][] = [
                    'product' => $product,
                    'qty'     => $qty,
                ];

                $itemsData[] = [
                    'cart_item_id'       => $cartRecord->id,
                    'product_id'         => $product->id,
                    'product_name'       => $product->product_name,
                    'product_image'      => $product->product_image,
                    'qty'                => $qty,
                    'unit_price'         => $unitPrice,
                    'unit_total'         => $unitTotal,
                    'available_stock'    => (int)$product->stock_qty,
                    'variant_id'         => $vItem['variant_id'],
                    'product_variant_id' => $vItem['product_variant_id'],
                ];
            }

            // Calculate inside_city and outside_city delivery charges dynamically in user currency
            $insideDelivery = $this->computeDeliveryChargeForVendors($vendorCartGroups, 'inside_city');
            $outsideDelivery = $this->computeDeliveryChargeForVendors($vendorCartGroups, 'outside_city');

            $vat = 0;

            return response()->json([
                'status' => true,
                'message' => 'Cart items and stock verified successfully',
                'data' => [
                    'cart_id'          => $cartSessionId,
                    'cart_session_id'  => $cartSessionId,
                    'items_count'      => count($itemsData),
                    'sub_total'        => round($subtotal, 2),
                    'delivery_charges' => [
                        'inside_city'  => $insideDelivery['total_delivery'],
                        'outside_city' => $outsideDelivery['total_delivery'],
                    ],
                    'vat_tax'          => $vat,
                    'currency'         => getUserCurrencyKey(),
                    'currency_symbol'  => getUserCurrencySymbol(),
                    'payment_methods'  => PaymentMethod::all(['id', 'name']),
                    'items'            => $itemsData,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

public function saveOrder(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        DB::beginTransaction();

        try {
            $user = $this->resolveUser($request);

            // Sync user selected currency if provided in request body
            if ($request->filled('currency')) {
                Session::put('currency', getUserCurrencyKey());
            }

            // Step 1: Validate User Checkout info (place_type: inside_city or outside_city)
            $validator = Validator::make($request->all(), [
                'user_name'    => 'required|string|max:100',
                'user_phone'   => 'required|string|max:50',
                'user_address' => 'required|string',
                'user_email'   => 'nullable|email',
                'user_city'    => 'nullable|string|max:100',
                'user_country' => 'nullable|string|max:100',
                'user_zipcode' => 'nullable|string|max:20',
                'place_type'   => 'required|in:inside_city,outside_city,inside,outside',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please fill all requirement fields',
                    'data' => $validator->errors()
                ], 422);
            }

            // Step 2: Retrieve cart items either by cart_id / cart_session_id OR direct items array
            $cartId = $request->input('cart_id') ?? $request->input('cart_session_id') ?? $request->input('id');
            $carts = collect();

            if (!empty($cartId)) {
                $carts = Cart::with(['product.productdeliverycharge', 'product.user.vendor', 'product.moqs'])
                    ->where('cart_session_id', $cartId)
                    ->get();

                if ($carts->isEmpty()) {
                    $carts = Cart::with(['product.productdeliverycharge', 'product.user.vendor', 'product.moqs'])
                        ->where('id', $cartId)
                        ->get();
                }
            }

            // Fallback: if no cart_id, check if items array was sent directly
            if ($carts->isEmpty()) {
                $items = $request->input('items') ?? $request->input('products') ?? $request->input('cart');
                if (is_array($items) && count($items) > 0) {
                    $tempSessionId = 'CART-TEMP-' . time() . '-' . rand(1000, 9999);
                    foreach ($items as $it) {
                        $pId = $it['product_id'] ?? null;
                        $q = (int) ($it['qty'] ?? $it['quantity'] ?? 1);
                        if ($pId && $q > 0) {
                            $prod = Product::find($pId);
                            if ($prod) {
                                $vendor = Vendor::where('user_id', $prod->user_id)->first();
                                if (isset($it['unit_total']) && $it['unit_total'] !== null && $it['unit_total'] !== '') {
                                    $uTotal = round((float)$it['unit_total'], 2);
                                    $price = $q > 0 ? round($uTotal / $q, 2) : $uTotal;
                                } else {
                                    $price = $prod->calculatePriceForQty($q);
                                    $uTotal = round($price * $q, 2);
                                }
                                Cart::create([
                                    'cart_session_id'    => $tempSessionId,
                                    'product_id'         => $prod->id,
                                    'vendor_id'          => $vendor ? $vendor->id : null,
                                    'variant_id'         => $it['variant_id'] ?? null,
                                    'product_variant_id' => $it['product_variant_id'] ?? null,
                                    'cart_price'         => $price,
                                    'cart_qty'           => $q,
                                    'unit_total'         => $uTotal,
                                    'currency'           => getUserCurrencyKey(),
                                ]);
                            }
                        }
                    }
                    $carts = Cart::with(['product.productdeliverycharge', 'product.user.vendor', 'product.moqs'])
                        ->where('cart_session_id', $tempSessionId)
                        ->get();
                    $cartId = $tempSessionId;
                }
            }

            if ($carts->isEmpty()) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Cart is empty or not found. Please verify cart items and try again.'
                ], 422);
            }

            // Step 3: Stock validation for all cart items
            $stockErrors = [];
            foreach ($carts as $cItem) {
                $product = $cItem->product;
                if (!$product) {
                    $stockErrors[] = [
                        'product_id' => $cItem->product_id,
                        'message' => "Product ID {$cItem->product_id} no longer exists."
                    ];
                    continue;
                }
                if ((int)$product->stock_qty < (int)$cItem->cart_qty) {
                    $stockErrors[] = [
                        'product_id'      => $product->id,
                        'product_name'    => $product->product_name,
                        'requested_qty'   => (int)$cItem->cart_qty,
                        'available_stock' => (int)$product->stock_qty,
                        'message'         => "Insufficient stock for '{$product->product_name}'. Requested: {$cItem->cart_qty}, Available: {$product->stock_qty}"
                    ];
                }
                if ($cItem->product_variant_id) {
                    $pv = ProductVariant::find($cItem->product_variant_id);
                    if ($pv && !is_null($pv->stock_qty) && (int)$pv->stock_qty < (int)$cItem->cart_qty) {
                        $stockErrors[] = [
                            'product_id'         => $product->id,
                            'product_variant_id' => $cItem->product_variant_id,
                            'product_name'       => $product->product_name . " ({$pv->variant_value})",
                            'requested_qty'      => (int)$cItem->cart_qty,
                            'available_stock'    => (int)$pv->stock_qty,
                            'message'            => "Insufficient stock for variant '{$pv->variant_value}'. Requested: {$cItem->cart_qty}, Available: {$pv->stock_qty}"
                        ];
                    }
                }
            }

            if (count($stockErrors) > 0) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Stock insufficient for one or more products in your cart.',
                    'errors' => $stockErrors
                ], 400);
            }

            // Step 4: Calculate subtotal and delivery charge automatically from inside_city or outside_city
            $subtotal = $carts->sum('unit_total');

            // Determine place_type: 'inside_city' or 'outside_city'
            $placeTypeInput = $request->input('place_type', 'inside_city');
            $vendorCartGroups = $carts->groupBy('vendor_id');
            $deliveryCalc = $this->computeDeliveryChargeForVendors($vendorCartGroups, $placeTypeInput);
            $placeType = $deliveryCalc['place_type']; // 'inside_city' or 'outside_city'
            $deliveryCharge = $deliveryCalc['total_delivery'];
            $vendorDeliveryCharges = $deliveryCalc['vendor_delivery_charges'];

            $userRate = getUserCurrencyRate();
            $userSymbol = getUserCurrencySymbol();
            $vat = 0;
            $total = round($subtotal + $vat + $deliveryCharge, 2);

            // Step 5: Generate unique invoice number
            $count = Order::count() + 1;
            $invoice = 'INV-00' . $count;
            while (Order::where('invoice_no', $invoice)->exists()) {
                $count++;
                $invoice = 'INV-00' . $count;
            }

            // Step 6: Create Order record
            $order = Order::create([
                'user_id'           => $user ? $user->id : null,
                'payment_method_id' => $request->payment_method_id ?? 1,
                'invoice_no'        => $invoice,
                'date'              => now()->format('Y-m-d'),
                'time'              => now()->format('h:i:s A'),
                'timestamp'         => now()->timestamp,
                'sub_total'         => $subtotal,
                'vat_tax'           => $vat,
                'total'             => $total,
                'user_name'         => $request->user_name,
                'user_email'        => $request->user_email,
                'user_phone'        => $request->user_phone,
                'user_address'      => $request->user_address,
                'user_city'         => $request->user_city ?? ($placeType === 'outside_city' ? 'Outside City' : 'Dhaka'),
                'user_country'      => $request->user_country ?? 'Bangladesh',
                'user_zipcode'      => $request->user_zipcode,
                'place_type'        => $placeType,
                'delivery_charge'   => $deliveryCharge,
                'order_type'        => $user ? 'authetic_order' : 'direct_order',
            ]);

            // Step 7: Create OrderDetails records with place_type and vendor delivery charge
            foreach ($carts as $cart) {
                $product = $cart->product;
                $vendorId = $cart->vendor_id;
                $vendorRate = getVendorCurrencyRate($vendorId);
                $vendorSymbol = getVendorCurrencySymbol($vendorId);

                if ($userRate > 0) {
                    $vendorPrice = ($cart->cart_price / $userRate) * $vendorRate;
                } else {
                    $vendorPrice = $cart->cart_price;
                }

                $vendorDelivery = ($vendorId && isset($vendorDeliveryCharges[$vendorId])) 
                    ? $vendorDeliveryCharges[$vendorId] 
                    : ($vendorDeliveryCharges[''] ?? ($vendorDeliveryCharges[null] ?? $deliveryCharge));

                OrderDetail::create([
                    'order_id'            => $order->id,
                    'user_id'             => $product->user_id, // Vendor user ID
                    'product_id'          => $cart->product_id,
                    'current_symbol'      => $userSymbol,
                    'variant_id'          => $cart->variant_id,
                    'product_variant_id'  => $cart->product_variant_id,
                    'payment_method_id'   => $order->payment_method_id,
                    'purchase_price'      => $cart->cart_price,
                    'purchase_discount'   => $product->product_discount ?? 0,
                    'vendor_price'        => round($vendorPrice, 2),
                    'vendor_symbol'       => $vendorSymbol,
                    'qty'                 => $cart->cart_qty,
                    'place_type'          => $placeType,
                    'delivery_charge'     => $vendorDelivery,
                    'status'              => 'Pending',
                ]);

                // Deduct stock
                if (!is_null($product->stock_qty)) {
                    $product->stock_qty = max(0, (float)$product->stock_qty - (float)$cart->cart_qty);
                    $product->save();
                }

                if ($cart->product_variant_id) {
                    $pv = ProductVariant::find($cart->product_variant_id);
                    if ($pv && !is_null($pv->stock_qty)) {
                        $pv->stock_qty = max(0, (float)$pv->stock_qty - (float)$cart->cart_qty);
                        $pv->save();
                    }
                }
            }

            // Step 8: Clean up cart records
            if (!empty($cartId)) {
                Cart::where('cart_session_id', $cartId)->delete();
            }

            DB::commit();

            $orderWithDetails = Order::with(['orderDetails.product', 'orderDetails.variant', 'orderDetails.productVariant'])->find($order->id);

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'data' => [
                    'order_id'        => $order->id,
                    'invoice_no'      => $order->invoice_no,
                    'place_type'      => $order->place_type,
                    'sub_total'       => $order->sub_total,
                    'delivery_charge' => $order->delivery_charge,
                    'total'           => $order->total,
                    'currency'        => getUserCurrencyKey(),
                    'currency_symbol' => $userSymbol,
                    'date'            => $order->date,
                    'time'            => $order->time,
                    'order'           => $orderWithDetails,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function saveProduct(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'product_name'      => 'required|string|max:255|unique:products,product_name',
                'category_id'       => 'required|exists:categories,id',
                'subcategory_id'    => 'nullable|exists:subcategories,id',
                'unit_id'           => 'required|exists:units,id',

                'product_price'     => 'required|numeric|min:1',
                'product_discount'  => 'nullable|numeric|min:1',
                'stock_qty'         => 'required|numeric|min:1',

                'description'       => 'required|string',

                'featured_image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

                'status'            => 'nullable|in:Active,Inactive',
                'admin_verify'      => 'nullable|in:Yes,No',
            ], [
                'product_name.required' => 'Product name is required',
                'category_id.required'  => 'Category is required',
                'unit_id.required'      => 'Unit is required',
                'featured_image.required'=> 'Product image is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()
                ], 422);
            } 


            $this->productService->store($request->validated());

            return response()->json(['status'=>true, 'message'=>'Successfully a product has been added']);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function categoryLists(Request $request)
    {
        try
        {   
            
            $query = Category::query();
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('category_name', 'LIKE', "%{$search}%");
            }
            $data = $query->where('status','Active')->latest()->get();
            return response()->json(['status'=>count($data) > 0, 'data'=>$data]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function subcategoryLists(Request $request)
    {
        try
        {
            $query = Subcategory::query();
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('category_name', 'LIKE', "%{$search}%");
            }
            $data = $query->where('status','Active')->latest()->get();
            return response()->json(['status'=>count($data) > 0, 'data'=>$data]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function productLists(Request $request)
    {
        try
        {   

            $validator = Validator::make($request->all(), [
                'per_page' => 'nullable|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Please fill all requirement fields', 
                    'data' => $validator->errors()
                ], 422);  
            }

            $per_page = $request->has('per_page')?$request->per_page:10;
            $query = Product::query();
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('product_name', 'LIKE', "%{$search}%");
            }

            if($request->has('category_id'))
            {
                $query->where('category_id',$request->category_id);
            }

            if($request->has('subcategory_id'))
            {
                $query->where('subcategory_id',$request->subcategory_id);
            }

            $data = $query->with('category','subcategory','productVariants')->where('user_id',user()->id)->latest()->paginate($per_page);
            return response()->json($data);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function vendorproductDetails($id)
    {
        try
        {
            $product = Product::with('category','subcategory','productVariants')->findorfail($id);
            return response()->json(['status'=>true, 'data'=>$product]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function productUpdate(Request $request,$id)
    {
        try
        {
            $productId = $id;

            $validator = Validator::make($request->all(), [

                'product_name'      => 'required|string|max:255|unique:products,product_name,' . $productId,
                'category_id'       => 'required|exists:categories,id',
                'subcategory_id'    => 'nullable|exists:subcategories,id',
                'unit_id'           => 'required|exists:units,id',

                'product_price'     => 'required|numeric|min:0',
                'product_discount'  => 'nullable|numeric|min:0',
                'stock_qty'         => 'required|numeric|min:0',

                'description'       => 'required|string',

                'featured_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

                'status'            => 'nullable|in:Active,Inactive',
                'admin_verify'      => 'nullable|in:Yes,No',

            ], [

                'product_name.required' => 'Product name is required.',
                'product_name.unique'   => 'Product name already exists.',

                'category_id.required'  => 'Category is required.',
                'category_id.exists'    => 'Selected category is invalid.',

                'subcategory_id.exists' => 'Selected subcategory is invalid.',

                'unit_id.required'      => 'Unit is required.',
                'unit_id.exists'        => 'Selected unit is invalid.',

                'product_price.required' => 'Product price is required.',
                'product_price.numeric'  => 'Product price must be a number.',
                'product_price.min'      => 'Product price must be at least 0.',

                'product_discount.numeric' => 'Product discount must be a number.',
                'product_discount.min'     => 'Product discount must be at least 0.',

                'stock_qty.required' => 'Stock quantity is required.',
                'stock_qty.numeric'  => 'Stock quantity must be a number.',
                'stock_qty.min'      => 'Stock quantity must be at least 0.',

                'description.required' => 'Description is required.',

                'featured_image.image' => 'Featured image must be an image.',
                'featured_image.mimes' => 'Featured image must be a JPG, JPEG, PNG or WEBP file.',
                'featured_image.max'   => 'Featured image may not be greater than 2 MB.',

                'status.in'       => 'Status must be Active or Inactive.',
                'admin_verify.in' => 'Admin verify must be Yes or No.',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $product = Product::with('category','subcategory','productVariants')->findorfail($productId);

            $this->productService->update($request->validated(), $product);

            $product->refresh();

            return response()->json(['status'=>true, 'message'=>'Successfully updated', 'data'=>$product]);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function productDelete($id)
    {
        try
        {   
            $product = Product::findorfail($id);
            $this->productService->delete($product);

            return response()->json([
                'status' => true,                         
                'message' => 'Product deleted successfully'
            ]);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function productStatusUpdate(Request $request)
    {
        try
        {  

            $this->productService->updateStatus(
                $request->product_id,
                $request->status
            );

            return response()->json([
                'status'  => true,
                'message' => 'Status updated successfully'
            ]);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function variantLists(Request $request)
    {
        try
        {
            $data = Variant::get();
            return response()->json(['status'=>count($data) > 0, 'data'=>$data]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function productVariantLists($id)
    {
        try
        {
            $product = Product::findorfail($id);
            $variants = Variant::with(['productVariants' => function ($query) use ($id) {
                $query->where('product_id', $id);
            }])->get();
            return response()->json(['status'=>count($variants) > 0, 'data'=>array('product'=>$product,'variants'=>$variants)]); 
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function homeCategories(Request $request)
    {
        try
        {
            $categories = Category::with([
                        'subcategories' => function ($query) {
                            $query->where('status', 'Active');
                        }
                    ])
                    ->where('status', 'Active')
                    ->whereHas('subcategories', function ($query) {
                        $query->where('status', 'Active');
                    })
                    ->take(12)
                    ->get();

            return response()->json(['status'=>count($categories) > 0, 'data'=>$categories]);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function latestProducts(Request $request)
    {
        try
        {
            $per_page = $request->has('per_page')?$request->per_page:10;
            $query = Product::query();
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('product_name', 'LIKE', "%{$search}%");
            }

            // if($request->has('category_id'))
            // {
            //     $query->where('category_id',$request->category_id);
            // }

            // if($request->has('subcategory_id'))
            // {
            //     $query->where('subcategory_id',$request->subcategory_id);
            // }

            $data = $query->with('category','subcategory','productVariants')->latest()->paginate($per_page);
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function bestSeller(Request $request)
    {
        try
        {
            $per_page = $request->has('per_page')?$request->per_page:10;
            $query = Product::query();
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('product_name', 'LIKE', "%{$search}%");
            }

            // if($request->has('category_id'))
            // {
            //     $query->where('category_id',$request->category_id);
            // }

            // if($request->has('subcategory_id'))
            // {
            //     $query->where('subcategory_id',$request->subcategory_id);
            // }

            $data = $query->with('category','subcategory','productVariants')->paginate($per_page);
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function adminVerifyProducts(Request $request)
    {
        try
        {
            $per_page = $request->has('per_page')?$request->per_page:10;
            $query = Product::query();
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('product_name', 'LIKE', "%{$search}%");
            }

            // if($request->has('category_id'))
            // {
            //     $query->where('category_id',$request->category_id);
            // }

            // if($request->has('subcategory_id'))
            // {
            //     $query->where('subcategory_id',$request->subcategory_id);
            // }

            $data = $query->with('category','subcategory','productVariants')->where('admin_verify','Yes')->latest()->paginate($per_page);
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function categoryDetails(Request $request,$id)
    {
        try
        {   
            $per_page = $request->has('per_page')?$request->per_page:10;
            $category = Category::findorfail($id);
            $products = Product::with('category','subcategory','productVariants')->where('category_id',$id)->where('status','Active')->latest()->paginate($per_page);
            return response()->json(['stauts'=>true, 'data'=>array('category'=>$category,'products'=>$products)]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function subcategoryDetails(Request $request,$id)
    {
        try
        {   
            $per_page = $request->has('per_page')?$request->per_page:10;
            $subcategory = Subcategory::findorfail($id);
            $products = Product::with('category','subcategory','productVariants')->where('subcategory_id',$id)->where('status','Active')->latest()->paginate($per_page);
            return response()->json(['stauts'=>true, 'data'=>array('subcategory'=>$subcategory,'products'=>$products)]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function productDetails($id)
    {
        try
        {
            $product = is_numeric($id) 
                ? Product::with(['category', 'unit', 'productVariants.variant', 'user.vendor', 'moqs', 'productdeliverycharge'])->find($id)
                : Product::with(['category', 'unit', 'productVariants.variant', 'user.vendor', 'moqs', 'productdeliverycharge'])->where('slug', $id)->first();

            if (!$product) {
                return response()->json(['status' => false, 'message' => 'Product not found'], 404);
            }

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('status', 'Active')
                ->take(12)
                ->get();

            $productVariants = $product->productVariants()->get();

            $productImageVariants = $product->productVariants()
                ->whereNotNull('image')
                ->get();

            $variants = Variant::whereHas('productVariants')->with(['productVariants' => function ($q) use ($product) {
                $q->where('product_id', $product->id);
            }])->get();

            // Build Multi Quantity Price (MOQ) Tiers matching payshop_ecm_modify product_details.blade.php
            $moqTiers = $product->moq_tiers;
            $pricingTiers = [];

            if ($moqTiers && $moqTiers->isNotEmpty()) {
                $firstTier = $moqTiers->first();
                $baseMax = $firstTier->from_qty > 1 ? ($firstTier->from_qty - 1) : 1;
                $basePrice = $product->product_discount > 0 ? (float)str_replace(',', '', (string)$product->discount_price) : (float)str_replace(',', '', (string)$product->original_price);
                $vendorId = optional(optional($product->user)->vendor)->id;

                // Automatic Base Range Tier (1 to baseMax)
                $pricingTiers[] = [
                    'tier_name'       => "1 - {$baseMax} " . ($product->unit->unit_name ?? 'pcs'),
                    'from_qty'        => 1,
                    'to_qty'          => $baseMax,
                    'is_unlimited'    => false,
                    'unit_price'      => round($basePrice, 2),
                    'save_percent'    => 0,
                    'currency_symbol' => $product->current_symbol,
                ];

                foreach ($moqTiers as $tier) {
                    $tierPrice = function_exists('moqPrice') 
                        ? (float)str_replace(',', '', moqPrice($product->main_product_price ?? $product->product_price, $tier->price, $vendorId))
                        : round((float)$tier->price * getUserCurrencyRate(), 2);

                    $isUnlimited = strtolower((string)$tier->to_qty) === 'unlimited';
                    $maxQty = $isUnlimited ? null : (int)$tier->to_qty;
                    $savePercent = $basePrice > $tierPrice ? round((($basePrice - $tierPrice) / $basePrice) * 100) : 0;

                    $pricingTiers[] = [
                        'tier_name'       => $isUnlimited ? "{$tier->from_qty}+ " . ($product->unit->unit_name ?? 'pcs') : "{$tier->from_qty} - {$tier->to_qty} " . ($product->unit->unit_name ?? 'pcs'),
                        'from_qty'        => (int)$tier->from_qty,
                        'to_qty'          => $maxQty,
                        'is_unlimited'    => $isUnlimited,
                        'unit_price'      => round($tierPrice, 2),
                        'save_percent'    => $savePercent,
                        'currency_symbol' => $product->current_symbol,
                    ];
                }
            }

            $data = [
                'product'          => $product,
                'has_moq'          => count($pricingTiers) > 0,
                'moq_pricing'      => $pricingTiers,
                'variants'         => $productVariants,
                'variant_images'   => $productImageVariants,
                'variant_groups'   => $variants,
                'relatedProducts'  => $relatedProducts,
                'currency'         => getUserCurrencyKey(),
                'currency_symbol'  => getUserCurrencySymbol(),
            ];

            return response()->json(['status' => true, 'data' => $data]);

        } catch(\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function shop(Request $request)
    {
        try
        {   
            $per_page = $request->has('per_page')?$request->per_page:10;
            $query = Product::query();
            if($request->has('value')){
                if($request->value == 'hit_count'){
                    $query->orderBy('hit_count','DESC');
                }else if($request->value == 'latest'){
                    $query->latest();
                }else if($request->value == 'low_to_high'){
                    $query->orderBy('product_price','ASC');
                }else if($request->value == 'high_to_low'){
                    $query->orderBy('product_price','DESC');
                }
            }

            if($request->has('userid') && !empty($request->userid)){
                $query->where('user_id', $request->userid);
            }
            $products = $query->with('user','category')->where('status','Active')->latest()->paginate($per_page);
            return response()->json($products);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    // public function products(Request $request)
    // {
    //     try
    //     {
    //         $validator = Validator::make($request->all(), [
    //             'per_page' => 'nullable|integer'
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false, 
    //                 'message' => 'Please fill all requirement fields', 
    //                 'data' => $validator->errors()
    //             ], 422);  
    //         }

    //         $per_page = $request->has('per_page')?$request->per_page:10;
    //         $query = Product::query();
    //         if($request->has('search'))
    //         {
    //             $search = $request->search;
    //             $query->where('product_name', 'LIKE', "%{$search}%");
    //         }

    //         if($request->has('category_id'))
    //         {
    //             $query->where('category_id',$request->category_id);
    //         }

    //         if($request->has('subcategory_id'))
    //         {
    //             $query->where('subcategory_id',$request->subcategory_id);
    //         }


    //         if($request->has('value')){
    //             if($request->value == 'hit_count'){
    //                 $query->orderBy('hit_count','DESC');
    //             }else if($request->value == 'latest'){
    //                 $query->latest();
    //             }else if($request->value == 'low_to_high'){
    //                 $query->orderBy('product_price','ASC');
    //             }else if($request->value == 'high_to_low'){
    //                 $query->orderBy('product_price','DESC');
    //             }
    //         } 

    //         // $categories = Category::whereHas('products')->where('status','Active')->latest()->take(12)->get();

    //         //$products = $query->with('user','category')->where('status','Active')->latest()->paginate(9);



    //          //return view('shop',compact('categories','products'));

    //         $data = $query->with('category','subcategory','productVariants')->where('user_id',user()->id)->latest()->paginate($per_page);

    //         return response()->json($data);

    //     }catch(\Exception $e){
    //         return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    //     }
    // }

    // ==========================================
    // USER PANEL APIS (POST)
    // ==========================================

    public function userDashboardSummary(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Unauthenticated. Please login.'], 401);
            }

            $ordersQuery = Order::where('user_id', $user->id);
            $totalOrders = (clone $ordersQuery)->count();

            $pendingOrders = (clone $ordersQuery)->whereHas('orderDetails', function ($q) {
                $q->where('status', 'Pending');
            })->count();

            $processingOrders = (clone $ordersQuery)->whereHas('orderDetails', function ($q) {
                $q->whereIn('status', ['Processing', 'Confirmed']);
            })->count();

            $completedOrders = (clone $ordersQuery)->whereHas('orderDetails', function ($q) {
                $q->whereIn('status', ['Delivered', 'Completed']);
            })->count();

            $cancelledOrders = (clone $ordersQuery)->whereHas('orderDetails', function ($q) {
                $q->where('status', 'Cancelled');
            })->count();

            $totalSpent = (clone $ordersQuery)->whereHas('orderDetails', function ($q) {
                $q->whereIn('status', ['Delivered', 'Completed']);
            })->sum('total');

            if ($totalSpent == 0) {
                $totalSpent = (clone $ordersQuery)->whereDoesntHave('orderDetails', function ($q) {
                    $q->where('status', 'Cancelled');
                })->sum('total');
            }

            $totalWishlist = Whishlist::where('user_id', $user->id)->count();

            $recentOrders = Order::with([
                'orderDetails.product.category',
                'orderDetails.variant',
                'orderDetails.productVariant'
            ])
            ->where('user_id', $user->id)
            ->latest('id')
            ->take(5)
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'User dashboard summary fetched successfully',
                'data' => [
                    'user' => $user,
                    'total_orders' => $totalOrders,
                    'pending_orders' => $pendingOrders,
                    'processing_orders' => $processingOrders,
                    'completed_orders' => $completedOrders,
                    'cancelled_orders' => $cancelledOrders,
                    'total_spent' => round((float)$totalSpent, 2),
                    'total_wishlist' => $totalWishlist,
                    'recent_orders' => $recentOrders,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function userProfileUpdate(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Unauthenticated. Please login.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:100',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|unique:users,phone,' . $user->id,
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'zip_code' => 'nullable|string|max:20',
                'currency' => 'nullable|string|max:20',
                'image' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->filled('address')) {
                $user->address = $request->address;
            }
            if ($request->filled('city')) {
                $user->city = $request->city;
            }
            if ($request->filled('zip_code')) {
                $user->zip_code = $request->zip_code;
            }
            if ($request->filled('currency')) {
                $user->currency = $request->currency;
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('uploads/users');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file->move($destination, $filename);
                $user->image = 'uploads/users/' . $filename;
            } elseif ($request->filled('image') && !filter_var($request->image, FILTER_VALIDATE_URL)) {
                $imageString = $request->image;
                if (preg_match('/^data:image\/(\w+);base64,/', $imageString, $type)) {
                    $imageString = substr($imageString, strpos($imageString, ',') + 1);
                    $type = strtolower($type[1]);
                    $imageString = base64_decode($imageString);
                    if ($imageString !== false) {
                        $filename = time() . '_' . uniqid() . '.' . $type;
                        $destination = public_path('uploads/users');
                        if (!file_exists($destination)) {
                            mkdir($destination, 0777, true);
                        }
                        file_put_contents($destination . '/' . $filename, $imageString);
                        $user->image = 'uploads/users/' . $filename;
                    }
                }
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User profile updated successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function userPasswordChange(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Unauthenticated. Please login.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|same:new_password'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password does not match.'
                ], 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function userOrders(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Unauthenticated. Please login.'], 401);
            }

            $query = Order::with([
                'orderDetails.product.category',
                'orderDetails.variant',
                'orderDetails.productVariant',
                'steadfastOrder'
            ])->where('user_id', $user->id);

            // Filter from date
            if ($request->filled('from_date')) {
                $query->whereDate('date', '>=', $request->from_date);
            }

            // Filter to date
            if ($request->filled('to_date')) {
                $query->whereDate('date', '<=', $request->to_date);
            }

            // Filter status
            if ($request->filled('status')) {
                $status = $request->status;
                $query->whereHas('orderDetails', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            }

            // Filter invoice_no / order_id / search
            if ($request->filled('invoice_no')) {
                $query->where('invoice_no', 'like', '%' . $request->invoice_no . '%');
            }

            if ($request->filled('order_id')) {
                $query->where('id', $request->order_id);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('invoice_no', 'like', '%' . $search . '%')
                      ->orWhere('id', $search);
                });
            }

            $perPage = (int) ($request->input('per_page') ?? 10);
            $orders = $query->latest('id')->paginate($perPage);

            return response()->json([
                'status' => true,
                'message' => 'User orders retrieved successfully',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function userOrderDetails(Request $request)
    {
        try {
            $user = $this->resolveUser($request);

            $orderId = $request->order_id ?? $request->id;
            $invoiceNo = $request->invoice_no;

            if (!$orderId && !$invoiceNo) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please provide order_id or invoice_no.'
                ], 422);
            }

            $query = Order::with([
                'orderDetails.product.category',
                'orderDetails.variant',
                'orderDetails.productVariant',
                'steadfastOrders',
                'user'
            ]);

            if ($orderId) {
                $query->where('id', $orderId);
            } else {
                $query->where('invoice_no', $invoiceNo);
            }

            if ($user && $user->role_id == 3) {
                $query->where('user_id', $user->id);
            }

            $order = $query->first();

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Order details retrieved successfully',
                'data' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // WHITELIST / WISHLIST APIS (POST)
    // ==========================================

    public function whitelistAdd(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'To add whitelist user must login.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $exists = Whishlist::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($exists) {
                return response()->json([
                    'status' => true,
                    'message' => 'Product is already in your whitelist.',
                    'data' => $exists
                ]);
            }

            $wishlist = Whishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product added to whitelist successfully.',
                'data' => $wishlist
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function whitelistList(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Please login to view whitelist.'], 401);
            }

            $perPage = (int) ($request->input('per_page') ?? 15);
            $items = Whishlist::with([
                'product.category',
                'product.subcategory',
                'product.productVariants',
                'product.unit'
            ])
            ->where('user_id', $user->id)
            ->latest('id')
            ->paginate($perPage);

            return response()->json([
                'status' => true,
                'message' => 'Whitelist items retrieved successfully',
                'data' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function whitelistRemove(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Please login to manage whitelist.'], 401);
            }

            $productId = $request->product_id;
            $whitelistId = $request->whitelist_id ?? $request->id;

            if (!$productId && !$whitelistId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please provide product_id or whitelist_id.'
                ], 422);
            }

            $query = Whishlist::where('user_id', $user->id);
            if ($productId) {
                $query->where('product_id', $productId);
            } else {
                $query->where('id', $whitelistId);
            }

            $deleted = $query->delete();

            if ($deleted) {
                return response()->json([
                    'status' => true,
                    'message' => 'Product removed from whitelist successfully.'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Product was not found in your whitelist.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // ORDER TRACKING API (POST)
    // ==========================================

    public function orderTracking(Request $request)
    {
        try {
            $identifier = $request->invoice_no ?? $request->order_id ?? $request->tracking_code ?? $request->order_number ?? $request->search;

            if (!$identifier) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please provide invoice_no, order_id, or tracking_code.'
                ], 422);
            }

            $steadfast = SteadfastOrder::where('tracking_code', $identifier)
                ->orWhere('consignment_id', $identifier)
                ->first();

            if ($steadfast && $steadfast->order_id) {
                $order = Order::with([
                    'orderDetails.product.category',
                    'orderDetails.variant',
                    'orderDetails.productVariant',
                    'steadfastOrders',
                    'user'
                ])->find($steadfast->order_id);
            } else {
                $order = Order::with([
                    'orderDetails.product.category',
                    'orderDetails.variant',
                    'orderDetails.productVariant',
                    'steadfastOrders',
                    'user'
                ])
                ->where('invoice_no', $identifier)
                ->orWhere('id', $identifier)
                ->first();
            }

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'No order found matching the provided identifier.'
                ], 404);
            }

            $currentStatus = $order->order_status ?? 'Pending';
            $sf = $order->steadfastOrders()->latest()->first();

            $isPlaced = true;
            $isConfirmed = in_array(strtolower($currentStatus), ['processing', 'confirmed', 'shipped', 'delivered', 'completed']);
            $isShipped = in_array(strtolower($currentStatus), ['shipped', 'delivered', 'completed']) || ($sf && in_array(strtolower($sf->delivery_status ?? ''), ['in_transit', 'delivered']));
            $isDelivered = in_array(strtolower($currentStatus), ['delivered', 'completed']) || ($sf && strtolower($sf->delivery_status ?? '') === 'delivered');
            $isCancelled = strtolower($currentStatus) === 'cancelled';

            $timeline = [
                [
                    'step' => 1,
                    'title' => 'Order Placed',
                    'description' => 'Your order has been received.',
                    'completed' => $isPlaced,
                    'current' => !$isConfirmed && !$isCancelled,
                    'timestamp' => $order->date . ' ' . $order->time,
                ],
                [
                    'step' => 2,
                    'title' => 'Order Confirmed',
                    'description' => 'The order is confirmed and being processed.',
                    'completed' => $isConfirmed,
                    'current' => $isConfirmed && !$isShipped && !$isCancelled,
                    'timestamp' => null,
                ],
                [
                    'step' => 3,
                    'title' => 'Shipped / Dispatched',
                    'description' => $sf ? ('Courier: Steadfast, Tracking: ' . ($sf->tracking_code ?? 'N/A')) : 'Item is on the way.',
                    'completed' => $isShipped,
                    'current' => $isShipped && !$isDelivered && !$isCancelled,
                    'timestamp' => null,
                ],
                [
                    'step' => 4,
                    'title' => 'Delivered',
                    'description' => 'Order has been delivered successfully.',
                    'completed' => $isDelivered,
                    'current' => $isDelivered,
                    'timestamp' => null,
                ],
            ];

            if ($isCancelled) {
                $timeline[] = [
                    'step' => 5,
                    'title' => 'Cancelled',
                    'description' => 'Order has been cancelled.',
                    'completed' => true,
                    'current' => true,
                    'timestamp' => null,
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'Order tracking details retrieved successfully',
                'data' => [
                    'order_id' => $order->id,
                    'invoice_no' => $order->invoice_no,
                    'date' => $order->date,
                    'time' => $order->time,
                    'sub_total' => $order->sub_total,
                    'delivery_charge' => $order->delivery_charge,
                    'total' => $order->total,
                    'status' => $currentStatus,
                    'recipient' => [
                        'name' => $order->user_name,
                        'phone' => $order->user_phone,
                        'email' => $order->user_email,
                        'address' => $order->user_address,
                        'city' => $order->user_city,
                        'country' => $order->user_country,
                        'zipcode' => $order->user_zipcode,
                    ],
                    'courier' => $sf ? [
                        'consignment_id' => $sf->consignment_id,
                        'tracking_code' => $sf->tracking_code,
                        'courier_status' => $sf->delivery_status ?? $sf->status,
                    ] : null,
                    'timeline' => $timeline,
                    'items' => $order->orderDetails,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // PRODUCT RATING & REVIEW APIS (POST)
    // ==========================================

    public function addReview(Request $request)
    {
        try {
            $user = $this->resolveUser($request);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Please login to submit a review.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer|exists:products,id',
                'rating'     => 'required|numeric|min:1|max:5',
                'review'     => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $review = ProductReview::updateOrCreate(
                [
                    'user_id'    => $user->id,
                    'product_id' => $request->product_id,
                ],
                [
                    'rating' => round((float)$request->rating, 1),
                    'review' => $request->review,
                    'status' => 'Active',
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Review submitted successfully',
                'data' => $review
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }

    public function productReviews(Request $request)
    {
        try {
            $productId = $request->product_id ?? $request->id;

            if (!$productId) {
                return response()->json(['status' => false, 'message' => 'Product ID is required.'], 422);
            }

            $product = Product::find($productId);
            if (!$product) {
                return response()->json(['status' => false, 'message' => 'Product not found.'], 404);
            }

            $baseQuery = ProductReview::where('product_id', $productId)->where('status', 'Active');

            $totalReviews = (clone $baseQuery)->count();
            $avgRating = (clone $baseQuery)->avg('rating');
            $avgRating = $avgRating ? round((float)$avgRating, 1) : 0.0;

            $breakdown = [
                '5_star' => (clone $baseQuery)->where('rating', '>=', 4.5)->count(),
                '4_star' => (clone $baseQuery)->where('rating', '>=', 3.5)->where('rating', '<', 4.5)->count(),
                '3_star' => (clone $baseQuery)->where('rating', '>=', 2.5)->where('rating', '<', 3.5)->count(),
                '2_star' => (clone $baseQuery)->where('rating', '>=', 1.5)->where('rating', '<', 2.5)->count(),
                '1_star' => (clone $baseQuery)->where('rating', '<', 1.5)->count(),
            ];

            $perPage = (int) ($request->input('per_page') ?? 10);
            $reviews = $baseQuery->with('user:id,name,image')
                ->latest('id')
                ->paginate($perPage);

            return response()->json([
                'status' => true,
                'message' => 'Product reviews retrieved successfully',
                'data' => [
                    'product_id' => (int)$productId,
                    'product_name' => $product->product_name,
                    'average_rating' => $avgRating,
                    'total_reviews' => $totalReviews,
                    'breakdown' => $breakdown,
                    'reviews' => $reviews,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => $e->getCode(), 'message' => $e->getMessage()], 500);
        }
    }
}
