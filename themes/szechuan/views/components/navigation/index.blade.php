<nav x-data="{ 
        isSticky: false,
        slideOverOpen: false 
    }"
    x-init="
        window.addEventListener('scroll', () => {
            isSticky = window.scrollY > 20;
        });
    "
    :class="{
        'bg-background/95 backdrop-blur-xl border-b border-neutral/30 shadow-lg': isSticky,
        'bg-transparent border-b border-transparent shadow-none': !isSticky
    }"
    class="w-full px-4 lg:px-8 md:h-16 flex md:flex-row flex-col justify-between fixed top-0 z-20 transition-all duration-300 ease-in-out [&]:!bg-[var(--nav-bg)] [&.dark]:!bg-[var(--nav-bg-dark)]"
    style="
        --nav-bg: transparent;
        --nav-bg-dark: transparent;
    "
    x-bind:style="{
        '--nav-bg': isSticky ? 'hsl(var(--color-background) / 0.95)' : 'transparent',
        '--nav-bg-dark': isSticky ? 'hsl(var(--color-background) / 0.95)' : 'transparent'
    }">
    <div
        x-init="$watch('slideOverOpen', value => { document.documentElement.style.overflow = value ? 'hidden' : '' })"
        class="relative z-50 w-full h-auto">

        <div class="flex flex-row items-center justify-between w-full h-16">

            <div class="flex flex-row items-center">
                <a href="{{ route('home') }}" class="flex flex-row items-center h-10 group transition-all duration-200 hover:scale-105" wire:navigate>
                    <x-logo class="h-10 mr-2 rtl:ml-2 transition-transform duration-200 group-hover:rotate-2" />
                    <span class="text-xl font-bold leading-none text-foreground">{{ config('app.name') }}</span>
                </a>
                <div class="md:flex hidden flex-row ml-8">
                    @foreach (\App\Classes\Navigation::getLinks() as $nav)
                    @if (isset($nav['children']) && count($nav['children']) > 0)
                    <div class="relative">
                        <x-dropdown>
                            <x-slot:trigger>
                                <span class="flex flex-row items-center px-4 py-3 text-sm font-semibold whitespace-nowrap text-muted-foreground hover:text-foreground transition-all duration-200 rounded-lg hover:bg-background-secondary/50">
                                    {{ $nav['name'] }}
                                </span>
                            </x-slot:trigger>
                            <x-slot:content>
                                @foreach ($nav['children'] as $child)
                                <x-navigation.link
                                    :href="route($child['route'], $child['params'] ?? null)"
                                    :spa="isset($child['spa']) ? $nav['spa'] : true"
                                    class="hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                                    {{ $child['name'] }}
                                </x-navigation.link>
                                @endforeach
                            </x-slot:content>
                        </x-dropdown>
                    </div>
                    @else
                    <x-navigation.link
                        :href="route($nav['route'], $nav['params'] ?? null)"
                        :spa="isset($nav['spa']) ? $nav['spa'] : true"
                        class="flex items-center px-4 py-3 text-sm font-semibold text-muted-foreground hover:text-foreground transition-all duration-200 rounded-lg hover:bg-background-secondary/50 relative before:absolute before:bottom-0 before:left-1/2 before:w-0 before:h-0.5 before:bg-primary before:transition-all before:duration-200 hover:before:w-3/4 hover:before:left-1/8">
                        {{ $nav['name'] }}
                    </x-navigation.link>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="flex flex-row items-center gap-3">
                <div class="items-center hidden md:flex">
                    <x-dropdown>
                        <x-slot:trigger>
                            <span class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-muted-foreground hover:text-foreground transition-all duration-200 rounded-lg hover:bg-background-secondary/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                <span class="text-sm font-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                                <span class="text-muted-foreground">|</span>
                                <span class="text-sm font-semibold">{{ session('currency', config('settings.default_currency')) }}</span>
                            </span>
                        </x-slot:trigger>
                        <x-slot:content>
                            <div class="px-3 py-2 border-b border-neutral">
                                <h3 class="text-xs font-semibold uppercase text-muted-foreground tracking-wider">Language & Currency</h3>
                            </div>
                            <div class="p-2">
                                <strong class="block px-2 py-1 text-xs font-semibold uppercase text-muted-foreground">Language</strong>
                                <livewire:components.language-switch />
                                <strong class="block px-2 py-1 text-xs font-semibold uppercase text-muted-foreground mt-2">Currency</strong>
                                <livewire:components.currency-switch />
                            </div>
                        </x-slot:content>
                    </x-dropdown>
                    <x-theme-toggle />
                </div>

                <livewire:components.cart />

                @if(auth()->check())
                <div class="hidden lg:flex">
                    <x-dropdown>
                        <x-slot:trigger>
                            <span class="flex items-center gap-2 p-1 rounded-full hover:bg-background-secondary/50 transition-all duration-200 group">
                                <img src="{{ auth()->user()->avatar }}" class="size-8 rounded-full border-2 border-transparent group-hover:border-primary/20 transition-all duration-200" alt="avatar" />
                            </span>
                        </x-slot:trigger>
                        <x-slot:content>
                            <div class="flex flex-col p-3 border-b border-neutral">
                                <div class="flex items-center gap-3">
                                    <img src="{{ auth()->user()->avatar }}" class="size-10 rounded-full border border-neutral" alt="avatar" />
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-foreground">{{ auth()->user()->name }}</span>
                                        <span class="text-xs text-muted-foreground">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="py-1">
                                @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                                <x-navigation.link 
                                    :href="route($nav['route'], $nav['params'] ?? null)" 
                                    :spa="isset($nav['spa']) ? $nav['spa'] : true"
                                    class="flex items-center gap-3 px-3 py-2 hover:bg-primary/10 hover:text-primary transition-colors duration-200 rounded-lg">
                                    @php
                                        $iconMap = [
                                            'Dashboard' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2"></path></svg>',
                                            'Account' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                                            'Admin' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
                                            'Profile' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                                            'Orders' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                                            'Tickets' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>',
                                            'Support' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM12 18a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V18.75A.75.75 0 0112 18z"></path></svg>',
                                            'Services' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
                                            'Billing' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
                                            'Settings' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
                                        ];
                                        $icon = $iconMap[$nav['name']] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                    @endphp
                                    <span class="flex-shrink-0">{!! $icon !!}</span>
                                    <span>{{ $nav['name'] }}</span>
                                </x-navigation.link>
                                @endforeach
                                <div class="border-t border-neutral my-1"></div>
                                <livewire:auth.logout />
                            </div>
                        </x-slot:content>
                    </x-dropdown>
                </div>
                @else
                <div class="hidden lg:flex flex-row gap-2">
                    <a href="{{ route('login') }}" wire:navigate>
                        <x-button.secondary class="text-sm px-4 py-2 hover:bg-background hover:border-primary/20 transition-all duration-200">
                            {{ __('navigation.login') }}
                        </x-button.secondary>
                    </a>
                    @if(!config('settings.registration_disabled', false))
                    <a href="{{ route('register') }}" wire:navigate>
                        <x-button.primary class="text-sm px-4 py-2 bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 transition-all duration-200 shadow-md hover:shadow-lg">
                            {{ __('navigation.register') }}
                        </x-button.primary>
                    </a>
                    @endif
                </div>
                @endif
                <button
                    @click="slideOverOpen = !slideOverOpen"
                    class="relative w-10 h-10 flex lg:hidden items-center justify-center rounded-xl hover:bg-background-secondary/70 transition-all duration-200 border border-transparent hover:border-neutral/30"
                    aria-label="Toggle Menu">

                    <span
                        x-show="!slideOverOpen"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 -rotate-90 scale-75"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition duration-150"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 rotate-90 scale-75"
                        class="absolute inset-0 flex items-center justify-center"
                        aria-hidden="true">
                        <x-ri-menu-fill class="size-5 text-muted-foreground" />
                    </span>

                    <span
                        x-show="slideOverOpen"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 rotate-90 scale-75"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition duration-150"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 -rotate-90 scale-75"
                        class="absolute inset-0 flex items-center justify-center"
                        aria-hidden="true">
                        <x-ri-close-fill class="size-5 text-foreground" />
                    </span>

                </button>
            </div>
        </div>
        <template x-teleport="body">
            <div
                x-show="slideOverOpen"
                @keydown.window.escape="slideOverOpen=false"
                x-cloak
                class="fixed left-0 right-0 top-16 w-full z-[99]"
                style="height:calc(100dvh - 4rem);"
                aria-modal="true"
                tabindex="-1">
                <div
                    x-show="slideOverOpen"
                    @click.away="slideOverOpen = false"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    class="absolute inset-0 bg-background/80 backdrop-blur-2xl border-t border-neutral/20 shadow-2xl overflow-y-auto flex flex-col supports-backdrop-blur:bg-background/70">

                    <div class="flex flex-col h-full p-6 relative">
                        <!-- Glassmorphism overlay -->
                        <div class="absolute inset-0 bg-gradient-to-b from-background-secondary/20 to-background/10 backdrop-blur-sm -z-10 rounded-t-lg"></div>
                        <div class="flex-1 min-h-0 overflow-y-auto">
                            <x-navigation.sidebar-links />
                        </div>
                        <div class="mt-6 pt-6 border-t border-neutral/50">
                            @if(auth()->check())

                            <div
                                x-data="{ userPanelOpen: false }"
                                @keydown.escape.window="userPanelOpen = false"
                                x-cloak
                                class="relative">

                                <button @click="userPanelOpen = true" aria-label="Open user menu" class="flex gap-4 items-center justify-start w-full p-3 rounded-xl hover:bg-background-secondary/70 transition-all duration-200 group">
                                    <img src="{{ auth()->user()->avatar }}" class="size-12 rounded-full border-2 border-neutral group-hover:border-primary/30 transition-all duration-200" alt="avatar" />
                                    <div class="flex flex-col items-start gap-1">
                                        <span class="font-bold text-base">{{ auth()->user()->name }}</span>
                                        <span class="text-sm text-muted-foreground">{{ auth()->user()->email }}</span>
                                    </div>
                                    <svg class="w-4 h-4 ml-auto text-muted-foreground group-hover:text-foreground transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>

                                <div
                                    x-show="userPanelOpen"
                                    x-transition:enter="transition-opacity ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition-opacity ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    @click="userPanelOpen=false"
                                    class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40"
                                    style="pointer-events: auto"></div>

                                <div
                                    x-show="userPanelOpen"
                                    x-transition:enter="transition transform ease-out duration-300"
                                    x-transition:enter-start="translate-y-full opacity-0"
                                    x-transition:enter-end="translate-y-0 opacity-100"
                                    x-transition:leave="transition transform ease-in duration-200"
                                    x-transition:leave-start="translate-y-0 opacity-100"
                                    x-transition:leave-end="translate-y-full opacity-0"
                                    class="fixed bottom-0 left-0 right-0 z-50 mx-auto w-full"
                                    style="pointer-events: auto"
                                    @click.away="userPanelOpen = false"
                                    tabindex="-1"
                                    aria-modal="true">
                                    <div class="bg-background shadow-2xl rounded-t-3xl border-t border-neutral p-6 mx-4">
                                        <div class="flex gap-4 items-center justify-start mb-6">
                                            <img src="{{ auth()->user()->avatar }}" class="size-16 rounded-full border-2 border-primary/20" alt="avatar" />
                                            <div class="flex flex-col gap-1">
                                                <span class="font-bold text-xl">{{ auth()->user()->name }}</span>
                                                <span class="text-sm text-muted-foreground">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="h-px w-full bg-neutral/50 my-6"></div>
                                        <div class="flex flex-col gap-1 w-full">
                                            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                                            <x-navigation.link 
                                                :href="route($nav['route'], $nav['params'] ?? null)" 
                                                :spa="isset($nav['spa']) ? $nav['spa'] : true"
                                                class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 hover:text-primary transition-all duration-200">
                                                @php
                                                    $iconMap = [
                                                        'Dashboard' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2"></path></svg>',
                                                        'Account' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                                                        'Admin' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
                                                        'Profile' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                                                        'Orders' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                                                        'Tickets' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>',
                                                        'Support' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM12 18a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V18.75A.75.75 0 0112 18z"></path></svg>',
                                                        'Services' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
                                                        'Billing' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
                                                        'Settings' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
                                                    ];
                                                    $icon = $iconMap[$nav['name']] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                                @endphp
                                                <span class="flex-shrink-0">{!! $icon !!}</span>
                                                <span>{{ $nav['name'] }}</span>
                                            </x-navigation.link>
                                            @endforeach
                                            <div class="h-px w-full bg-neutral/30 my-2"></div>
                                            <livewire:auth.logout />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @else
                            <div class="flex flex-col gap-3">
                                @if(!config('settings.registration_disabled', false))
                                <a href="{{ route('register') }}" wire:navigate>
                                    <x-button.primary class="w-full justify-center py-3 text-base font-semibold bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 transition-all duration-200 shadow-lg">
                                        {{ __('navigation.register') }}
                                    </x-button.primary>
                                </a>
                                @endif
                                <a href="{{ route('login') }}" wire:navigate>
                                    <x-button.secondary class="w-full justify-center py-3 text-base font-semibold hover:bg-background hover:border-primary/20 transition-all duration-200">
                                        {{ __('navigation.login') }}
                                    </x-button.secondary>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</nav>
