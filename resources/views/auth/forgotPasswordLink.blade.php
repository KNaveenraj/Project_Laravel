@extends('layouts.default')
@section('title', 'Relaxato - Register Page')
@section('main-content')
@if($errors->any())
{
    <ul>
        {!! implode('',$errors->all('<li>:message</li>')) !!}
    </ul>
}

@endif
    <body class="body-register">
        <form action="{{route('reset.password.post')}}" method="post">
            <input type="hidden" name="token" value="{{$token}}">
            <div class="reg-fill"><br /> <br />

                <div class="d-flex justify-content-center align-items-center flex-column">


                    <div class="text-center">
                        <img src="" width="100">
                    </div>
                    <br><br>
                    <h3>Reset Password</h3>
                    <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label class="form-label">Email ID</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Reset Password</button>

                    @csrf

                    <br /><br />


                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>


            <!-- Login buttons -->
            <div class="text-center">
                <p>Already a member? <a href="{{ url('/login') }}">Login</a></p>
            </div>



        </form>
    </body>

@endsection
