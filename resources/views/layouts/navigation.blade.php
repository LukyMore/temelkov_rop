<script src="{{ asset('storage/test.js') }}"></script>
<nav x-data="{ open: false }" class="bg-white dark:bg-black border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('posts') }}">
                        <i class="fa-solid fa-comments fa-2x dark:text-white"></i>
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex dark:text-white">
                    <x-nav-link :href="route('posts')" :active="request()->routeIs('posts')">
                        {{ __('Příspěvky') }}
                    </x-nav-link>
                    <x-nav-link :href="route('create')" :active="request()->routeIs('create')">
                        {{ __('Vytvořit příspěvek') }}
                    </x-nav-link>
                    <x-nav-link :href="route('createGroup')" :active="request()->routeIs('createGroup')">
                        {{ __('Vytvořit skupinu') }}
                    </x-nav-link>
                    <x-nav-link :href="route('groups')" :active="request()->routeIs('groups')">
                        {{ __('Skupiny') }}
                    </x-nav-link>
                </div>
            </div>
            <div class="justify-between flex">
                <form method="post" class="inline my-auto" action="{{ route('dark-mode-switch') }}">
                    @csrf
                    <input type="hidden" name="lol" value="{{ Session::get('darkMode') }}">
                    <button type="submit" class="btn-dark dark-mode-toggle" id="idk">
                        {{ Session::get('darkMode') === 'dark' ? 'Light Mode' : 'Dark Mode' }}
                    </button>
                </form>
                <!-- Settings Dropdown -->
                @if (empty(Auth::user()->avatar))
                    <?php $avatarUrl = asset('storage/1.jpg'); ?>
                @else
                    <?php $avatarUrl = Storage::url(Auth::user()->avatar); ?>
                @endif
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 dark:bg-black dark:text-white">
                                <div>
                                    <img src="{{ $avatarUrl }}"
                                        class="inline object-cover rounded-full w-7 h-7 mr-0.5 mb-0.5 dark:border-pink-500 dark:border-2">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('user.profile', ['id' => Auth::user()->id])">
                                <i class="fa-solid fa-user mr-1"></i>
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fa-solid fa-gear mr-1"></i>
                                {{ __('Nastavení') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i>
                                {{ __('Odhlásit se') }}
                            </x-dropdown-link>
                        </form> 
                    </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
