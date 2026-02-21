<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PayGate Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f3f4f9] text-gray-900">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">PayGate Admin</h2>
                <p class="text-gray-500 mt-2 text-sm font-medium">Gateway Management Portal</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-10 border border-gray-100">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email"
                            class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Admin
                            Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none placeholder-gray-400"
                            placeholder="admin@paygate.com">
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label for="password"
                                class="block text-xs font-bold uppercase tracking-wider text-gray-500">Password</label>
                            <a href="#"
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Forgot?</a>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none placeholder-gray-400"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me"
                            class="ml-2 block text-sm text-gray-600 font-medium cursor-pointer">Keep me signed
                            in</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-indigo-200 transform active:scale-[0.98] transition-all duration-150">
                        Login to Dashboard
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-400">Authorized personnel only. Secure connection 256-bit AES.</p>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-widest">&copy; {{ date('Y') }}
                    PayGate Systems Ltd.</p>
            </div>
        </div>
    </div>

</body>

</html>
