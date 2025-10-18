    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #196f38; position: fixed; width: 100%; z-index: 1000; top: 0; opacity: 1;">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <a href="{{ route('landingpageuser') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                    </a>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="{{route('landingpagerecipient')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('show_request')}}">Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('gallerypagerecipient')}}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('aboutuspagerecipient')}}">About Us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-flex align-items-center">
                                  <div class="dropdown">
    @if (Auth::check() && $auth->image)
        <img src="{{ asset('storage/' . $auth->image) }}" alt="Authenticated Logo"
             style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
             id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    @else
        <img src="{{ asset('assets/logo.jpg') }}" alt="Authenticated Logo"
             style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
             id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    @endif
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            @if(Auth::user()->role == 'donor')
                <a class="dropdown-item" href="{{ route('donordashboard') }}">Donor Dashboard</a>
            @elseif(Auth::user()->role == 'recipient')
                <a class="dropdown-item" href="{{ route('recipientdashboard') }}">Recipient Dashboard</a>
            @else
                <a class="dropdown-item" href="{{ route('donordashboard') }}">Dashboard</a>
            @endif
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="dropdown-item" style="background-color: red; color: white; width: 100%; text-align: left; border: none;">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
            </div>
        </nav>
    </header>
