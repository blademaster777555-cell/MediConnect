<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->role === 1) <!-- Admin -->
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('Quản lý User') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.appointments')" :active="request()->routeIs('admin.appointments*')">
                                {{ __('Lịch hẹn') }}
                            </x-nav-link>
                        @elseif(Auth::user()->role === 2) <!-- Doctor -->
                            <x-nav-link :href="route('doctor.appointments')" :active="request()->routeIs('doctor.appointments')">
                                {{ __('Quản lý lịch hẹn') }}
                            </x-nav-link>
                        @else <!-- Patient -->
                            <x-nav-link :href="route('doctors.index')" :active="request()->routeIs('doctors.*')">
                                {{ __('Tìm bác sĩ') }}
                            </x-nav-link>
                            <x-nav-link :href="route('my.appointments')" :active="request()->routeIs('my.appointments')">
                                {{ __('Lịch hẹn của tôi') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
    @auth
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <!-- Common links for all roles -->
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Hồ sơ cá nhân') }}
                </x-dropdown-link>

                <!-- Role-specific links -->
                @if(Auth::user()->role === 1) <!-- Admin -->
                    <div class="border-t border-gray-100"></div>
                    <x-dropdown-link :href="route('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.users.index')">
                        {{ __('Quản lý người dùng') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('admin.appointments')">
                        {{ __('Tất cả lịch hẹn') }}
                    </x-dropdown-link>
                @elseif(Auth::user()->role === 2) <!-- Doctor -->
                    <div class="border-t border-gray-100"></div>
                    <x-dropdown-link :href="route('doctor.dashboard')">
                        {{ __('Dashboard bác sĩ') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('doctor.appointments')">
                        {{ __('Quản lý lịch hẹn') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('doctor.schedule')">
                        {{ __('Quản lý lịch rảnh') }}
                    </x-dropdown-link>
                @else <!-- Patient -->
                    <div class="border-t border-gray-100"></div>
                    <x-dropdown-link :href="route('doctors.index')">
                        {{ __('Tìm bác sĩ') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('my.appointments')">
                        {{ __('Lịch hẹn của tôi') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('news')">
                        {{ __('Tin tức y tế') }}
                    </x-dropdown-link>
                @endif

                <div class="border-t border-gray-100"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Đăng xuất') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    @else
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Đăng nhập</a>
            <a href="{{ route('register') }}" class="text-sm text-gray-700 underline">Đăng ký</a>
        </div>
    @endauth
</div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
    @auth
        <div class="px-4">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    @else
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('login')">
                Đăng nhập
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">
                Đăng ký
            </x-responsive-nav-link>
        </div>
    @endauth
</div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
