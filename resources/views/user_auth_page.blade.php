@extends('cart_details') 

@section('cart_content')

<main class="main login-page">

    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Authentication</li>
            </ul>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">

            <div class="row">

                <!-- ===========================
                    SIGN IN
                ============================ -->

                <div class="col-lg-6 mb-5">

                    <div class="card">

                        <div class="card-header bg-primary text-white">

                            <h4 class="mb-0">
                                Sign In
                            </h4>

                        </div>

                        <div class="card-body">

                            <form id="signinUser">

                                <div class="form-group">

                                    <label>
                                        Phone or Email Address
                                    </label>

                                    <input type="text"
                                           class="form-control signin_login"
                                           name="login"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>
                                        Password
                                    </label>

                                    <input type="password"
                                           class="form-control signin_password"
                                           name="password"
                                           required>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <div class="custom-control custom-checkbox">

                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="remember"
                                               name="remember">

                                        <label class="custom-control-label"
                                               for="remember">

                                            Remember Me

                                        </label>

                                    </div>

                                    <a href="#" class="d-none">
                                        Forgot Password?
                                    </a>

                                </div>

                                <button type="submit"
                                        class="btn btn-primary btn-block">

                                    Sign In

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

                <!-- ===========================
                    SIGN UP
                ============================ -->

                <div class="col-lg-6 mb-5">

                    <div class="card">

                        <div class="card-header bg-success text-white">

                            <h4 class="mb-0">

                                Create Account

                            </h4>

                        </div>

                        <div class="card-body">

                            <form  id="signupUser">

                               

                                <div class="form-group">

                                    <label>

                                        Full Name

                                    </label>

                                    <input type="text"
                                           class="form-control signup-name"
                                           name="name"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>

                                        Phone Number

                                    </label>

                                    <input type="text"
                                           class="form-control signup-phone"
                                           name="phone"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>

                                        Email Address

                                    </label>

                                    <input type="email"
                                           class="form-control signup-email"
                                           name="email">

                                </div>

                                <div class="form-group">

                                    <label>

                                        Password

                                    </label>

                                    <input type="password"
                                           class="form-control signup-password"
                                           name="password"
                                           required>

                                </div>

                                <div class="form-group">

                                    <label>

                                        Confirm Password

                                    </label>

                                    <input type="password"
                                           class="form-control signup-confirm-password"
                                           name="confirm_password"
                                           required>

                                </div>

                                <button type="submit"
                                        class="btn btn-success btn-block">

                                    Create Account

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</main>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
  	  $(document).on('submit','#signupUser',function(e){

            e.preventDefault();

            let name = $('.signup-name').val();
            let phone = $('.signup-phone').val();
            let email = $('.signup-email').val();
            let password = $('.signup-password').val();
            let confirm_password = $('.signup-confirm-password').val();

            $.ajax({
                url: "{{ url('/user-signup') }}",
                type: "POST",
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    password: password,
                    confirm_password: confirm_password,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    if(!data.status){
                        alert(data.message);
                    }else{
                        alert(data.message);
                        let redirectURL = "{{url('/')}}";
                        window.location.href=redirectURL;
                    }
                    
                    // toastr.success(data.message);
                    // $('.data-table').DataTable().ajax.reload(null, false);
                }
            });




        });

  	  $(document).on('submit','#signinUser',function(e){

            e.preventDefault();

            let login = $('.signin_login').val();
            let password = $('.signin_password').val();

            $.ajax({
                url: "{{ url('/user-signin') }}",
                type: "POST",
                data: {
                     login: login,
                     password: password,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    if(!data.status){
                        alert(data.message);
                    }else{
                        alert(data.message);
                        let redirectURL = "{{url('/')}}";
                        window.location.href=redirectURL;
                    }
                    
                    // toastr.success(data.message);
                    // $('.data-table').DataTable().ajax.reload(null, false);
                }
            });




        });
  });	
</script> 