@extends('admin_master')
@section('content')
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
    	<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Password Change</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('password-change')}}" method="POST">
              	@csrf
                <div class="card-body">
                  
                  <div class="form-group">
                  	<label for="current_password">Current Password</label>
                  	<input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" required=""> 
                  	@error('current_password')
		            <span class="alert alert-danger">{{ $message }}</span>
                   @enderror
                  </div>

                  <div class="form-group">
                  	<label for="new_password">New Password</label>
                  	<input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required="">
                  	@error('new_password')
		            <span class="alert alert-danger">{{ $message }}</span>
                   @enderror
                  </div>

                  <div class="form-group">
                  	<label for="confirm_password">Confirm Password</label>
                  	<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required="">

                  	@error('confirm_password')
		            <span class="alert alert-danger">{{ $message }}</span>
                   @enderror
                   
                  </div>

                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Password Change</button>
                </div>
              </form>
            </div>
    </section>
 </div>
@endsection