<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />

    <!---Bootstrap CSS--->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!---Custom CSS--->
    <link rel="stylesheet" href="public/css/style.css">
</head>



<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark align='center'">
        <a class="navbar-brand" href="{{url('/')}}">RELAXATO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto" >
                <li class="nav-item" ><a class="nav-link" href="{{url('/student')}}" >Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/user')}}">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/logout')}}" >Logout</a></li>
            </ul>

    </div>
    </nav>
    </header>
        @section('title', 'Relaxato - Welcome Page')
        @section('main-content')
            <div class="row text-center">
                <p><h2>Welcome To Relaxato {{Str::ucfirst(auth()->user()->name)}}</h2></p>

            </div>

            <center>
                <h2>Our Teachers</h2>
            </center>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img class="teacher" src="./img/teacher_1.jpg">
                        <p class="txt">A community of lifelong learners, responsible global citizens, and champions of our own success.</p>
                    </div>
                    <div class="col-md-4">
                        <img class="teacher" src="./img/teacher_2.jpg">
                        <p class="txt">A community of lifelong learners, responsible global citizens, and champions of our own success.</p>

                    </div>
                    <div class="col-md-4">
                        <img class="teacher" src="./img/teacher_3.jpg">
                        <p class="txt">A community of lifelong learners, responsible global citizens, and champions of our own success.</p>

                    </div>

                </div>
            </div>

            <center>
                <h2>Courses Offered</h2>
            </center>

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img class="course" src="./img/course_1.jpg">
                        <p class="txts">WEB-DEVELOPMENT</p>
                    </div>
                    <div class="col-md-4">
                        <img class="course" src="./img/course_2.png">
                        <p class="txts">PHP</p>

                    </div>
                    <div class="col-md-4">
                        <img class="course" src="./img/course_3.jpg">
                        <p class="txts ">LARVEL</p>

                    </div>

                </div>
            </div>
    @show

<style>

    .container {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .h3
    {
        color:black;
    }
    .txt {
        text-align: justify;
        font-family: "Times New Roman", Times, serif;
        font-size: large;
    }

    .txts {
        text-align: center;
        font-weight: bold;
        font-family: "Times New Roman", Times, serif;
    }

    .teacher {
        width: 90%;
        height: 350px;
    }

    .course {
        width: 90%;
        height: 350px;
        font-weight: bold;
    }

    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>






