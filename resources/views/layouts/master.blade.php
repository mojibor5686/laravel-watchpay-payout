<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        html,
        body,
        main,
        aside nav {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar,
        main::-webkit-scrollbar,
        aside nav::-webkit-scrollbar {
            display: none !important;
        }

        .scroll-bar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scroll-bar::-webkit-scrollbar {
            display: none;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
        }

        .scroll-bar::-webkit-scrollbar {
            width: 4px;
        }

        .scroll-bar::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .scroll-bar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(-10px);
        }

        .submenu.open {
            max-height: 1000px;
            opacity: 1;
            transform: translateY(0);
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .nav-link {
            transition: all 0.2s ease-in-out;
            border: 1px solid transparent;
        }

        .nav-item-active {
            background: linear-gradient(135deg, rgba(var(--active-rgb), 0.2) 0%, rgba(var(--active-rgb), 0.05) 100%);
            border: 1px solid rgba(var(--active-rgb), 0.3) !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .glass-header {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-gradient {
            background: #111827;
        }

        .menu-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #475569;
            transition: all 0.3s;
            display: inline-block;
        }

        .rotate-180 {
            transform: rotate(90deg);
        }
    </style>
</head>

<body class="text-slate-400">
    <div class="flex flex-col h-screen relative">
        <header class="glass-header w-full z-[60] fixed top-0 left-0 right-0 print:hidden">
            <div class="h-[70px] px-6 md:px-10 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <button id="menuBtn" class="md:hidden text-2xl text-white hover:text-blue-400 transition">
                        <i class="ri-menu-fold-line"></i>
                    </button>
                    <div class="flex items-center gap-3 hidden md:flex">
                        <div
                            class="bg-gradient-to-tr from-blue-600 to-indigo-600 h-10 w-10 grid place-items-center rounded-xl shadow-lg shadow-blue-500/20">
                            <i class="ri-wallet-3-fill text-white text-xl"></i>
                        </div>
                        <span class="text-white font-bold text-xl tracking-tight uppercase">Pay.<span
                                class="text-blue-500 underline decoration-blue-500/30 underline-offset-4">Gateway</span></span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button id="profile_menu_btn"
                            class="flex items-center gap-3 bg-slate-900/50 hover:bg-slate-800 p-1.5 pr-4 rounded-xl transition-all duration-300 border border-slate-800 group">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name=Admin&background=0F172A&color=fff&bold=true"
                                    alt="User"
                                    class="md:w-9 md:h-9 h-8 w-8 rounded-lg object-cover ring-2 ring-slate-800 group-hover:ring-blue-500/30 transition-all">
                                <div
                                    class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 border-2 border-[#0F172A] rounded-full shadow-lg">
                                </div>
                            </div>

                            <div class="text-left hidden md:block">
                                <div class="flex items-center gap-1.5">
                                    <p class="text-xs font-bold text-slate-200 leading-none tracking-wide">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <i class="ri-verified-badge-fill text-blue-500 text-[11px]"></i>
                                </div>
                                <span
                                    class="text-[9px] text-slate-500 font-extrabold uppercase mt-1 tracking-[1px] block">Terminal
                                    Access</span>
                            </div>

                            <i class="ri-arrow-down-s-line text-slate-500 group-hover:text-white transition-colors"></i>
                        </button>

                        <div id="profile_menu"
                            class="absolute top-full mt-3 right-0 w-64 bg-[#0F172A] border border-slate-800 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] hidden z-50 overflow-hidden backdrop-blur-xl">
                            <div
                                class="px-6 py-5 bg-gradient-to-b from-slate-800/30 to-transparent border-b border-slate-800/50 mb-1">
                                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[2px]">
                                    {{ __('messages.master_account') }}</p>
                                <p
                                    class="text-sm text-slate-200 font-semibold truncate mt-1.5 flex items-center gap-2 capitalize">
                                    <i class="ri-mail-line text-blue-500 text-xs"></i>
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <div class="p-2 space-y-0.5">
                                <a href="{{ route('setting.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-400 hover:text-blue-400 hover:bg-blue-500/5 rounded-xl transition-all group">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-slate-800/50 flex items-center justify-center group-hover:bg-blue-500/10 transition-colors">
                                        <i class="ri-user-settings-line text-base"></i>
                                    </div>
                                    Privacy Settings
                                </a>
                                <a href="{{ route('system.logs') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/5 rounded-xl transition-all group">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-slate-800/50 flex items-center justify-center group-hover:bg-emerald-500/10 transition-colors">
                                        <i class="ri-shield-flash-line text-base"></i>
                                    </div>
                                    Security Logs
                                </a>
                            </div>

                            <div class="px-4 py-2">
                                <hr class="border-slate-800">
                            </div>

                            <div class="p-2 pt-0">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-400 hover:bg-red-500/5 rounded-xl transition-all group">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-red-500/5 flex items-center justify-center group-hover:bg-red-500/10 transition-colors">
                                            <i class="ri-logout-circle-r-line text-base"></i>
                                        </div>
                                        Terminate Session
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @php
            function set_active($route, $colorClass = 'text-blue-400')
            {
                return request()->routeIs($route) ? $colorClass : 'text-slate-400';
            }

            function set_dot($route, $dotColor = 'bg-blue-400')
            {
                return request()->routeIs($route) ? "$dotColor shadow-[0_0_8px_currentColor]" : 'bg-slate-600';
            }
        @endphp

        <aside id="sidebar"
            class="scroll-bar sidebar-gradient border-r border-slate-800/50 w-[275px] fixed md:sticky top-[70px] h-[calc(100vh-70px)] z-50 transition-all duration-300 -translate-x-full md:translate-x-0 flex flex-col">
            <nav class="p-5 space-y-1.5 flex-1 overflow-y-auto pb-20">

                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[2.5px] mb-4 px-3">
                    Main Core
                </p>

                <a href="{{ route('dashboard') }}" style="--active-rgb: 59, 130, 246;"
                    class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-slate-800/50 group {{ set_active('dashboard', 'nav-item-active', 'border border-transparent') }} hover:bg-blue-500/10 hover:border-blue-500/20">
                    <i
                        class="ri-dashboard-3-line text-lg transition-transform group-hover:scale-110 
                    {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-400 group-hover:text-blue-400' }}">
                    </i>
                    <span
                        class="text-sm font-semibold transition-colors 
                    {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-300 group-hover:text-blue-400' }}">
                        Admin Dashboard
                    </span>
                    <i
                        class="ri-external-link-line ml-auto text-xs transition-colors
                    {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-400 group-hover:text-blue-400' }}">
                    </i>
                </a>

                <div>
                    <button style="--active-rgb: 34, 197, 94;"
                        class="nav-link w-full flex items-center justify-between px-4 py-3 group rounded-xl submenu-toggle transition-all duration-300 {{ set_active(['withdrawals.*'], 'nav-item-active', 'border-transparent') }} border hover:bg-green-500/10 hover:border-green-500/20"
                        data-menu-key="withdrawals">
                        <div class="flex items-center gap-3">
                            <i
                                class="ri-history-line text-lg text-green-400 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 origin-center"></i>
                            <span
                                class="text-sm font-semibold transition-colors group-hover:text-green-400 
                {{ set_active(['withdrawals.*'], 'text-green-400', 'text-slate-300') }}">
                                Payout Management
                            </span>
                        </div>
                        <i
                            class="ri-arrow-right-s-line arrow-icon text-sm transition-transform duration-300 group-hover:text-green-400 
            {{ set_active(['withdrawals.*'], 'text-green-400', 'text-slate-400') }}">
                        </i>
                    </button>

                    <div
                        class="submenu ml-3 pl-4 border-l border-slate-800 overflow-hidden transition-all duration-300">
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('withdrawals.index') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
            {{ set_active('withdrawals.index', 'text-green-400') }} 
            hover:text-green-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                {{ set_dot('withdrawals.index', 'bg-green-400 shadow-[0_0_8px_rgba(34,197,94,0.5)]') }} 
                group-hover:bg-green-400 group-hover:shadow-[0_0_8px_rgba(34,197,94,0.5)]">
                                </span>
                                <i class="ri-indent-increase text-[16px] opacity-80 group-hover:opacity-100"></i>
                                Withdrawal Index
                            </a>

                            <a href="{{ route('withdrawals.create') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
            {{ set_active('withdrawals.create', 'text-green-400') }} 
            hover:text-green-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                {{ set_dot('withdrawals.create', 'bg-green-400 shadow-[0_0_8px_rgba(34,197,94,0.5)]') }} 
                group-hover:bg-green-400 group-hover:shadow-[0_0_8px_rgba(34,197,94,0.5)]">
                                </span>
                                <i class="ri-add-circle-line text-[16px] opacity-80 group-hover:opacity-100"></i>
                                Withdrawal Request
                            </a>

                            <a href="{{ route('withdrawals.pending') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
            {{ set_active('withdrawals.pending', 'text-green-400') }} 
            hover:text-green-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                {{ set_dot('withdrawals.pending', 'bg-green-400 shadow-[0_0_8px_rgba(34,197,94,0.5)]') }} 
                group-hover:bg-green-400 group-hover:shadow-[0_0_8px_rgba(34,197,94,0.5)]">
                                </span>
                                <i class="ri-time-line text-[16px] opacity-80 group-hover:opacity-100"></i>
                                Withdrawal Pending
                            </a>

                            <a href="{{ route('withdrawals.approved') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
            {{ set_active('withdrawals.approved', 'text-green-400') }} 
            hover:text-green-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                {{ set_dot('withdrawals.approved', 'bg-green-400 shadow-[0_0_8px_rgba(34,197,94,0.5)]') }} 
                group-hover:bg-green-400 group-hover:shadow-[0_0_8px_rgba(34,197,94,0.5)]">
                                </span>
                                <i class="ri-checkbox-circle-fill text-[16px] opacity-80 group-hover:opacity-100"></i>
                                Withdrawal Approved
                            </a>

                            <a href="{{ route('withdrawals.rejected') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
    {{ set_active('withdrawals.rejected', 'text-rose-500') }} 
    hover:text-rose-500 text-slate-400">

                                <span
                                    class="menu-dot transition-all duration-300 
        {{ set_dot('withdrawals.rejected', 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]') }} 
        group-hover:bg-rose-500 group-hover:shadow-[0_0_8px_rgba(244,63,94,0.5)]">
                                </span>

                                <i class="ri-close-circle-fill text-[16px] opacity-80 group-hover:opacity-100"></i>

                                Withdrawal Rejected
                            </a>
                        </div>
                    </div>
                </div>

                <p
                    class="text-[10px] font-bold text-slate-600 uppercase tracking-[2.5px] mb-3 px-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span>
                    API & Configuration
                </p>

                <a href="{{ route('gateways.index') }}"
                    class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl group transition-all {{ set_active(['gateways.*'], 'bg-lime-500/10 border border-lime-500/20', 'border border-transparent') }} hover:bg-lime-500/10 hover:border-lime-500/20">
                    <i
                        class="ri-code-s-slash-line text-lg text-lime-400 group-hover:scale-110 transition-transform"></i>
                    <div class="flex flex-col text-left gap-0.5">
                        <span class="text-sm font-semibold group-hover:text-lime-400 transition-colors">Gateway
                            API</span>
                        <span class="text-[9px] text-slate-500 font-medium uppercase tracking-tighter">End-point
                            Configuration</span>
                    </div>
                    <i
                        class="ri-external-link-line ml-auto text-xs transition-colors duration-300 group-hover:text-lime-400 {{ set_active(['gateways.*'], 'text-lime-400', 'text-slate-400') }}">
                    </i>
                </a>

                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[2.5px] pt-4 mb-2 px-3">
                    Accounting & Finance
                </p>

                <a href="{{ route('transactions.index') }}"
                    class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl group transition-all duration-300{{ set_active(['transactions.index'], 'bg-yellow-500/10 border border-yellow-500/20', 'border border-transparent') }} hover:bg-yellow-500/10 hover:border-yellow-500/20">
                    <i
                        class="ri-exchange-funds-line text-lg text-yellow-400 group-hover:rotate-12 transition-transform duration-300"></i>
                    <span
                        class="text-sm font-semibold transition-colors group-hover:text-yellow-400 
                {{ set_active(['transactions.index'], 'text-yellow-400', 'text-slate-300') }}">
                        Transaction Logs
                    </span>
                    <i
                        class="ri-external-link-line ml-auto text-xs transition-colors duration-300 group-hover:text-yellow-400 {{ set_active(['transactions.index'], 'text-yellow-400', 'text-slate-400') }}">
                    </i>
                </a>

                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[2.5px] pt-4 mb-2 px-3">
                    Privacy Management
                </p>

                <div>
                    <button style="--active-rgb: 249, 115, 22;"
                        class="nav-link w-full flex items-center justify-between px-4 py-3 group rounded-xl submenu-toggle transition-all duration-300 {{ set_active(['system.*'], 'nav-item-active', 'border-transparent') }} border hover:bg-orange-500/10 hover:border-orange-500/20"
                        data-menu-key="logs">
                        <div class="flex items-center gap-3">
                            <i
                                class="ri-radar-line text-lg text-orange-400 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 origin-center"></i>
                            <span
                                class="text-sm font-semibold transition-colors group-hover:text-orange-400 
                {{ set_active(['system.*'], 'text-orange-400', 'text-slate-300') }}">
                                System Intelligence
                            </span>
                        </div>
                        <i
                            class="ri-arrow-right-s-line arrow-icon text-sm transition-transform duration-300 group-hover:text-orange-400 
            {{ set_active(['system.*'], 'text-orange-400', 'text-slate-400') }}">
                        </i>
                    </button>

                    <div
                        class="submenu ml-3 pl-4 border-l border-slate-800 overflow-hidden transition-all duration-300">
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('system.logs') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
                {{ set_active('system.logs', 'text-orange-400') }} 
                hover:text-orange-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                    {{ set_dot('system.logs', 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]') }} 
                    group-hover:bg-orange-400 group-hover:shadow-[0_0_8px_rgba(251,146,60,0.5)]">
                                </span>
                                <i class="ri-terminal-box-line text-[14px]"></i>
                                Activity Insights
                            </a>

                            <a href="{{ route('system.health') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
                {{ set_active('system.health', 'text-orange-400') }} 
                hover:text-orange-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                    {{ set_dot('system.health', 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]') }} 
                    group-hover:bg-orange-400 group-hover:shadow-[0_0_8px_rgba(251,146,60,0.5)]">
                                </span>
                                <i class="ri-pulse-line text-[14px]"></i>
                                Performance Metrics
                            </a>

                            <a href="{{ route('system.login.history') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
                {{ set_active('system.login.history', 'text-orange-400') }} 
                hover:text-orange-400">
                                <span
                                    class="menu-dot transition-all duration-300 
                    {{ set_dot('system.login.history', 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]') }} 
                    group-hover:bg-orange-400 group-hover:shadow-[0_0_8px_rgba(251,146,60,0.5)]">
                                </span>
                                <i class="ri-shield-keyhole-line text-[14px]"></i>
                                Security Audit
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <button style="--active-rgb: 244, 63, 94;"
                        class="nav-link w-full flex items-center justify-between px-4 py-3 group rounded-xl submenu-toggle transition-all duration-300 {{ set_active(['settings.*'], 'nav-item-active', 'border-transparent') }} border hover:bg-rose-500/10 hover:border-rose-500/20"
                        data-menu-key="settings">
                        <div class="flex items-center gap-3">
                            <i
                                class="ri-settings-5-line text-lg text-rose-500 inline-block transition-transform duration-300 group-hover:scale-110 group-hover:text-rose-500"></i>
                            <span
                                class="text-sm font-semibold text-slate-400 group-hover:text-rose-500 transition-colors {{ set_active(['settings.*'], 'text-rose-400', 'text-slate-300') }}">
                                Privacy Settings
                            </span>
                        </div>
                        <i
                            class="ri-arrow-right-s-line arrow-icon text-sm transition-transform duration-300 text-slate-400 group-hover:text-rose-500 {{ set_active(['settings.*'], 'text-rose-400', 'text-slate-400') }}"></i>
                    </button>

                    <div
                        class="submenu ml-3 pl-4 border-l border-slate-800 overflow-hidden transition-all duration-300">
                        <div class="space-y-1 mt-1">
                            <a href="{{ route('setting.index') }}"
                                class="flex items-center gap-3 py-2.5 text-xs font-medium transition-colors group
                        {{ set_active('setting.index', 'text-rose-500') }} 
                        hover:text-rose-500">
                                <span
                                    class="menu-dot transition-all duration-300 
                        {{ set_dot('setting.index', 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]') }} 
                        group-hover:bg-rose-500 group-hover:shadow-[0_0_8px_rgba(244,63,94,0.5)]">
                                </span>
                                <i class="ri-equalizer-line text-[14px]"></i>
                                General Configuration
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <main class="fixed top-[70px] right-0 bottom-0 left-0 md:left-[275px] overflow-y-auto scroll-bar bg-[#0f172a]">
            <div class="p-3 md:p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <div id="overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden md:hidden"></div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#1e293b',
            color: '#f8fafc',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function showAlert(icon, title) {
            Toast.fire({
                icon: icon,
                title: title
            });
        }

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This record will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#475569',
                confirmButtonText: 'Yes, delete it!',
                background: '#1e293b',
                color: '#fff',
                customClass: {
                    popup: 'rounded-[24px] border border-slate-700/50'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }

        @if (session('success'))
            showAlert('success', "{{ session('success') }}");
        @endif

        @if (session('error'))
            showAlert('error', "{{ session('error') }}");
        @endif

        @if ($errors->any())
            showAlert('error', "Validation failed. Please check inputs.");
        @endif
    </script>

    <style>
        .swal2-toast {
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4) !important;
            padding: 0.75rem 1rem !important;
        }

        .swal2-timer-progress-bar {
            background: rgba(255, 255, 255, 0.2) !important;
        }
    </style>

    <script>
        const profileBtn = document.getElementById('profile_menu_btn');
        const profileMenu = document.getElementById('profile_menu');
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (profileBtn) profileBtn.onclick = (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        };
        window.onclick = () => profileMenu?.classList.add('hidden');

        menuBtn.onclick = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        overlay.onclick = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        };

        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('.submenu-toggle');

            toggles.forEach(toggle => {
                toggle.onclick = function() {
                    const submenu = this.nextElementSibling;
                    const arrow = this.querySelector('.arrow-icon');
                    const key = this.dataset.menuKey;

                    const isOpen = submenu.classList.contains('open');

                    document.querySelectorAll('.submenu').forEach(s => {
                        s.classList.remove('open');
                        s.previousElementSibling.classList.remove('submenu-active',
                            'nav-item-active');
                        s.previousElementSibling.querySelector('.arrow-icon').style.transform =
                            'rotate(0deg)';
                    });

                    if (!isOpen) {
                        submenu.classList.add('open');
                        this.classList.add('submenu-active', 'nav-item-active');
                        arrow.style.transform = 'rotate(90deg)';
                        localStorage.setItem('openMenu', key);
                    } else {
                        localStorage.removeItem('openMenu');
                    }
                };
            });

            const savedMenu = localStorage.getItem('openMenu');
            if (savedMenu) {
                const activeToggle = document.querySelector(`[data-menu-key="${savedMenu}"]`);
                if (activeToggle) {
                    activeToggle.nextElementSibling.classList.add('open');
                    activeToggle.classList.add('submenu-active', 'nav-item-active');
                    activeToggle.querySelector('.arrow-icon').style.transform = 'rotate(90deg)';
                }
            }
        });
    </script>
</body>

</html>
