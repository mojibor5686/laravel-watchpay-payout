@extends('layouts.master')
@section('title', 'System Settings')
@section('content')
    <div class="w-full space-y-6 pb-10">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-orange-500/10 text-orange-500 rounded-2xl flex items-center justify-center border border-orange-500/20 shadow-xl shadow-orange-500/5 text-2xl">
                <i class="ri-user-settings-line"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight uppercase">Account Settings</h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[2px] mt-1">Manage your identity and
                    security credentials</p>
            </div>
        </div>

        <form action="{{ route('setting.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-slate-800/40 border border-slate-700/50 rounded-[32px] overflow-hidden backdrop-blur-md">
                <div class="p-8 space-y-6">
                    <h3 class="text-xs font-black text-orange-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="ri-profile-line"></i> Basic Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Full
                                Name</label>
                            <input type="text" name="name" value="{{ $user->name ?? '' }}" required
                                class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 outline-none focus:border-orange-500/50 transition-all font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Email
                                Address</label>
                            <input type="email" name="email" value="{{ $user->email ?? '' }}" required
                                class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 outline-none focus:border-orange-500/50 transition-all font-medium">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/40 border border-slate-700/50 rounded-[32px] overflow-hidden backdrop-blur-md">
                <div class="p-8 space-y-6">
                    <h3 class="text-xs font-black text-rose-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="ri-lock-password-line"></i> Password & Security
                    </h3>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1 text-rose-500/80">Current
                                Password (Required for change)</label>
                            <input type="password" name="old_password" placeholder="••••••••"
                                class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 outline-none focus:border-rose-500/50 transition-all font-mono tracking-widest">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">New
                                    Password</label>
                                <input type="password" name="new_password" placeholder="••••••••"
                                    class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 outline-none focus:border-orange-500/50 transition-all font-mono tracking-widest">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest ml-1">Confirm
                                    New Password</label>
                                <input type="password" name="new_password_confirmation" placeholder="••••••••"
                                    class="w-full bg-slate-900/60 border border-slate-700/50 rounded-2xl px-5 py-4 text-slate-200 outline-none focus:border-orange-500/50 transition-all font-mono tracking-widest">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-10 h-[60px] bg-orange-600 hover:bg-orange-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-orange-500/20 flex items-center gap-3 uppercase tracking-widest text-xs">
                    <i class="ri-save-3-line text-xl"></i>
                    Update Settings
                </button>
            </div>
        </form>
    </div>
@endsection
