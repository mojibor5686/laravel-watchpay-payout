@extends('layouts.master')
@section('title', 'System Logs')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                    <i class="ri-file-list-3-line text-blue-500"></i> System & Error
                </h1>
                <p class="text-slate-500 text-sm mt-2">সিস্টেমের সাম্প্রতিক এরর এবং ওয়ার্নিংগুলো এখানে দেখুন।</p>
            </div>
            <div class="flex gap-2">
                <button onclick="location.reload()"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold uppercase transition border border-slate-700/50 flex items-center gap-2">
                    <i class="ri-refresh-line"></i> Refresh
                </button>
                <form action="{{ route('system.clearLogs') }}" method="POST"> @csrf
                    <button
                        class="px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 rounded-lg text-xs font-bold uppercase transition border border-rose-500/20 flex items-center gap-2">
                        <i class="ri-delete-bin-line"></i> Clear Logs
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden backdrop-blur-md shadow-2xl">
            <div class="bg-slate-900/50 px-6 py-4 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-rose-500/50"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500/50"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500/50"></div>
                    </div>
                    <span class="text-slate-400 text-xs font-mono">laravel.log</span>
                </div>
                <span class="text-[10px] font-black text-slate-500 uppercase">Latest 50 entries</span>
            </div>

            <div class="p-4 overflow-x-auto">
                <div class="max-h-full overflow-y-auto space-y-2 pr-2 custom-scrollbar">
                    @forelse($logs as $log)
                        @php
                            $isError =
                                str_contains(strtolower($log), 'error') || str_contains(strtolower($log), 'critical');
                            $isWarning = str_contains(strtolower($log), 'warning');
                        @endphp

                        <div
                            class="group p-3 rounded-xl border border-slate-700/30 bg-slate-900/30 hover:border-slate-600 transition duration-200">
                            <div class="flex flex-col items-start gap-3 font-mono text-xs">
                                <span class="shrink-0 text-slate-500 bg-slate-800 px-2 py-0.5 rounded italic">
                                    {{ Str::before(Str::after($log, '['), ']') }}
                                </span>

                                <span
                                    class="break-all leading-relaxed {{ $isError ? 'text-rose-400' : ($isWarning ? 'text-amber-400' : 'text-slate-300') }}">
                                    @php
                                        $message = Str::after($log, ']. ');
                                    @endphp
                                    <span
                                        class="font-bold opacity-70 uppercase mr-1">[{{ $isError ? 'Error' : ($isWarning ? 'Warning' : 'Info') }}]</span>
                                    {{ $message }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
                            <i class="ri-check-double-line text-4xl mb-2 text-emerald-500/50"></i>
                            <p class="text-sm">কোনো এরর পাওয়া যায়নি। আপনার সিস্টেম একদম ক্লিন!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
@endsection
