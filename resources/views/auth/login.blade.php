@extends('layouts.default')
@section('title', 'Relaxato - Login Page')
@section('main-content')


    <body class="body-login">
        <form class="login" method="POST" action="authenticate">

            <div class="log-fill"><br /> <br />

                <div class="d-flex justify-content-center align-items-center flex-column">

                    <h5>{!! session()->get('error') !!}</h5>
                    <h5>{!! session()->get('Accesserror') !!}</h5>
                    <h5>{!! session()->get('Alert') !!}</h5>
                    <br>

                    <br>
                    <h2>LOGIN</h2>

                    <div class="mb-3">
                        <label class="form-label">Email ID</label>
                        <input type="text" class="form-control" id="email" name="email"
                            class="form-control"  placeholder="* Enter Email">

                        <span class="the-message">{{ $errors->first('email') }}</span>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="* Enter Password">
                            <span class="the-message">{{ $errors->first('password') }}</span>

                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>



                    <div class="forgot">
                        <a href='{{ route('forgot.password.get') }}'>Forgot Password</a>
                    </div>
                    @csrf


        </form>

        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    <footer class="footer_text">
        <p align="center"> Copyrights @Relaxato 2023</p>
    </footer>

    <style>
        .footer_text {
            padding-top: 200px;
        }
    </style>
@endsection
