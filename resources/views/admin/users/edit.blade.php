@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Edit User</h1>
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
                            Edit User
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
                    Edit User
                </h3>

            </div>

            <form action="{{ route('users.update',$user->id) }}" method="POST">

                @csrf
                @method('PUT')

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
                                       value="{{ old('name',$user->name) }}"
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
                                       value="{{ old('email',$user->email) }}"
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
                                       value="{{ old('phone',$user->phone) }}"
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

                                    <option value="" disabled>
                                        Select Role
                                    </option>

                                    @foreach(roles() as $role)

                                        <option value="{{ $role->id }}"
                                            {{ old('role_id',$user->role_id) == $role->id ? 'selected' : '' }}>

                                            {{ $role->role_name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="col-md-12">

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-save"></i>

                                Update User

                            </button>

                            <a href="{{ route('users.index') }}" class="btn btn-secondary">

                                Back

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </section>

</div>
@endsection