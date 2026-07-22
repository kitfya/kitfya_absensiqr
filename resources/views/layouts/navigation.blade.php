<header class="fixed top-0 right-0 left-64 flex justify-between items-center h-16 px-6 bg-surface dark:bg-background border-b border-outline-variant dark:border-outline z-40 hidden sm:flex">
    <div class="flex items-center gap-4">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input class="pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-lg w-80 text-body-md focus:ring-2 focus:ring-primary focus:outline-none transition-all" placeholder="Cari data..." type="text"/>
        </div>
    </div>
    <div class="flex items-center gap-6">
        
        <div class="flex items-center gap-3">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-2 text-body-md font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
            <div class="h-8 w-[1px] bg-outline-variant mx-2"></div>
            <img alt="Admin User" class="w-8 h-8 rounded-full border border-outline-variant object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBn0Eaq13kqM0dHuiicuOl0axYHfwNpcRnpG3TjbER5ZAe6zRjkyKnvt0JRlgfx8QI4-i1wthU8nURYPx9U-ZGh_OPbiBp83wagRh9-3cwoLzqPsvah99rHuztxzWJ6GXS8hyEsgHxtzOJJS2ErvbsHpej1ApFZOqcZ6o3WRl_XVAT5_fSS2WLKJ_aXc79ncYtodNO8uwM4mYqH7h82fXo9RuaeR_yvV3MvNFITMVntV5II-QS5Wkhr93B9gk_gwJ7joVNWLTZ20s4"/>
        </div>
    </div>
</header>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 fixed top-0 inset-x-0 h-16 z-50 flex items-center justify-between px-4 sm:hidden">
    <span class="text-title-md font-bold text-primary">{{ config('app.name', 'EduAttend') }}</span>
    <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <div :class="{'block': open, 'hidden': ! open}" class="absolute top-16 left-0 w-full bg-white border-b border-gray-200 shadow-md p-4 space-y-1 hidden">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('akademik.index')" :active="request()->routeIs('akademik.*')">{{ __('Akademik') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('siswa.index')" :active="request()->routeIs('siswa.*')">{{ __('Siswa') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('absensi.riwayat')" :active="request()->routeIs('absensi.*')">{{ __('Riwayat Absen') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('absensi.jadwal')" :active="request()->routeIs('absensi.jadwal')">{{ __('Pengaturan Jadwal') }}</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('qr.index')" :active="request()->routeIs('qr.*')">{{ __('QR Generator') }}</x-responsive-nav-link>
        <hr class="my-2 border-gray-200">
        <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
        </form>
    </div>
</nav>

<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container dark:bg-inverse-surface shadow-sm flex flex-col border-r border-outline-variant dark:border-outline z-50 hidden sm:flex">
    <div class="p-6">
        <h1 class="text-title-md font-title-md font-bold text-primary dark:text-primary-fixed-dim">
            {{ config('app.name', 'KitfyaIn') }}
        </h1>
        <p class="text-label-caps font-label-caps text-on-surface-variant mt-1">
            Academic in the future
        </p>
    </div>
    
    <nav class="flex-1 px-3 space-y-1">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('dashboard') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-label-caps font-label-caps">Dashboard</span>
        </a>

        <a href="{{ route('akademik.index') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('akademik.*') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">domain</span>
            <span class="text-label-caps font-label-caps">Akademik</span>
        </a>

        <a href="{{ route('siswa.index') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('siswa.*') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">group</span>
            <span class="text-label-caps font-label-caps">Siswa</span>
        </a>

        <a href="{{ route('absensi.riwayat') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('absensi.riwayat') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">event_available</span>
            <span class="text-label-caps font-label-caps">Attendance</span>
        </a>

        <a href="{{ route('absensi.jadwal') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('absensi.jadwal') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">schedule</span>
            <span class="text-label-caps font-label-caps">Jadwal Absensi</span>
        </a>

        <a href="{{ route('qr.index') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('qr.*') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">qr_code</span>
            <span class="text-label-caps font-label-caps">QR Generator</span>
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-3 px-4 py-3 transition-all rounded-lg {{ request()->routeIs('profile.edit') ? 'text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high' : 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors' }}">
            <span class="material-symbols-outlined">settings</span>
            <span class="text-label-caps font-label-caps">Settings</span>
        </a>
    </nav>

    <div class="p-6 border-t border-outline-variant">
        <div class="flex items-center gap-3">
            <img alt="Principal Profile Avatar" class="w-10 h-10 rounded-full bg-secondary-container object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAV2Fk9bSUhhKzKcd_RcBbW9CsrMOmpzORMvzcsTJWerZJ4pGJ-DwUMZRSSItKyrWIkUpu0_0hPUtI6jHNvV4xYTZCsFODzzjToAEMKg8aQjFZZF-VqXplpBrqA0imbqQ2UoMvL6wWXCdlmBDRyAV33q-JtyTQ1zbMVJSz4nbzMI2h_shL5_Zx_y-JfMQJHd-zI1vAiueK1gIFjdexQZ0XM0WDTaa4BK2Yx9mLqcNX99JGG5EdDWdbd_krYInbNol34rlR_PZwmEmI"/>
            <div>
                <p class="text-body-md font-bold">{{ Auth::user()->name }}</p>
                <p class="text-label-caps opacity-70 uppercase">Operator</p>
            </div>
        </div>
    </div>
</aside>