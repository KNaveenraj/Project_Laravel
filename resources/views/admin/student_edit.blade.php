<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | General Form Elements</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/admin" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
               <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->

         <a class="btn btn-primary " href="{{url('/logout')}}" >Logout</a>

      </ul>
        </nav>
        <!-- /.navbar -->



        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/admin" class="brand-link">
                <img src="../../dist/img/logo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin Dashboard</span>
            </a>



            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/uploads/{{auth()->user()->image}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="/admin" class="d-block">{{StrtoUpper(auth()->user()->name)}}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('/register')}}" >Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/users') }}">Users</a></li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Form</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Edit Form</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>



            @if (\Session::has('errors'))
            <div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show">
            <div class="alert alert-success">
             <strong> {{session('errors')->first('error')}}</strong>
            </div>
            </div>
        @endif



        @if (\Session::has('success'))
        <div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show">
            <div class="alert alert-success">
                <p> {!! \Session::get('success') !!}</p>
           </div>
        </div>
        @endif
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">

                            <!-- general form elements -->
                            <div class="card card-primary">

                                <div class="card-body">
                                    <form action="{{ route('student.update', $student->id) }}" method="post">

                                        @csrf


                                        <div class="form-group">
                                            <label for="exampleInputRounded0">Name</label>

                                            <input type="text" name="name" id="name"
                                                class="form-control" {{ $errors->has('name') ? 'is-invalid' : '' }}
                                                value="{{ $student->name }}" required>

                                                <span class="the-message"><strong>{{ $errors->first('name') }}</strong></span>

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputRounded0">Email address</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control" {{ $errors->has('email') ? 'is-invalid' : '' }}
                                                value="{{ $student->email }}" required>

                                                <span class="the-message"><strong>{{ $errors->first('email') }}</strong></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputRounded0">Phone number</label>
                                            <input type="text" name="phone" id="phone"
                                                class="form-control" {{ $errors->has('phone') ? 'is-invalid' : '' }}
                                                value="{{ $student->phone }}" oninput="numberOnly(this.id);"  pattern="[0-9.]+" minlenght="10" maxlength="10" required>

                                                <span class="the-message"><strong>{{ $errors->first('phone') }}</strong></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputRounded0">Address</label>
                                            <input type="text" name="address" id="address"
                                                class="form-control" {{ $errors->has('address') ? 'is-invalid' : '' }}
                                                value="{{ $student->address }}" >

                                                <span class="the-message"><strong>{{ $errors->first('address') }}</strong></span>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputRounded0">Avatar</label>
                                            <img  src="/uploads/{{ $student->image }}"style="width:80px;margin-top: 10px;">
                                        </div>



                                        <div class="form-group has-validation">
                                            <label for="isAdmin">Role</label>
                                            <select class="custom-select form-select" id="isAdmin" name="isAdmin"
                                                id="isAdmin" {{ $errors->has('isAdmin') ? 'is-invalid' : '' }}"
                                                value="{{ $student->isAdmin }}">
                                                @foreach ($role as $role)
                                                    @if ($student->isAdmin == $role->id)
                                                        <option selected disabled>Current Role : {{ $role->role_type }}
                                                        </option>
                                                    @endif
                                                @endforeach

                                                <option value="1">1 - Admin</option>
                                                <option value="2">2 - Agent</option>
                                                <option value="3">3 - Student</option>
                                            </select>

                                            <span class="the-message"><strong>{{ $errors->first('isAdmin') }}</strong></span>
                                        </div>


                                        <div class="form-group has-validation">
                                            <label for="set_viewable">Enabled or Disabled</label>
                                            <select class="custom-select form-select" id="set_viewable" name="set_viewable"
                                                {{ $errors->has('set_viewable') ? 'is-invalid' : '' }}">
                                                @if ($student->set_viewable == 0)
                                                    {{ $view = 'Not Enabled' }}
                                                @endif
                                                @if ($student->set_viewable == 1)
                                                    {{ $view = 'Enabled' }}
                                                @endif

                                                <option selected disabled>{{ $view }}</option>
                                                <option value="0">0 - Not Enabled</option>
                                                <option value="1">1 - Enabled</option>

                                            </select>

                                            <span class="the-message"><strong>{{ $errors->first('set_viewable') }}</strong></span>
                                        </div>

                                        <div class="card">
                                            <button type="submit" class="btn btn-primary">Submit</button>

                                        </div>
                                        <div align="right">

                                            <a class="btn btn-primary " href="{{url('/users')}}">Back</a>
                                            </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
            </section>
        </div>


    </div>


    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2023.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>
