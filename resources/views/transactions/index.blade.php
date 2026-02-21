@extends('layouts.master')
@section('title', 'Financial Ledger')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-orange-500/10 text-orange-400 rounded-xl flex items-center justify-center border border-orange-500/20 shadow-lg shadow-orange-500/5">
                        <i class="ri-exchange-funds-line text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight uppercase">
                        Financial & Ledger
                    </h1>
                </div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1.5 ml-1">
                    Real-time transaction history and audit trail
                </p>
            </div>

            <div
                class="flex items-center gap-3 bg-slate-800/40 p-1.5 rounded-2xl border border-slate-700/50 backdrop-blur-md">
                <div class="px-4 py-2">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Total Volume</p>
                    <p class="text-sm font-bold text-white BDT">BDT {{ number_format($transactions->sum('amount'), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            <th class="px-6 py-5">Transaction</th>
                            <th class="px-6 py-5">Channel</th>
                            <th class="px-6 py-5 text-center">Amount</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-6 py-5 text-right">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/30">
                        @forelse($transactions as $trx)
                            <tr class="group hover:bg-slate-700/20 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-orange-400 font-bold border border-slate-700 shadow-inner">
                                            <i class="ri-arrow-left-down-line text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-200 uppercase">{{ $trx->user_name }}</p>
                                            <p class="text-[10px] font-mono text-slate-500 italic">Trx ID:
                                                #TRX-{{ 1000 + $trx->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $trx->method_name }}</span>
                                        <span class="text-xs font-mono text-slate-500">Manual Payout</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm font-black text-white">
                                        <span class="text-slate-500 mr-0.5">-</span> BDT
                                        {{ number_format($trx->amount, 2) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($trx->status == 'pending')
                                        <span
                                            class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                            PENDING
                                        </span>
                                    @elseif($trx->status == 'success')
                                        <span
                                            class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                            SETTLED
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase bg-rose-500/10 text-rose-500 border border-rose-500/20">
                                            CANCELLED
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex flex-col items-end">
                                        <p class="text-xs font-bold text-slate-300">{{ $trx->created_at->format('d M, Y') }}
                                        </p>
                                        <p class="text-[9px] font-black text-slate-500 uppercase">
                                            {{ $trx->created_at->format('h:i A') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center">
                                            <i class="ri-history-line text-3xl text-slate-600"></i>
                                        </div>
                                        <p class="text-slate-500 font-medium">No transactions recorded yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($transactions->hasPages())
                <div class="px-6 py-4 bg-slate-900/30 border-t border-slate-700/50">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
