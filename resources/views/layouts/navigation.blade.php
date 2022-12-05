<div class="b-example-divider"></div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <a class="navbar-brand me-2" href="{{ route('home') }}">
                <img src="{{ asset('img/logo_RMUTI_Kaesad_Flower_2556_RGB.webp') }}" height="40" alt="booking Logo"
                    loading="lazy" style="margin-top: -1px;" />
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ route('home') }}" class="nav-link px-2 text-black-50">Home</a></li>
                @if (Session::has('token'))
                    <li><a href="{{ route('booking_view') }}" class="nav-link px-2 text-black-50">Booking</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('item_view') }}" class="nav-link px-2 text-black-50">Item</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('outOfService_view') }}" class="nav-link px-2 text-black-50">Service</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('confirm_view') }}" class="nav-link px-2 text-black-50">Confirm</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('history') }}" class="nav-link px-2 text-black-50">History</a></li>
                @endif
                @if (Session::get('owner') == 'true')
                    <li><a href="{{ route('dashboard') }}" class="nav-link px-2 text-black-50">Dashboard</a></li>
                @endif


                {{-- <li><a href="#" class="nav-link px-2 text-black-50">Pricing</a></li>
                <li><a href="#" class="nav-link px-2 text-black-50">FAQs</a></li>
                <li><a href="#" class="nav-link px-2 text-black-50">About</a></li> --}}
            </ul>

            <div class="d-flex align-items-center">
                @if (Session::has('token'))
                    <a type="button" href="{{ route('order_view') }}" class="btn btn-outline-info me-2">รายการจอง</a>
                    {{-- <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link px-3 me-2">Logout</button>
                    </form> --}}
                @else
                    <a class="btn" href="{{ route('redirect') }}" role="button" style="text-transform:none">
                        <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in"
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                        Login with Google
                    </a>
                    &nbsp;&nbsp;
                    <a type="button" href="{{ route('login_view') }}" class="btn btn-link px-3 me-2">Owner
                        Login</a>
                    {{-- <a type="button" href="{{ route('register_view') }}" class="btn btn-warning">Sign-up</a> --}}
                @endif


                @if (Session::has('name'))
                    <!-- Collapsible wrapper -->
                    <div class="collapse navbar-collapse" id="navbarRightAlignExample">
                        <!-- Left links -->
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <!-- Navbar dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-mdb-toggle="dropdown" aria-expanded="false">
                                    {{ Session::get('name') }}
                                </a>
                                <!-- Dropdown menu -->
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item ">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
        </div>
</nav>
