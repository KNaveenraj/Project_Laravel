@extends('layouts.default_1')
@section('title', 'Relaxato - Register Page')
@section('main-content')
@if($errors->any())
{
    <ul>
        {!! implode('',$errors->all('<li>:message</li>')) !!}
    </ul>
}
@endif


@if (\Session::has('message'))
    <div class="alert alert-success">

         <p> {!! \Session::get('message') !!}</p>

    </div>
@endif
    <body class="body-register">
        <form action="store" method="post" enctype="multipart/form-data">
            <div class="reg-fill">

                <div class="d-flex justify-content-center align-items-center flex-column">

                    <div class="text-center">
                        <img src="" width="100">
                    </div>
                    <br><br>
                    <h3>REGISTER</h3>
                    <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email ID</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>

                 {{-- <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Avatar</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>

                    @csrf

                    <br /><br />


                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>




        </form>
    </body>

@endsection
