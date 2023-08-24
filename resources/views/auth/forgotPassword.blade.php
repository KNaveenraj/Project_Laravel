@extends('layouts.default')
@section('title', 'Relaxato - Reset Page')
@section('main-content')


@if($errors->any())
{
    <ul>
        {!! implode('',$errors->all('<li>:message</li>')) !!}
    </ul>
}
@endif
    <body class="body-forgot">
        <form class="forgot" method="POST" action="{{route('forgot.password.post')}}">
            @csrf
            <div class="log-fill"><br /> <br />

            <div class="d-flex justify-content-center align-items-center flex-column">

                @if (Session::has('message'))
                <div class="alert alert-succes" role="alert">
                    {{Session::get('message')}}
                </div>
                @endif

                    <br><br>
                    <h3>Reset</h3>
                    <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="email_address" class="form-label">Email ID</label>
                        <input type="text" id="email_address" class="form-control" name="email" required>
                    </div>

           <button type="submit" class="btn btn-primary">Send Reset Link</button>

           <br>





                </form>

                <br /><br />


            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>





    </body>
@endsection
