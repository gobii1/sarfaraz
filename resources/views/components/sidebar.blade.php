<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>

    <!-- Logo -->
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/safaraz/logosarfaraz.jpg') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/safaraz/logosarfaraz.jpg') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/safaraz/logosarfaraz.jpg') }}" alt="site logo" class="logo-icon">
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">

            <!-- Dashboard -->
            <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Products -->
            <li class="{{ Request::routeIs('admin.products.index*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}">
                    <iconify-icon icon="ri:shopping-bag-3-line" class="menu-icon"></iconify-icon>
                    <span>Products</span>
                </a>
            </li>

            <!-- Jasa -->
            <li class="{{ Request::routeIs('jasa.*') || (Request::routeIs('admin.jasa.index') && request('category') == 'JASA') ? 'active' : '' }}">
                <a href="{{ route('admin.jasa.index') }}">
                    <iconify-icon icon="fluent:people-community-28-filled" class="menu-icon"></iconify-icon>
                    <span>Jasa</span>
                </a>
            </li>

            <!-- Categories -->
            <li class="{{ Request::routeIs('categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}">
                    <iconify-icon icon="mdi:category" class="menu-icon"></iconify-icon>
                    <span>Categories</span>
                </a>
            </li>

            <!-- Orders -->
            <li class="{{ Request::routeIs('orders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}">
                    <iconify-icon icon="mdi:cart" class="menu-icon"></iconify-icon>
                    <span>Orders</span>
                </a>
            </li>

            <!-- Inbox -->
            <li class="{{ request()->routeIs('admin.inquiries.index') ? 'active' : '' }}">
                <a href="{{ route('admin.inquiries.index') }}">
                    <iconify-icon icon="ri:inbox-line" class="menu-icon"></iconify-icon>
                    <span>Inbox</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="menu-item {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
    <a href="{{ route('admin.profile.edit') }}">
        <iconify-icon icon="iconamoon:profile-circle-fill" class="menu-icon"></iconify-icon>
        <span class="menu-text">Profile</span>
    </a>
</li>

            <!-- Site Settings -->
            {{-- <li>
                <a href="#">
                    <iconify-icon icon="uil:setting" class="menu-icon"></iconify-icon>
                    <span>Site Settings</span>
                </a>
            </li> --}}

            <!-- Logout -->
            <li>
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
