<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lubuk Hitam') - Tiket Air Terjun Lubuk Hitam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .animate-fadeIn { animation: fadeIn 0.5s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        
        .navbar-scrolled {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .toast {
            animation: slideInRight 0.3s ease-out;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .water-gradient {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 40%, #0369a1 100%);
        }
        .tropical-gradient {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 30%, #0891b2 60%, #0284c7 100%);
        }
        .gold-accent {
            background: linear-gradient(135deg, #d97706, #f59e0b);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('beranda') }}" class="text-2xl font-bold text-teal-700 flex items-center">
                    <svg class="w-7 h-7 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                    Lubuk Hitam
                </a>
                
                @auth
                <!-- Logged In Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('beranda') }}" class="text-gray-700 hover:text-teal-600 transition-colors font-medium">Beranda</a>
                    <a href="{{ route('tiket.index') }}" class="text-gray-700 hover:text-teal-600 transition-colors font-medium">Tiket Air Terjun</a>
                    <a href="{{ route('pesanan.index') }}" class="text-gray-700 hover:text-teal-600 transition-colors font-medium">Pesanan Saya</a>
                    <div class="relative group">
                        <button class="flex items-center text-gray-700 hover:text-emerald-600 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center mr-2">
                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50 rounded-t-lg">Dashboard Admin</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-teal-50 rounded-b-lg">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
                <button id="mobileMenuBtn" class="md:hidden text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                @endauth
            </div>
        </div>
        
        <!-- Mobile Menu (only for logged in users) -->
        @auth
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-2 space-y-2">
                <a href="{{ route('beranda') }}" class="block py-2 text-gray-700 hover:text-teal-600">Beranda</a>
                <a href="{{ route('tiket.index') }}" class="block py-2 text-gray-700 hover:text-teal-600">Tiket Air Terjun</a>
                <a href="{{ route('pesanan.index') }}" class="block py-2 text-gray-700 hover:text-teal-600">Pesanan Saya</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700 hover:text-teal-600">Dashboard Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-gray-700 hover:text-teal-600">Logout</button>
                </form>
            </div>
        </div>
        @endauth
    </nav>

    <!-- Toast Notifications -->
    @if(session('success'))
        <div class="toast fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="toast fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Content -->
    <main>
        @auth
        <div class="fixed inset-0 z-0 pointer-events-none" style="background: linear-gradient(rgba(249,250,251,0.88), rgba(249,250,251,0.92)), url('{{ asset('images/bg-dashboard.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;"></div>
        <div class="relative z-10">
            @yield('content')
        </div>
        @else
        @yield('content')
        @endauth
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-gradient-to-b from-gray-800 to-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                        Air Terjun Lubuk Hitam
                    </h3>
                    <p class="text-gray-300">Nikmati keindahan air terjun Lubuk Hitam yang menakjubkan. Pesan tiket sekarang dan rasakan pengalaman wisata alam yang tak terlupakan.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li>WhatsApp: +62 812-3456-7890</li>
                        <li>Telepon: +62 812-3456-7890</li>
                        <li>IG: @air terjun lubuk hitam</li>
                        <li>Alamat: Jl. Air Terjun No. 123</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Jam Operasional</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li>Senin - Kamis: 08:00 - 17:00</li>
                        <li>Jumas: 13.30 - 17.00</li>
                        <li>Sabtu - Minggu: 07:00 - 18:00</li>
                        <li>Hari Libur: 07:00 - 18:00</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-teal-800 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2026 Air Terjun Lubuk Hitam. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const menu = document.getElementById('mobileMenu');
                menu.classList.toggle('hidden');
            });
        }

        // Auto-hide toast after 3 seconds
        setTimeout(function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                toast.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => toast.remove(), 300);
            });
        }, 3000);
    </script>
    @stack('scripts')
</body>
</html>
