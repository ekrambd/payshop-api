<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest; 
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth_check');
    } 

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $ids = [1,2,3];

            $users = User::whereNotIn('role_id',$ids)->latest()->get();

            return DataTables::of($users)
                ->addIndexColumn()

                ->addColumn('role', function ($row) {

                    return $row->role->role_name;
                })

                ->addColumn('action', function ($row) {

                    return '
                    <a href="' . route('users.show', $row->id) . '" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete-user">
                        <i class="fa fa-trash"></i>
                    </a>
                    ';
                })

                ->rawColumns(['action','role'])
                ->make(true);
        }

        return view('admin.users.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try
        {
            $user = new User();
            $user->role_id = $request->role_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt('123456');
            $user->save();
            $notification=array(
                'messege'=>"Successfully an user has been added",
                'alert-type'=>"success",
            );

            return redirect()->back()->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->update();
            $notification=array(
                'messege'=>"Successfully an user has been added",
                'alert-type'=>"success",
            );

            return redirect('/users')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try
        {
            $user->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully the user has been deleted']);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
