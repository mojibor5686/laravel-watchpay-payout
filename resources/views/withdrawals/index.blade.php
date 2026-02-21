@extends('layouts.master')
@section('title', 'Withdrawal Ledger')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-emerald-500/10 text-emerald-500 rounded-xl flex items-center justify-center border border-emerald-500/20 shadow-lg shadow-emerald-500/5">
                        <i class="ri-bank-card-line text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight uppercase">
                        Withdrawal & Ledger
                    </h1>
                </div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1.5 ml-1">
                    Manage and monitor all payout requests and transactions.
                </p>
            </div>
            <a href="{{ route('withdrawals.create') }}"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2 shadow-lg shadow-emerald-500/20">
                <i class="ri-add-circle-line text-lg"></i> New Request
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div
                class="relative overflow-hidden p-5 bg-slate-800/40 border border-slate-700/50 rounded-3xl backdrop-blur-md group hover:border-blue-500/50 transition-all duration-300">
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total Payout</p>
                        <p class="text-3xl font-black text-white mt-1">BDT
                            {{ number_format($withdrawals->where('status', 'success')->sum('amount'), 2) }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-blue-500/10 text-blue-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="ri-money-dollar-circle-line text-2xl"></i>
                    </div>
                </div>
                <div class="absolute -right-2 -bottom-2 text-blue-500/5 text-7xl font-black"><i
                        class="ri-money-dollar-circle-line"></i></div>
            </div>

            <div
                class="relative overflow-hidden p-5 bg-slate-800/40 border border-slate-700/50 rounded-3xl backdrop-blur-md group hover:border-amber-500/50 transition-all duration-300">
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Pending Queue</p>
                        <p class="text-3xl font-black text-amber-500 mt-1">
                            {{ $withdrawals->where('status', 'pending')->count() }} Requests</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-amber-500/10 text-amber-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="ri-timer-flash-line text-2xl"></i>
                    </div>
                </div>
                <div class="absolute -right-2 -bottom-2 text-amber-500/5 text-7xl font-black"><i
                        class="ri-timer-flash-line"></i></div>
            </div>

            <div
                class="relative overflow-hidden p-5 bg-slate-800/40 border border-slate-700/50 rounded-3xl backdrop-blur-md group hover:border-emerald-500/50 transition-all duration-300">
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Success Rate</p>
                        <p class="text-3xl font-black text-emerald-500 mt-1">98.4%</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="ri-checkbox-circle-line text-2xl"></i>
                    </div>
                </div>
                <div class="absolute -right-2 -bottom-2 text-emerald-500/5 text-7xl font-black"><i
                        class="ri-checkbox-circle-line"></i></div>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            <th class="px-6 py-5">User & Method</th>
                            <th class="px-6 py-5">Account Number</th>
                            <th class="px-6 py-5 text-center">Amount</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-6 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/30">
                        @forelse($withdrawals as $data)
                            <tr class="group hover:bg-slate-700/20 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-emerald-400 font-bold border border-slate-600/50 shadow-inner uppercase">
                                            {{ substr($data->user_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-slate-200 group-hover:text-emerald-400 transition">
                                                {{ $data->user_name }}</p>
                                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">
                                                {{ $data->method }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-smartphone-line text-slate-500"></i>
                                        <span
                                            class="text-xs font-mono text-slate-400 tracking-wider">{{ $data->number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm font-black text-white">
                                        <span
                                            class="text-[10px] text-slate-500 font-normal mr-1">BDT</span>{{ number_format($data->amount, 2) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($data->status == 'pending')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                            <span class="w-1 h-1 rounded-full bg-amber-500 animate-pulse"></span> PENDING
                                        </span>
                                    @elseif($data->status == 'approved')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 shadow-[0_0_10px_rgba(16,185,129,0.1)]">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500"></span> APPROVED
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase bg-rose-500/10 text-rose-500 border border-rose-500/20">
                                            <span class="w-1 h-1 rounded-full bg-rose-500"></span> REJECTED
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($data->status == 'pending')
                                            <form action="{{ route('withdrawals.updateStatus', $data->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="success">
                                                <button type="submit"
                                                    class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 text-emerald-400 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition shadow-lg"
                                                    title="Approve">
                                                    <i class="ri-check-line text-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('withdrawals.updateStatus', $data->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit"
                                                    class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 text-rose-500 flex items-center justify-center hover:bg-rose-600 hover:text-white transition shadow-lg"
                                                    title="Reject">
                                                    <i class="ri-close-line text-lg"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span
                                                class="text-[10px] font-bold text-slate-600 uppercase tracking-widest italic">Processed</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center">
                                            <i class="ri-refund-2-line text-3xl text-slate-600"></i>
                                        </div>
                                        <p class="text-slate-500 font-medium">No withdrawal requests found.</p>
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
