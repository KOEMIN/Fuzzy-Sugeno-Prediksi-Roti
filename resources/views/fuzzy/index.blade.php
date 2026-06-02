<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Produksi Roti | Fuzzy Sugeno</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen flex items-center justify-center p-6 text-slate-800">

    <div class="max-w-xl w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-cyan-600 mb-2">
                Prediksi Produksi Roti
            </h1>
            <p class="text-slate-500 font-medium">Logika Fuzzy Metode Sugeno</p>
        </div>

        <!-- Main Form Card -->
        <div class="glass-card rounded-2xl shadow-xl shadow-indigo-100/50 p-8 mb-6 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-100">
            <form action="{{ route('fuzzy.calculate') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Input Permintaan -->
                <div>
                    <label for="permintaan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah Permintaan <span class="text-xs font-normal text-slate-400 ml-1">(1000 - 1600)</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="permintaan" name="permintaan" 
                               value="{{ old('permintaan', $permintaan ?? '') }}" 
                               min="1000" max="1600" required
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 focus:bg-white text-slate-700 placeholder-slate-400"
                               placeholder="Masukkan nilai permintaan...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 font-medium text-sm">
                            Bungkus
                        </div>
                    </div>
                    @error('permintaan')
                        <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Persediaan -->
                <div>
                    <label for="persediaan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah Persediaan <span class="text-xs font-normal text-slate-400 ml-1">(600 - 900)</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="persediaan" name="persediaan" 
                               value="{{ old('persediaan', $persediaan ?? '') }}" 
                               min="600" max="900" required
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 focus:bg-white text-slate-700 placeholder-slate-400"
                               placeholder="Masukkan nilai persediaan...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 font-medium text-sm">
                            Bungkus
                        </div>
                    </div>
                    @error('persediaan')
                        <p class="text-rose-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-700 hover:to-cyan-700 text-white font-semibold py-3.5 px-6 rounded-lg shadow-lg shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                    Hitung Prediksi Produksi
                </button>
            </form>
        </div>

        <!-- Result Card -->
        @if(isset($prediksiProduksi))
        <div class="glass-card rounded-2xl p-8 border-l-4 border-l-cyan-500 shadow-lg shadow-cyan-100/50 animate-[fadeIn_0.5s_ease-out]">
            <div class="flex flex-col items-center justify-center text-center">
                <span class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Hasil Prediksi Produksi</span>
                <div class="flex items-baseline justify-center space-x-2">
                    <span class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-600">
                        {{ $prediksiProduksi }}
                    </span>
                    <span class="text-xl font-medium text-slate-600">Bungkus</span>
                </div>
                
                <div class="mt-6 flex items-center justify-center space-x-6 text-sm text-slate-500 bg-white/60 rounded-full px-6 py-2">
                    <div>Permintaan: <span class="font-semibold text-slate-700">{{ $permintaan }}</span></div>
                    <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                    <div>Persediaan: <span class="font-semibold text-slate-700">{{ $persediaan }}</span></div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Footer Info -->
        <p class="text-center text-slate-400 text-sm mt-8">
            Berdasarkan Studi Kasus Pabrik Roti Sarinda
        </p>

    </div>

</body>
</html>
