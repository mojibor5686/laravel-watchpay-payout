@extends('layouts.master')
@section('title', 'New Withdrawal')
@section('content')
    <div class="w-full space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-emerald-500/10 text-emerald-500 rounded-xl flex items-center justify-center border border-emerald-500/20 shadow-lg shadow-emerald-500/5">
                        <i class="ri-hand-coin-line text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight uppercase">
                        Create & Payout
                    </h1>
                </div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1.5 ml-1">
                    Initiate a new withdrawal request to the system
                </p>
            </div>
            <a href="{{ route('withdrawals.index') }}"
                class="px-4 py-2 bg-rose-500/10 text-rose-500 rounded-lg text-xs font-bold border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all duration-300 flex items-center gap-2">
                <i class="ri-arrow-left-line text-lg"></i> Back
            </a>
        </div>

        <form action="{{ route('withdrawals.store') }}" method="POST"
            class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-8 backdrop-blur-md shadow-2xl space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Account Name / User
                        Name</label>
                    <input type="text" name="user_name" value="{{ old('user_name', auth()->user()->name ?? '') }}"
                        placeholder="Enter name"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-4 py-3 text-slate-200 placeholder:text-slate-600 focus:border-emerald-500/50 focus:ring-0 transition outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Phone Number</label>
                    <input type="text" name="number" placeholder="01XXXXXXXXX"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-4 py-3 text-slate-200 placeholder:text-slate-600 focus:border-emerald-500/50 focus:ring-0 transition outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Select
                        Method</label>
                    <div class="relative">
                        <select name="method"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-4 py-3 text-slate-200 focus:border-emerald-500/50 focus:ring-0 transition outline-none appearance-none cursor-pointer">
                            <option value="bkash">bKash</option>
                            <option value="nagad">Nagad</option>
                        </select>
                        <i
                            class="ri-arrow-down-s-line absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Withdraw
                        Amount</label>
                    <input type="number" step="0.01" name="amount" placeholder="0.00"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-4 py-3 text-slate-200 focus:border-emerald-500/50 focus:ring-0 transition outline-none">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Reference / Note
                    (Optional)</label>
                <textarea name="reference" rows="2" placeholder="Any specific instruction..."
                    class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-4 py-3 text-slate-200 placeholder:text-slate-600 focus:border-emerald-500/50 focus:ring-0 transition outline-none"></textarea>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit"
                    class="w-full h-[52px] bg-green-700 hover:bg-green-600 text-white font-black rounded-2xl transition flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                    <i class="ri-check-double-line text-lg"></i> Confirm Withdrawal
                </button>
            </div>
        </form>
    </div>
@endsection
