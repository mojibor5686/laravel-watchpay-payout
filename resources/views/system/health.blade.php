@extends('layouts.master')
@section('title', 'System Health')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                    <i class="ri-pulse-fill text-rose-500 animate-pulse"></i> System & Health
                </h1>
                <p class="text-slate-500 text-sm mt-2">আপনার সার্ভার এবং অ্যাপ্লিকেশনের বর্তমান অবস্থা মনিটর করুন।</p>
            </div>
            <div class="flex gap-2">
                <a href=""
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold uppercase transition border border-slate-700/50 flex items-center gap-2">
                    <i class="ri-refresh-line"></i> Refresh
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div class="bg-slate-800/40 border border-slate-700/50 p-5 rounded-3xl backdrop-blur-md">
                <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest mb-2">PHP Version</p>
                <div class="flex items-center gap-3">
                    <div class="text-blue-500 text-xl font-bold"><i class="ri-code-box-line"></i></div>
                    <h4 class="text-white font-bold text-lg">{{ phpversion() }}</h4>
                </div>
            </div>

            <div class="bg-slate-800/40 border border-slate-700/50 p-5 rounded-3xl backdrop-blur-md">
                <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest mb-2">Database</p>
                <div class="flex items-center gap-3">
                    <div class="text-emerald-500 text-xl font-bold"><i class="ri-database-2-line"></i></div>
                    <h4 class="text-white font-bold text-lg">Connected</h4>
                </div>
            </div>

            <div class="bg-slate-800/40 border border-slate-700/50 p-5 rounded-3xl backdrop-blur-md">
                <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest mb-2">Debug Mode</p>
                <div class="flex items-center gap-3">
                    <div class="{{ config('app.debug') ? 'text-rose-500' : 'text-emerald-500' }} text-xl font-bold">
                        <i class="ri-bug-line"></i>
                    </div>
                    <h4 class="text-white font-bold text-lg">{{ config('app.debug') ? 'On' : 'Off' }}</h4>
                </div>
            </div>

            <div class="bg-slate-800/40 border border-slate-700/50 p-5 rounded-3xl backdrop-blur-md">
                <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest mb-2">Environment</p>
                <div class="flex items-center gap-3">
                    <div class="text-amber-500 text-xl font-bold"><i class="ri-server-line"></i></div>
                    <h4 class="text-white font-bold text-lg">{{ ucfirst(app()->environment()) }}</h4>
                </div>
            </div>

            @php
                $disk_free = disk_free_space(base_path());
                $disk_total = disk_total_space(base_path());
                $disk_used = $disk_total - $disk_free;
                $disk_usage_percent = round(($disk_used / $disk_total) * 100);
            @endphp
            <div class="bg-slate-800/40 border border-slate-700/50 p-5 rounded-3xl backdrop-blur-md">
                <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest mb-2">Storage</p>
                <div class="flex items-center gap-3">
                    <div class="text-purple-500 text-xl font-bold"><i class="ri-hard-drive-2-line"></i></div>
                    <h4 class="text-white font-bold text-lg">{{ $disk_usage_percent }}%</h4>
                </div>
            </div>

            @php
                $mem_percent = 0;
                $mem_total_gb = 'N/A';
                if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                    $fh = fopen('/proc/meminfo', 'r');
                    $mem_total = 0;
                    $mem_free = 0;
                    if ($fh) {
                        while ($line = fgets($fh)) {
                            $pieces = [];
                            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                                $mem_total = $pieces[1];
                            }
                            if (preg_match('/^MemAvailable:\s+(\d+)\skB$/', $line, $pieces)) {
                                $mem_free = $pieces[1];
                            }
                        }
                        fclose($fh);
                    }
                    $mem_used = $mem_total - $mem_free;
                    $mem_percent = $mem_total > 0 ? round(($mem_used / $mem_total) * 100) : 0;
                    $mem_total_gb = round($mem_total / 1024 / 1024, 1) . 'GB';
                }
            @endphp
            <div class="bg-slate-800/40 border border-slate-700/50 p-5 rounded-3xl backdrop-blur-md">
                <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest mb-2">RAM Usage</p>
                <div class="flex items-center gap-3">
                    <div class="text-indigo-500 text-xl font-bold"><i class="ri-cpu-line"></i></div>
                    <h4 class="text-white font-bold text-lg">{{ $mem_percent > 0 ? $mem_percent . '%' : 'Local' }}</h4>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-6 backdrop-blur-md shadow-xl">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i class="ri-dashboard-3-line text-blue-500"></i> Hardware Resource Monitor
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-white text-xs font-bold">Disk Space Utilization</p>
                                    <p class="text-slate-500 text-[10px] mt-0.5">Total Capacity:
                                        {{ round($disk_total / 1024 / 1024 / 1024, 2) }} GB</p>
                                </div>
                                <p class="text-purple-400 font-mono text-xs font-bold">{{ $disk_usage_percent }}%</p>
                            </div>
                            <div class="w-full bg-slate-900 rounded-full h-2 border border-slate-700 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-full rounded-full"
                                    style="width: {{ $disk_usage_percent }}%"></div>
                            </div>
                            <p class="text-[10px] text-slate-500 tracking-wide text-right">Available:
                                {{ round($disk_free / 1024 / 1024 / 1024, 2) }} GB</p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-white text-xs font-bold">Memory (RAM) Usage</p>
                                    <p class="text-slate-500 text-[10px] mt-0.5">Server RAM: {{ $mem_total_gb }}</p>
                                </div>
                                <p class="text-indigo-400 font-mono text-xs font-bold">{{ $mem_percent }}%</p>
                            </div>
                            <div class="w-full bg-slate-900 rounded-full h-2 border border-slate-700 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-400 h-full rounded-full"
                                    style="width: {{ $mem_percent }}%"></div>
                            </div>
                            <p class="text-[10px] text-slate-500 tracking-wide text-right">Status:
                                {{ $mem_percent > 80 ? 'Critical' : 'Healthy' }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden shadow-xl backdrop-blur-md p-6">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="ri-settings-5-line text-blue-500"></i> Optimization & Maintenance
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div onclick="document.getElementById('clear-cache-form').submit();"
                            class="p-4 bg-slate-900/50 border border-slate-700/30 rounded-2xl flex items-center justify-between group hover:border-blue-500/50 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="text-blue-500 bg-blue-500/10 w-12 h-12 grid place-items-center rounded-lg">
                                    <i class="ri-flashlight-line"></i>
                                </div>
                                <div>
                                    <h5 class="text-white text-sm font-bold">Application Cache</h5>
                                    <p class="text-slate-500 text-[10px]">Clear all system cache</p>
                                </div>
                            </div>
                            <form id="clear-cache-form" action="{{ route('system.clearCache') }}" method="POST"
                                class="hidden">@csrf</form>
                            <button
                                class="text-[10px] font-black uppercase text-blue-500 group-hover:underline">Clear</button>
                        </div>

                        <div onclick="document.getElementById('clear-route-form').submit();"
                            class="p-4 bg-slate-900/50 border border-slate-700/30 rounded-2xl flex items-center justify-between group hover:border-emerald-500/50 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div
                                    class="text-emerald-500 bg-emerald-500/10 w-12 h-12 grid place-items-center rounded-lg">
                                    <i class="ri-route-line"></i>
                                </div>
                                <div>
                                    <h5 class="text-white text-sm font-bold">Route Cache</h5>
                                    <p class="text-slate-500 text-[10px]">Refresh system routes</p>
                                </div>
                            </div>
                            <form id="clear-route-form" action="{{ route('system.clearRoute') }}" method="POST"
                                class="hidden">@csrf</form>
                            <button
                                class="text-[10px] font-black uppercase text-emerald-500 group-hover:underline">Clear</button>
                        </div>

                        <div onclick="document.getElementById('clear-logs-form').submit();"
                            class="p-4 bg-slate-900/50 border border-slate-700/30 rounded-2xl flex items-center justify-between group hover:border-rose-500/50 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="text-rose-500 bg-rose-500/10 w-12 h-12 grid place-items-center rounded-lg">
                                    <i class="ri-file-list-3-line"></i>
                                </div>
                                <div>
                                    <h5 class="text-white text-sm font-bold">Error Logs</h5>
                                    <p class="text-slate-500 text-[10px]">Clear system error logs</p>
                                </div>
                            </div>
                            <form id="clear-logs-form" action="{{ route('system.clearLogs') }}" method="POST"
                                class="hidden">@csrf</form>
                            <button
                                class="text-[10px] font-black uppercase text-rose-500 group-hover:underline">Clean</button>
                        </div>

                        <div onclick="document.getElementById('storage-link-form').submit();"
                            class="p-4 bg-slate-900/50 border border-slate-700/30 rounded-2xl flex items-center justify-between group hover:border-amber-500/50 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="text-amber-500 bg-amber-500/10 w-12 h-12 grid place-items-center rounded-lg">
                                    <i class="ri-links-line"></i>
                                </div>
                                <div>
                                    <h5 class="text-white text-sm font-bold">Storage Link</h5>
                                    <p class="text-slate-500 text-[10px]">Fix missing images/files</p>
                                </div>
                            </div>
                            <form id="storage-link-form" action="{{ route('system.storageLink') }}" method="POST"
                                class="hidden">@csrf</form>
                            <button
                                class="text-[10px] font-black uppercase text-amber-500 group-hover:underline">Run</button>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden shadow-xl backdrop-blur-md">
                    <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-900/40">
                        <h3 class="text-white font-bold text-sm">Server Detailed Information</h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left text-sm">
                            <tbody class="divide-y divide-slate-700/30 text-slate-300">
                                <tr class="hover:bg-slate-700/20 transition">
                                    <td class="px-6 py-3 font-medium text-slate-500 uppercase text-[10px]">Server Software
                                    </td>
                                    <td class="px-6 py-3 font-mono text-xs">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-700/20 transition">
                                    <td class="px-6 py-3 font-medium text-slate-500 uppercase text-[10px]">Server IP</td>
                                    <td class="px-6 py-3 font-mono text-xs">{{ $_SERVER['SERVER_ADDR'] ?? '127.0.0.1' }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-700/20 transition">
                                    <td class="px-6 py-3 font-medium text-slate-500 uppercase text-[10px]">Protocol</td>
                                    <td class="px-6 py-3 font-mono text-xs">
                                        {{ $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-700/20 transition">
                                    <td class="px-6 py-3 font-medium text-slate-500 uppercase text-[10px]">Upload Max Size
                                    </td>
                                    <td class="px-6 py-3 font-mono text-xs">{{ ini_get('upload_max_filesize') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-6 backdrop-blur-md">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2 text-sm">
                        <i class="ri-shield-keyhole-line text-emerald-500"></i> Security Status
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">SSL Certificate</span>
                            <span
                                class="font-black bg-emerald-500/10 text-emerald-500 px-2 py-0.5 rounded uppercase">Active</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">App HTTPS</span>
                            <span
                                class="font-black {{ request()->isSecure() ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }} px-2 py-0.5 rounded uppercase">
                                {{ request()->isSecure() ? 'Secure' : 'Insecure' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Laravel Version</span>
                            <span
                                class="font-black bg-blue-500/10 text-blue-500 px-2 py-0.5 rounded uppercase">v{{ app()->version() }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-6 backdrop-blur-md">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2 text-sm">
                        <i class="ri-folder-lock-line text-amber-500"></i> Permissions
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">Storage Path</span>
                            <i
                                class="{{ is_writable(storage_path()) ? 'ri-checkbox-circle-fill text-emerald-500' : 'ri-close-circle-fill text-rose-500' }}"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">Bootstrap Cache</span>
                            <i
                                class="{{ is_writable(base_path('bootstrap/cache')) ? 'ri-checkbox-circle-fill text-emerald-500' : 'ri-close-circle-fill text-rose-500' }}"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-rose-500/5 border border-rose-500/20 rounded-3xl p-6">
                    <div class="flex items-start gap-3">
                        <i class="ri-error-warning-line text-rose-500 text-xl"></i>
                        <div>
                            <h4 class="text-rose-500 text-sm font-bold uppercase tracking-tight">System Notice</h4>
                            <p class="text-slate-500 text-xs mt-1 leading-relaxed">আপনার যদি সাইটে ইমেজ দেখতে সমস্যা হয় বা
                                নতুন কোনো রাউট কাজ না করে, তবে উপরের <b>Clear Cache</b> বাটনটি ব্যবহার করুন।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
