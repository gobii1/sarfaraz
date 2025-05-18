<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>

    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>

    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <!-- Dashboard Section -->
            <li class="dropdown {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Products Section -->
            <li class="dropdown {{ Request::routeIs('admin.products.index*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}">
                    <iconify-icon icon="ri:shopping-bag-3-line" class="menu-icon"></iconify-icon>
                    <span>Products</span>
                </a>
                {{-- <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('products.index') && !request()->has('category') ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}">All Products</a>
                    </li>
                    <li class="{{ Request::routeIs('admin.products.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.create') }}">Add New Product</a>
                    </li>
                </ul> --}}
            </li>

            <!-- Jasa Section -->
            <li class="dropdown {{ Request::routeIs('jasa.*') || (Request::routeIs('admin.jasa.index') && request('category') == 'JASA') ? 'active' : '' }}">
                <a href="{{ route('admin.jasa.index') }}">
                    <iconify-icon icon="fluent:people-community-28-filled" class="menu-icon"></iconify-icon>
                    <span>Jasa</span>
                </a>
                {{-- <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.jasa.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.jasa.index') }}">All Services</a>
                    </li>
                    <li class="{{ Request::routeIs('admin.jasa.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.jasa.create') }}">Add New Service</a>
                    </li>
                </ul> --}}
            </li>

            <!-- Categories Section -->
            <li class="dropdown {{ Request::routeIs('categories.*') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}">
                    <iconify-icon icon="mdi:category" class="menu-icon"></iconify-icon>
                    <span>Categories</span>
                </a>
            </li>

            <!-- Orders Section -->
            <li class="dropdown {{ Request::routeIs('orders.*') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}">
                    <iconify-icon icon="mdi:cart" class="menu-icon"></iconify-icon>
                    <span>Orders</span>
                </a>
            </li>

            <!-- Settings Section -->
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle">
                    <iconify-icon icon="uil:setting" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('profile.edit') }}">Profile</a>
                    </li>
                    <li>
                        <a href="#">Site Settings</a>
                    </li>
                </ul>
            </li>

            <!-- Logout Section -->
            <li class="dropdown">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" style="background: none; border: none; width: 100%; text-align: left; padding: 10px 20px; display: flex; align-items: center;">
                        <iconify-icon icon="carbon:logout" class="menu-icon" style="margin-right: 10px;"></iconify-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
