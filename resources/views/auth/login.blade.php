<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Desa Pebadaran</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0F1B33] min-h-screen flex flex-col justify-between items-center relative overflow-hidden">

    <div class="w-full flex-grow flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative z-10 overflow-hidden">
            <!-- Decorative accent -->
            <div class="absolute top-0 left-0 w-full h-2 bg-[#0F1D3A]"></div>
            
            <div class="text-center mb-8 mt-2">
                <img src="/img/logo-kampar.png" alt="Logo Desa" class="h-20 mx-auto mb-4 drop-shadow-md" onerror="this.src='https://via.placeholder.com/80?text=Logo'">
                <h1 class="text-2xl font-bold text-gray-800">Desa Pebadaran</h1>
                <p class="text-sm text-gray-500 font-medium tracking-wider mt-1">PANEL ADMINISTRASI</p>
            </div>

            @if(session('error') || $errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-6 flex items-center border border-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
            @endif

            @if(session('throttle'))
                <div class="bg-yellow-50 text-yellow-700 p-3 rounded-lg text-sm mb-6 flex items-center border border-yellow-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ session('throttle') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="text" name="email" id="email" value="{{ old('email', 'admin@desapebadaran.id') }}" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090] py-2.5 border" placeholder="admin@desapebadaran.id" required autofocus>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2E5090] focus:ring-[#2E5090] py-2.5 border" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#2E5090] hover:bg-[#1f3661] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2E5090] transition-colors duration-200">
                    Masuk
                </button>
            </form>

            <div class="mt-6 pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                <p class="font-medium text-gray-600 mb-1">Kredensial Default Login Admin:</p>
                <p>Email: <code class="bg-gray-100 text-navy-900 px-1.5 py-0.5 rounded font-mono text-[11px]">admin@desapebadaran.id</code></p>
                <p class="mt-0.5">Password: <code class="bg-gray-100 text-navy-900 px-1.5 py-0.5 rounded font-mono text-[11px]">admin123</code></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full py-4 text-center z-10 bg-[#0F1B33]/80 backdrop-blur-sm border-t border-white/10">
        <p class="text-sm text-gray-400">Dibuat oleh KUKERTA UNRI 2026</p>
    </footer>
</body>
</html>
