@php
    $user = Auth::user();
@endphp

<nav x-data="{ open: false }" class="rounded-t-lg bg-blue-600">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" title="Dashboard">
                        <img src="/pineapple-logo-vertical-2.png" alt="logo" class="rounded-full"
                            style="height: 50px;">
                    </a>
                </div>
                @if ($user->admin == 1)
                    <div class="align-middle text-sm">
                        <p class="ml-2 mr-1 align-middle text-white">Admin</p>
                    </div>
                @endif




                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                </div> --}}

            </div>

            <div class="flex items-center">
                <x-search-bar></x-search-bar>
            </div>
            <div class="hidden sm:flex sm:items-center">
                <!-- Teams Dropdown -->
                {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="relative ml-3">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif --}}


                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->preferred_name ? Auth::user()->preferred_name : Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:text-gray-700 focus:outline-none">
                                        {{ Auth::user()->preferred_name ? Auth::user()->preferred_name : Auth::user()->name }}

                                        <svg class="-mr-0.5 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->


                            <x-jet-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Dashboard') }}
                            </x-jet-dropdown-link>

                            @if ($user->admin == 1)
                                <x-jet-dropdown-link href="{{ route('therapists.index') }}">
                                    {{ __('Therapists') }}
                                </x-jet-dropdown-link>
                                
                                <x-jet-dropdown-link href="{{ route('admin.stats') }}">
                                    {{ __('Statistics') }}
                                </x-jet-dropdown-link>
                                
                                <x-jet-dropdown-link href="{{ route('admin.email-therapists') }}">
                                    {{ __('Email Therapists') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="{{ route('admin.broadcast-message') }}">
                                    {{ __('Broadcast Message') }}
                                </x-jet-dropdown-link>
                            @endif


                            <x-jet-dropdown-link href="{{ route('clients.index') }}">
                                {{ __('Clients') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('session.index') }}">
                                {{ __('Sessions') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="/messages">
                                {{ __('Messages') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>



            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
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
        <div class="space-y-1 pb-3 pt-2">
            {{-- <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link> --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="mr-3 shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="text-base font-medium text-gray-50">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-50">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-jet-responsive-nav-link>

                @if ($user->admin == 1)
                    <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('therapists.index') }}"
                        :active="request()->routeIs('therapists.index')">
                        {{ __('Therapists') }}
                    </x-jet-responsive-nav-link>
                    
                    <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('admin.stats') }}"
                        :active="request()->routeIs('admin.stats')">
                        {{ __('Statistics') }}
                    </x-jet-responsive-nav-link>
                    
                    <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('admin.email-therapists') }}"
                        :active="request()->routeIs('admin.email-therapists')">
                        {{ __('Email Therapists') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('admin.broadcast-message') }}"
                        :active="request()->routeIs('admin.broadcast-message')">
                        {{ __('Broadcast Message') }}
                    </x-jet-responsive-nav-link>
                @endif

                <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('clients.index') }}" :active="request()->routeIs('clients.index')">
                    {{ __('Clients') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link class="text-gray-5000" href="{{ route('session.index') }}" :active="request()->routeIs('session.index')">
                    {{ __('Sessions') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link class="text-gray-500" href="/messages" :active="request()->routeIs('session.index')">
                    {{ __('Messages') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link class="text-gray-500" href="{{ route('logout') }}"
                        @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>


            </div>
        </div>
    </div>
</nav>
