@extends('layouts.master')
@section('title', 'Admin Dashboard')
@section('content')
    <div class="space-y-8 pb-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-slate-800/40 border border-slate-700/50 p-6 rounded-[32px] backdrop-blur-md relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all">
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center border border-emerald-500/20">
                        <i class="ri-checkbox-circle-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Settled Payouts</p>
                        <h3 class="text-xl font-black text-white mt-0.5">BDT
                            {{ number_format($stats['total_withdrawn'], 2) }}</h3>
                    </div>
                </div>
            </div>

            <div
                class="bg-slate-800/40 border border-slate-700/50 p-6 rounded-[32px] backdrop-blur-md relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all">
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-amber-500/10 text-amber-400 rounded-2xl flex items-center justify-center border border-amber-500/20">
                        <i class="ri-time-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Pending Volume</p>
                        <h3 class="text-xl font-black text-white mt-0.5">BDT
                            {{ number_format($stats['pending_withdraw'], 2) }}</h3>
                    </div>
                </div>
            </div>

            <div
                class="bg-slate-800/40 border border-slate-700/50 p-6 rounded-[32px] backdrop-blur-md relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all">
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center border border-indigo-500/20">
                        <i class="ri-exchange-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Ledger Entries</p>
                        <h3 class="text-xl font-black text-white mt-0.5">{{ $stats['total_transactions'] }} <span
                                class="text-[10px] text-slate-500 uppercase">Records</span></h3>
                    </div>
                </div>
            </div>

            <div
                class="bg-slate-800/40 border border-slate-700/50 p-6 rounded-[32px] backdrop-blur-md relative overflow-hidden group">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 {{ $stats['gateway'] && $stats['gateway']->status == 'active' ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-rose-500/10 text-rose-500 border-rose-500/20' }} rounded-2xl flex items-center justify-center border">
                        <i class="ri-shield-flash-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Gateway Health</p>
                        <h3 class="text-sm font-black text-white mt-0.5 uppercase tracking-tighter">
                            {{ $stats['gateway'] ? ($stats['gateway']->status == 'active' ? 'Operational' : 'Maintenance') : 'No Config' }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-slate-800/40 border border-slate-700/50 rounded-[32px] overflow-hidden backdrop-blur-md">
                <div class="px-8 py-6 border-b border-slate-700/50 flex justify-between items-center">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest">Recent Payout Requests</h3>
                    <a href="{{ route('withdrawals.index') }}"
                        class="text-[10px] font-black text-orange-400 uppercase hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-700/30">
                            @foreach ($stats['recent_withdrawals'] as $w)
                                <tr class="hover:bg-slate-700/20 transition-all">
                                    <td class="px-8 py-4">
                                        <p class="text-xs font-bold text-slate-200 uppercase">{{ $w->user_name }}</p>
                                        <p class="text-[9px] text-slate-500 font-mono">{{ $w->method }} •
                                            {{ $w->number }}</p>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <span class="text-xs font-black text-white">BDT
                                            {{ number_format($w->amount, 0) }}</span>
                                    </td>
                                    <td class="px-8 py-4 text-right text-[9px]">
                                        @if ($w->status == 'pending')
                                            <span class="text-amber-500 font-black uppercase">Pending</span>
                                        @else
                                            <span
                                                class="text-emerald-500 font-black uppercase tracking-tighter italic">Finished</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-slate-800/40 border border-slate-700/50 rounded-[32px] overflow-hidden backdrop-blur-md">
                <div class="px-8 py-6 border-b border-slate-700/50 flex justify-between items-center">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest">Latest Ledger Activity</h3>
                    <a href="{{ route('transactions.index') }}"
                        class="text-[10px] font-black text-indigo-400 uppercase hover:underline">Audits</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-700/30">
                            @foreach ($stats['recent_trx'] as $trx)
                                <tr class="hover:bg-slate-700/20 transition-all">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $trx->status == 'success' ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-300 uppercase">
                                                    #TRX-{{ 1000 + $trx->id }}</p>
                                                <p class="text-[9px] text-slate-600 uppercase">
                                                    {{ $trx->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <p class="text-xs font-black text-slate-200">- {{ number_format($trx->amount, 2) }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
