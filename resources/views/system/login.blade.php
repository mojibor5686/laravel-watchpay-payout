@extends('layouts.master')
@section('title', 'Login History')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                    <i class="ri-shield-user-line text-emerald-500"></i> Login & Activity
                </h1>
                <p class="text-slate-500 text-sm mt-2">সিস্টেমের সাম্প্রতিক লগইন এবং অ্যাক্টিভিটি হিস্ট্রি এখানে দেখুন।</p>
            </div>
            <div class="flex gap-2">
                <button onclick="location.reload()"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold uppercase transition border border-slate-700/50 flex items-center gap-2">
                    <i class="ri-refresh-line"></i> Refresh
                </button>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden backdrop-blur-md shadow-2xl">
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-slate-700/50">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase">Event / Activity</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase">Location & IP</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase">Device & Browser</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase text-right">Date & Time
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/30">
                        @forelse($logs as $log)
                            <tr class="group hover:bg-slate-700/20 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg {{ str_contains(strtolower($log->event), 'out') ? 'bg-rose-500/10 text-rose-500' : 'bg-emerald-500/10 text-emerald-500' }} flex items-center justify-center">
                                            <i
                                                class="{{ str_contains(strtolower($log->event), 'out') ? 'ri-logout-circle-line' : 'ri-login-circle-line' }} text-lg"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="text-sm font-semibold text-slate-200 block">{{ $log->event }}</span>
                                            <span
                                                class="text-[10px] text-slate-500 uppercase font-mono tracking-wider">Status:
                                                Success</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-300">
                                            <i class="ri-map-pin-2-fill text-rose-500 opacity-70"></i>
                                            <span>{{ $log->city ?? 'Unknown' }}</span>
                                        </div>
                                        <span
                                            class="text-[11px] font-mono text-blue-400 bg-blue-500/5 px-1.5 py-0.5 rounded border border-blue-500/10 w-fit">
                                            {{ $log->ip_address }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-300">
                                            <i class="ri-computer-line text-amber-500 opacity-70"></i>
                                            <span>{{ $log->device }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                                            <i class="ri-chrome-fill text-emerald-500"></i>
                                            <span>{{ $log->browser }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-300 italic">
                                            {{ $log->occurred_at->format('d M, Y') }}
                                        </span>
                                        <span class="text-[10px] text-slate-500 font-mono">
                                            {{ $log->occurred_at->format('h:i:s A') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-500">
                                        <i class="ri-ghost-line text-4xl mb-2 opacity-20"></i>
                                        <p class="text-sm italic">এখনো কোনো লগ রেকর্ড করা হয়নি।</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-slate-900/30 px-6 py-4 border-t border-slate-700/50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
