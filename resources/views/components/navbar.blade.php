<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                {{-- <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button> --}}

                {{-- Dropdown Bahasa (opsional, bisa Anda fungsikan nanti) --}}
                {{-- <div class="dropdown d-none d-sm-inline-block">
                    <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/images/lang-flag.png') }}" alt="image" class="w-24 h-24 object-fit-cover rounded-circle">
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-sm">
                        {{-- Konten pilihan bahasa --}}
                    {{-- </div>
                </div> --}}

                {{-- Tombol Notifikasi Real-time --}}
                <div class="dropdown">
                    <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
                        <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
                        {{-- Badge untuk counter notifikasi --}}
                        <span id="notification-counter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">0</span>
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                        <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
                        </div>
                        {{-- Wadah untuk daftar notifikasi --}}
                        <div id="notification-list" class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                            <p class="text-center text-muted p-3">Tidak ada notifikasi baru.</p>
                        </div>
                        <div class="text-center py-12 px-16">
                            <a href="{{ route('admin.orders.index') }}" class="text-primary-600 fw-semibold text-md">Lihat Semua Pesanan</a>
                        </div>
                    </div>
                </div>

                {{-- Nama pengguna sebagai pemicu dropdown profil --}}
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-sm">
                        <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-2">{{ Auth::user()->name }}</h6>
                                <span class="text-secondary-light fw-medium text-sm text-capitalize">{{ Auth::user()->role }}</span>
                            </div>
                        </div>
                        <ul class="to-top-list">
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="{{ route('profile.edit') }}">
                                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="#">
                                    <iconify-icon icon="icon-park-outline:setting-two" class="icon text-xl"></iconify-icon> Setting
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div></div>
        </div>
    </div>
</div>