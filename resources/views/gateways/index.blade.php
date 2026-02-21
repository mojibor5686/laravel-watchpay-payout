@extends('layouts.master')
@section('title', 'Gateway Configuration')
@section('content')
    <div class="w-full space-y-6">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-indigo-500/10 text-indigo-500 rounded-2xl flex items-center justify-center border border-indigo-500/20 shadow-xl shadow-indigo-500/5">
                <i class="ri-shield-flash-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight uppercase">Gateway Settings</h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1">Single-point merchant
                    configuration</p>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-[32px] overflow-hidden backdrop-blur-md shadow-2xl">
            <div class="p-8 md:p-12">
                @php $gateway = $gateways->first(); @endphp

                <form action="{{ route('gateways.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label
                                class="text-[11px] font-black uppercase text-slate-400 tracking-widest ml-1 flex items-center gap-2">
                                <i class="ri-fingerprint-line text-indigo-500"></i> Merchant ID
                            </label>
                            <input type="text" name="merchant_id" value="{{ $gateway->merchant_id ?? '' }}" required
                                placeholder="e.g. 955789104"
                                class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 placeholder:text-slate-600 focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all outline-none font-medium">
                        </div>

                        <div class="space-y-3">
                            <label
                                class="text-[11px] font-black uppercase text-slate-400 tracking-widest ml-1 flex items-center gap-2">
                                <i class="ri-pulse-line text-emerald-500"></i> Operation Status
                            </label>
                            <div class="relative">
                                <select name="status"
                                    class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 focus:border-emerald-500/50 focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none appearance-none font-bold">
                                    <option value="active" {{ $gateway && $gateway->status == 'active' ? 'selected' : '' }}>
                                        Active Mode</option>
                                    <option value="inactive"
                                        {{ $gateway && $gateway->status == 'inactive' ? 'selected' : '' }}>Maintenance Mode
                                    </option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">
                                    <i class="ri-arrow-down-s-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[11px] font-black uppercase text-slate-400 tracking-widest ml-1 flex items-center gap-2">
                            <i class="ri-global-line text-blue-500"></i> Notification / Back URL
                        </label>
                        <input type="url" name="back_url" value="{{ $gateway->back_url ?? '' }}" required
                            placeholder="https://yourdomain.com/api/webhooks/withdraw/notify"
                            class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 placeholder:text-slate-600 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none font-medium">
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[11px] font-black uppercase text-slate-400 tracking-widest ml-1 flex items-center gap-2">
                            <i class="ri-key-2-line text-amber-500"></i> Secret Merchant Key
                        </label>
                        <div class="relative group">
                            <input type="password" name="merchant_key" id="merchant_key"
                                value="{{ $gateway->merchant_key ?? '' }}" required
                                placeholder="Enter your high-security gateway key"
                                class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 placeholder:text-slate-600 focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-mono tracking-widest">
                            <button type="button" onclick="toggleKey()"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition">
                                <i id="key-icon" class="ri-eye-close-line text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-700/30">
                        <button type="submit"
                            class="w-full md:w-max px-12 h-[60px] bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 flex items-center justify-center gap-3 uppercase tracking-[2px] text-xs">
                            <i class="ri-refresh-line text-xl"></i>
                            <span>Sync Configuration</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-amber-500/5 border border-amber-500/10 p-5 rounded-2xl flex gap-4 items-center">
            <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500 shrink-0">
                <i class="ri-lock-password-line text-xl"></i>
            </div>
            <p class="text-[11px] text-slate-400 font-medium leading-relaxed">
                By clicking <span class="text-slate-200 italic">"Sync Configuration"</span>, the system will update the
                back-url and merchant credentials. Ensure the <span class="text-slate-200 font-bold">Back URL</span> matches
                your server environment.
            </p>
        </div>
    </div>

    <script>
        function toggleKey() {
            const input = document.getElementById('merchant_key');
            const icon = document.getElementById('key-icon');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('ri-eye-close-line', 'ri-eye-line');
            } else {
                input.type = "password";
                icon.classList.replace('ri-eye-line', 'ri-eye-close-line');
            }
        }
    </script>
@endsection
