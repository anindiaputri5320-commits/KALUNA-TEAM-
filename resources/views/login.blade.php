<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KALUNA Digital Cash</title>
    <!-- Tailwind CSS & Font Poppins -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #fdf2f4; 
        }
        .pink-gradient {
            background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Card Login Pink Aesthetic -->
    <div class="bg-white rounded-3xl shadow-xl shadow-rose-100 border border-pink-100 p-8 sm:p-10 w-full max-w-md relative overflow-hidden">
        
        <!-- Hiasan Lingkaran Pink Soft Background -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-rose-50 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-50 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Header Brand KALUNA -->
        <div class="text-center mb-8 relative z-10">
            <div class="w-16 h-16 rounded-3xl bg-rose-50 border border-pink-100 flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm">
                🌸
            </div>
            <h1 class="text-3xl font-black text-gray-800 tracking-wide">KALUNA</h1>
            <!-- Slogan Bersih Tanpa Nama Sekolah -->
            <p class="text-xs text-gray-400 mt-1.5 font-medium">Kas Lunas Terpenuhi</p>
        </div>

        <!-- Alert Error Jika Login Gagal -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center space-x-1">
                        <span>⚠️</span>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5 relative z-10">
            @csrf

            <!-- Input Username -->
            <div>
                <label for="username" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                    USERNAME
                </label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    value="{{ old('username') }}" 
                    placeholder="Masukkan username..." 
                    required 
                    autofocus
                    class="w-full px-4 py-3.5 rounded-2xl border border-pink-200 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all"
                >
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                    PASSWORD
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Masukkan password..." 
                    required 
                    class="w-full px-4 py-3.5 rounded-2xl border border-pink-200 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all"
                >
            </div>

            <!-- Tombol Masuk -->
            <button 
                type="submit" 
                class="w-full pink-gradient hover:opacity-95 text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-rose-200 transition-all active:scale-95 mt-2 flex items-center justify-center space-x-2"
            >
                <span>Masuk ke Dashboard</span>
                <span>✨</span>
            </button>
        </form>

        <!-- Footer Card -->
        <div class="mt-8 text-center border-t border-pink-50 pt-5 relative z-10">
            <p class="text-[11px] text-gray-400">
                Sistem Kas Digital — Dibuat oleh <span class="font-bold text-rose-500">Anindia & Dita</span>
            </p>
        </div>

    </div>

</body>
</html>