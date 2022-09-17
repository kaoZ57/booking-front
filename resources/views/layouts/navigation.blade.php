<div class="b-example-divider"></div>

<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ route('home') }}" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="{{ route('booking_view') }}" class="nav-link px-2 text-white">Booking</a></li>
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('item_view') }}" class="nav-link px-2 text-white">Item</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('outOfService_view') }}" class="nav-link px-2 text-white">Service</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('confirm_view') }}" class="nav-link px-2 text-white">Confirm</a></li>
                @endif
                @if (Session::get('staff') == 'true')
                    <li><a href="{{ route('history') }}" class="nav-link px-2 text-white">History</a></li>
                @endif
                @if (Session::get('owner') == 'true')
                    <li><a href="{{ route('dashboard') }}" class="nav-link px-2 text-white">Dashboard</a></li>
                @endif


                {{-- <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                <li><a href="#" class="nav-link px-2 text-white">About</a></li> --}}
            </ul>


            @if (Session::has('token'))
                <a type="button" href="{{ route('order_view') }}" class="btn btn-outline-info me-2">ตะกร้า</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light me-2">Logout</button>
                </form>
            @else
                <div class="text-end">
                    <a type="button" href="{{ route('login_view') }}" class="btn btn-outline-light me-2">Login</a>
                    <a type="button" href="{{ route('register_view') }}" class="btn btn-warning">Sign-up</a>
                </div>
            @endif

        </div>
    </div>
</header>
