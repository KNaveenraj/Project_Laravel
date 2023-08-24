<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark align='center'">
        <a class="navbar-brand" href="{{url('/')}}">RELAXATO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto"  >
            <li class="nav-item" ><a class="nav-link" href="{{url('/welcome')}}" >Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('/register')}}">Add User</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('/students')}}" >Users</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('/logout')}}">Logout</a></li>
        </ul>

        </div>
    </nav>
</header>
