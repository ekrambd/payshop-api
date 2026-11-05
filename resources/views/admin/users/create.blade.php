@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Add User</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('users.index') }}">All Users</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Add User
                        </li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->

    <section class="content">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    Add User
                </h3>

            </div>

            <form action="{{ route('users.store') }}" method="POST">

                @csrf

                <div class="card-body">

                    <div class="row">

                        {{-- Name --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Name <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name') }}"
                                       placeholder="Enter Name"
                                       required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Email --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Email <span class="text-danger">*</span>
                                </label>

                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       placeholder="Enter Email"
                                       required>

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Phone --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Phone <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone') }}"
                                       placeholder="Enter Phone Number"
                                       required>

                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Role --}}

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Select Role <span class="text-danger">*</span>
                                </label>

                                <select name="role_id"
                                        class="form-control select2bs4"
                                        required>

                                    <option value="" selected="" disabled="">
                                        Select Role
                                    </option>

                                    @foreach(roles() as $role)

                                        <option value="{{ $role->id }}">

                                            {{ $role->role_name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Submit Button --}}

                        <div class="col-md-12">

                            <button class="btn btn-primary">

                                <i class="fas fa-save"></i>

                                Save User

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </section>

</div>
@endsection