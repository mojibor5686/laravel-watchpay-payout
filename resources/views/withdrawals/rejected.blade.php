@extends('layouts.master')
@section('title', 'Rejected Withdrawals')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-rose-500/10 text-rose-500 rounded-xl flex items-center justify-center border border-rose-500/20 shadow-lg shadow-rose-500/5">
                        <i class="ri-close-circle-fill text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight uppercase">
                        Rejected & Requests
                    </h1>
                </div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1.5 ml-1">
                    List of all declined or failed payout transactions.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('withdrawals.index') }}"
                    class="px-4 py-2 bg-rose-500/10 text-rose-500 rounded-lg text-xs font-bold border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all duration-300 flex items-center gap-2">
                    <i class="ri-arrow-left-line text-lg"></i> Back to Ledger
                </a>
            </div>
        </div>

        <div
            class="bg-rose-500/5 border border-rose-500/10 p-5 rounded-3xl flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/20 flex items-center justify-center text-rose-500">
                    <i class="ri-error-warning-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-rose-500/50 uppercase tracking-widest">Declined Amount</p>
                    <p class="text-xl font-black text-white">BDT {{ number_format($withdrawals->sum('amount'), 2) }}</p>
                </div>
            </div>
            <div class="hidden md:block h-10 w-[1px] bg-slate-700/50"></div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total Rejected</p>
                <p class="text-lg font-bold text-slate-300">{{ $withdrawals->count() }} Records</p>
            </div>
            <div class="px-4 py-2 bg-rose-500/10 rounded-xl border border-rose-500/20">
                <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Status: Non-Refundable</p>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            <th class="px-6 py-5">Recipient Details</th>
                            <th class="px-6 py-5">Payment Method</th>
                            <th class="px-6 py-5 text-center">Amount</th>
                            <th class="px-6 py-5 text-center">Rejected Date</th>
                            <th class="px-6 py-5 text-right">Final Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/30">
                        @forelse($withdrawals as $data)
                            <tr class="group hover:bg-rose-500/[0.02] transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-rose-500 font-bold border border-rose-500/20 shadow-inner uppercase">
                                            {{ substr($data->user_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-200">{{ $data->user_name }}</p>
                                            <p class="text-[10px] font-medium text-slate-500 italic">
                                                Ref: #WD-{{ $data->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></div>
                                        <div class="text-xs">
                                            <p class="font-black text-slate-300 uppercase tracking-tighter">
                                                {{ $data->method }}</p>
                                            <p class="font-mono text-slate-500">{{ $data->number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm font-black text-slate-400 line-through decoration-rose-500/50">
                                        {{ number_format($data->amount, 2) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <p class="text-xs font-bold text-slate-300">
                                            {{ $data->updated_at->format('d M, Y') }}</p>
                                        <p class="text-[9px] font-black text-slate-500 uppercase">
                                            {{ $data->updated_at->format('h:i A') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end">
                                        <div
                                            class="flex items-center gap-2 px-3 py-1.5 border rounded-lg border-rose-500/30 bg-rose-500/5">
                                            <i class="ri-error-warning-fill text-rose-500 text-xs"></i>
                                            <span
                                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest">Rejected</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center border border-slate-700">
                                            <i class="ri-filter-off-line text-3xl text-slate-600"></i>
                                        </div>
                                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">
                                            No rejected records
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
