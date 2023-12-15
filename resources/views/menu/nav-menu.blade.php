@php
    use Illuminate\Support\Facades\Auth;
    $accountName = Auth::user()->user;
@endphp

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="me-0" href="{{ route('stock') }}"><img src="{{ asset('goucargo.png') }}" style="max-width: 300px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 ps-5">
                <li class="nav-item ps-10">
                    <a class="nav-link text-center" href="{{ route('stock') }}">STOCK</a>
                </li>
                <li class="nav-item ps-5">
                    <a class="nav-link text-center" href="{{ route('create-order') }}">CREATE ORDER</a>
                </li>
                <li class="nav-item ps-5">
                    <a class="nav-link text-center" href="{{ route('order-status') }}">ORDER STATUS</a>
                </li>
                @if (auth()->user()->rol == 1)
                    <li class="nav-item ps-5">
                        <a class="nav-link text-center" href="{{ route('templates') }}">TEMPLATES</a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="nav-link text-center" href="{{ route('register') }}">REGISTER USER</a>
                    </li>
                @endif
                @if (!empty($accountName))
                    <div class="ps-10">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="text-white pe-1 text-uppercase">{{ $accountName }}</span>
                                <i class="bi bi-person-circle text-white"></i>
                            </a>
                            <ul class="dropdown-menu text-center">
                                <li><a class="dropdown-item" href="{{ route('logout') }}">EXIT</a></li>
                            </ul>
                        </li>
                    </div>
                @endif
            </ul>
        </div>
    </div>
</nav>
