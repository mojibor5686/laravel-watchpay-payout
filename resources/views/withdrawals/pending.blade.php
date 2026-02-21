@extends('layouts.master')
@section('title', 'Pending Withdrawals')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-amber-500/10 text-amber-500 rounded-xl flex items-center justify-center border border-amber-500/20 shadow-lg shadow-amber-500/5">
                        <i class="ri-timer-flash-line text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight uppercase">
                        Pending & Queue
                    </h1>
                </div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1.5 ml-1">
                    Requests awaiting administrator approval and processing.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('withdrawals.index') }}"
                    class="px-4 py-2 bg-rose-500/10 text-rose-500 rounded-lg text-xs font-bold border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all duration-300 flex items-center gap-2">
                    <i class="ri-arrow-left-line text-lg"></i> Back to Ledger
                </a>
                <a href="{{ route('withdrawals.create') }}"
                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2 shadow-lg shadow-emerald-500/20">
                    <i class="ri-add-circle-line text-lg"></i> New Request
                </a>
            </div>
        </div>

        <div class="bg-amber-500/5 border border-amber-500/10 p-4 rounded-2xl flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-500 shrink-0">
                <i class="ri-information-line text-lg"></i>
            </div>
            <p class="text-xs text-amber-200/70 leading-relaxed font-medium">
                You have <span class="text-amber-500 font-black">{{ $withdrawals->count() }}</span> pending requests in the
                queue. Please verify the account numbers before approving.
            </p>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            <th class="px-6 py-5">Request Details</th>
                            <th class="px-6 py-5">Payment Channel</th>
                            <th class="px-6 py-5 text-center">Amount</th>
                            <th class="px-6 py-5 text-center">Reference</th>
                            <th class="px-6 py-5 text-right">Approval Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/30">
                        @forelse($withdrawals as $data)
                            <tr class="group hover:bg-slate-700/20 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-600/5 flex items-center justify-center text-amber-500 font-bold border border-amber-500/20 shadow-inner">
                                            {{ strtoupper(substr($data->user_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-slate-200 group-hover:text-amber-400 transition">
                                                {{ $data->user_name }}</p>
                                            <p class="text-[10px] font-mono text-slate-500 tracking-tighter italic">
                                                Requested: {{ $data->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <span
                                            class="px-2 py-0.5 rounded bg-slate-900 text-[10px] font-black text-slate-400 border border-slate-700 uppercase">{{ $data->method }}</span>
                                        <p class="text-xs font-mono text-slate-200 tracking-widest">{{ $data->number }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-sm font-black text-amber-500">
                                        BDT {{ number_format($data->amount, 2) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-[10px] text-slate-500 italic max-w-[150px] mx-auto truncate">
                                        {{ $data->reference ?? 'No reference' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <form action="{{ route('send_to_api', $data->id) }}" method="GET">
                                            <button type="submit"
                                                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[10px] font-black uppercase hover:bg-emerald-500 hover:text-white transition-all shadow-lg">
                                                <i class="ri-check-line text-sm"></i> Sand To Api
                                            </button>
                                        </form>

                                        <form action="{{ route('withdrawals.updateStatus', $data->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit"
                                                class="w-9 h-9 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition shadow-lg"
                                                title="Reject Request">
                                                <i class="ri-close-line text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center">
                                            <i class="ri-checkbox-multiple-line text-3xl text-slate-700"></i>
                                        </div>
                                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Queue is empty
                                        </p>
                                        <p class="text-[10px] text-slate-600 italic">No pending requests at the moment.</p>
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
