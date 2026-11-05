<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('back/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('back/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('back/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('back/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('back/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('back/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('back/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('back/plugins/summernote/summernote-bs4.min.css')}}">

  <link rel="stylesheet" href="{{asset('custom/style.css')}}">

  <link rel="stylesheet" href="{{asset('custom/toastr.css')}}">

    <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('back/plugins/select2/css/select2.min.css')}}">

  <link rel="stylesheet" href="{{asset('back/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

     <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('back/datatable/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('back/datatable/css/buttons.dataTables.min.css')}}">
    
    <link rel="stylesheet" type="text/css" href="{{asset('back/datatable/css/responsive.bootstrap4.min.css')}}">


    
    <link rel="stylesheet" href="{{asset('dropify/dist/css/dropify.min.css')}}">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">

      @if(Auth::user()->role_id == 1)
        
        <a href="{{url('/admin/logout')}}" class="btn btn-primary font-weight-bold">LOGOUT</a>
      @else
        <a href="{{url('/vendor/logout')}}" class="btn btn-primary font-weight-bold">LOGOUT</a>
      @endif
       
      </li>


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{URL::to('/dashboard')}}" class="brand-link">
      <img src="{{asset('back/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Ecommerce Solution</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('back/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{URL::to('/dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
            
          </li>

        @if(Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
        @if(optional(auth()->user()->role->adminField)->slider_add == 'Yes' || optional(auth()->user()->role->adminField)->slider_lists == 'Yes')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Sliders
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @if(optional(auth()->user()->role->adminField)->slider_add == 'Yes')
              <li class="nav-item">
                <a href="{{route('sliders.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Slider</p>
                </a>
              </li>
              @endif
              @if(optional(auth()->user()->role->adminField)->slider_lists == 'Yes')
              <li class="nav-item">
                <a href="{{route('sliders.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Slider</p>
                </a>
              </li>
              @endif
             
            </ul>
          </li>
        @endif
        @endif

        @if(Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
        @if(optional(auth()->user()->role->adminField)->category_add == 'Yes' || optional(auth()->user()->role->adminField)->category_lists == 'Yes')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Categories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(optional(auth()->user()->role->adminField)->category_add == 'Yes')
              <li class="nav-item">
                <a href="{{route('categories.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>
              @endif
              @if(optional(auth()->user()->role->adminField)->category_lists == 'Yes')
              <li class="nav-item">
                <a href="{{route('categories.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Category</p>
                </a>
              </li>
             @endif
            </ul>
          </li>
      @endif
      @endif

      @if(Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
        @if(optional(auth()->user()->role->adminField)->subcategory_add == 'Yes' || optional(auth()->user()->role->adminField)->subcategory_lists == 'Yes')

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                SubCategories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(optional(auth()->user()->role->adminField)->subcategory_add == 'Yes')
              <li class="nav-item">
                <a href="{{route('subcategories.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add SubCategory</p>
                </a>
              </li>
            @endif
            @if(optional(auth()->user()->role->adminField)->subcategory_lists == 'Yes')
              <li class="nav-item">
                <a href="{{route('subcategories.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All SubCategory</p>
                </a>
              </li>
            @endif
            </ul>
          </li>
      @endif
     @endif
     
     @if(Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
      @if(optional(auth()->user()->role->adminField)->unit_add == 'Yes' || optional(auth()->user()->role->adminField)->unit_lists == 'Yes')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Units
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(optional(auth()->user()->role->adminField)->unit_add == 'Yes')
              <li class="nav-item">
                <a href="{{route('units.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Unit</p>
                </a>
              </li>
            @endif
            @if(optional(auth()->user()->role->adminField)->unit_lists == 'Yes')
              <li class="nav-item">
                <a href="{{route('units.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Unit</p>
                </a>
              </li>
            @endif
            </ul>
          </li>
      @endif
    @endif

      @if(Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
        @if(optional(auth()->user()->role->adminField)->variant_add == 'Yes' || optional(auth()->user()->role->adminField)->variant_lists == 'Yes')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Variants
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(optional(auth()->user()->role->adminField)->variant_add == 'Yes')
              <li class="nav-item">
                <a href="{{route('variants.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Variant</p>
                </a>
              </li>
            @endif
            @if(optional(auth()->user()->role->adminField)->variant_lists == 'Yes')
              <li class="nav-item">
                <a href="{{route('variants.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Variant</p>
                </a>
              </li>
            @endif
            </ul>
          </li>
      @endif
     @endif


     @if(Auth::user()->role_id != 2 || Auth::user()->role_id != 3)
      @if(optional(auth()->user()->role->adminField)->vendor_lists == 'Yes' || optional(auth()->user()->role->adminField)->vendor_product_lists == 'Yes' || optional(auth()->user()->role->adminField)->vendor_edit_requests == 'Yes')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Vendors
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(optional(auth()->user()->role->adminField)->vendor_lists == 'Yes')
              <li class="nav-item">
                <a href="{{url('/vendor-lists')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Vendors</p>
                </a>
              </li>
            @endif

            @if(optional(auth()->user()->role->adminField)->vendor_product_lists == 'Yes')

              <li class="nav-item">
                <a href="{{url('/vendor-products')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor Products</p>
                </a>
              </li>
            @endif

            @if(optional(auth()->user()->role->adminField)->vendor_edit_requests == 'Yes')

              <li class="nav-item">
                <a href="{{url('/vendor-edit-requests')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor Edit Requests</p>
                </a>
              </li>

            @endif
             
            </ul>
          </li>
      @endif

     @endif

     @if(Auth::user()->id == 1)
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Roles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/add-role')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Role</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/role-lists')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Role</p>
                </a>
              </li>
             
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('users.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add user</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('users.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All user</p>
                </a>
              </li>
             
            </ul>
          </li>

        @endif


      @if(Auth::user()->role_id == 2)


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('products.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('products.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Product</p>
                </a>
              </li>
             
            </ul>
          </li>

      @endif



      @if(Auth::user()->role_id == 2)


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Orders
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/my-orders')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>My Orders</p>
                </a>
              </li>
             
            </ul>
          </li>

      @endif

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(Auth::user()->role_id == 1)
              <li class="nav-item">
                <a href="{{url('currency-settings')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Currency Settings</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('commission-settings')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Commission Rate</p>
                </a>
              </li>

            @endif


            @if(Auth::user()->role_id == 2)
              <li class="nav-item">
                <a href="{{url('/venodor-profile-settings')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>My Profile Settings</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/set-delivery-charge')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Set Delivery Charge</p>
                </a>
              </li>

            @endif

            <li class="nav-item">
                <a href="{{url('/change-password')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
             
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

   @yield('content')


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('custom/custom_js.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('back/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('back/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<script src="{{asset('custom/custom.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('back/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('back/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('back/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('back/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('back/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('back/dist/js/adminlte.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('back/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- data-table js -->
<script src="{{asset('back/datatable/js/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('back/datatable/js/dataTables.buttons.min.js')}}"></script>



<script src="{{asset('back/datatable/js/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('back/datatable/js/dataTables.responsive.min.js')}}"></script>

<script src="{{asset('back/datatable/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('back/datatable/js/data-table-custom.js')}}"></script>

<script src="{{asset('dropify/dist/js/dropify.min.js')}}"></script>



<script>
  $(function () {
    $('#summernote').summernote();

    var base_url = "{{url('/')}}";
    localStorage.setItem('base_url', base_url);
 
  })
</script>

<script src="{{asset('custom/toastr.js')}}"></script>
 
  @if(Session::has('messege'))
    @toastr("{{ Session::get('messege') }}")
  @endif
  
  @stack('scripts')

</body>
</html>
