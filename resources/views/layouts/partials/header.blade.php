<header class="main-header clearfix">
    <div class="main-header__top">
        <div class="main-header__top-social-box">
            <div class="container">
                <div class="main-header__top-social-box-inner">
                    <p class="main-header__top-social-text">Welcome to our Cleaning Services!</p>
                    <div class="main-header__top-social">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        <a href="https://www.instagram.com/sarfarazmitrasejahtera?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-header__top-details">
            <div class="container">
                <div class="main-header__top-details-inner">
                    <div class="main-header__logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('assets/images/resources/logo-1.png') }}" alt=""></a>
                    </div>
                    <ul class="list-unstyled main-header__top-details-list">
                        <li>
                            <div class="icon">
                                <span class="icon-message"></span>
                            </div>
                            <div class="text">
                                <h5><a href="mailto:info@example.com">info@example.com</a></h5>
                                <p>Send mail</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="icon-time"></span>
                            </div>
                            <div class="text">
                                <h5>Mon to Sat</h5>
                                <p>08am - 09pm</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="icon-phone-call"></span>
                            </div>
                            <div class="text">
                                <h5>Call Anytime</h5>
                                <p><a href="tel:123456789">123 456 789</a></p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="icon-location"></span>
                            </div>
                            <div class="text">
                                <h5>Ciherang, Dramaga</h5>
                                <p>Bogor, West Java</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-menu clearfix">
        <div class="main-menu__wrapper clearfix">
            <div class="container">
                {{-- Kontainer ini akan kita jadikan flex --}}
                <div class="main-menu__wrapper-inner clearfix">
                    <div class="main-menu__left">
                        <div class="main-menu__main-menu-box">
                            <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                            <ul class="main-menu__list">
                                <li class="{{ Request::routeIs('client.dashboard') ? 'current' : '' }}">
                                    <a href="{{ route('client.dashboard') }}">Home</a>
                                </li>
                                <li class="{{ Request::routeIs('about') ? 'current' : '' }}">
                                    <a href="{{ route('about') }}">About</a>
                                </li>
                                <li class="{{ Request::routeIs('jasa.index') ? 'current' : '' }}">
                                    <a href="{{ route('jasa.index') }}">Services</a>
                                </li>
                                <li class="{{ Request::routeIs('products.index') ? 'current' : '' }}">
                                    <a href="{{ route('products.index') }}">Products</a>
                                </li>
                                <li>
                                    <a href="{{ url('/contact') }}">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- Kontainer ini juga akan kita jadikan flex untuk item di dalamnya --}}
                    <div class="main-menu__right">
                        @auth
                            {{-- 1. CART (muncul pertama saat login) --}}
                            <div class="main-menu__cart">
                                <a href="{{ route('client.cart.index') }}" class="main-menu__cart-btn">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="main-menu__cart-count">{{ $cartCount }}</span>
                                </a>
                            </div>
                        @endauth

                        {{-- 2. SEARCH BOX (selalu ada, atau kedua saat login) --}}
                        <div class="main-menu__search-box">
                            <a href="#" class="main-menu__search search-toggler icon-magnifying-glass"></a>
                        </div>

                        @auth
                            {{-- 3. USER ACCOUNT (muncul ketiga saat login) --}}
                            <div class="main-menu__user-account">
                                <div class="dropdown">
                                    <a href="#" class="main-menu__user-btn dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user-circle"></i>
                                        <span>{{ Auth::user()->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                                @csrf
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            {{-- ATAU LOGIN BUTTON (muncul setelah search jika belum login) --}}
                            <div class="main-menu__login">
                                {{-- Tombol login ini punya style sendiri dari .thm-btn di brote.css --}}
                                {{-- Jika ingin tampilannya sama dengan ikon lain, perlu override lebih banyak atau ganti class --}}
                                <a href="{{ route('login') }}" class="thm-btn main-menu__login-btn">Login</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="stricky-header stricked-menu main-menu">
    <div class="sticky-header__content"></div>
</div>