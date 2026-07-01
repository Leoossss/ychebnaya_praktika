<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Мотосалон') }} — Админ-панель</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .stat-card-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-card-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 1.5rem;
        }
        .sidebar-link.active {
            background: rgba(99, 102, 241, 0.2);
            border-left: 3px solid #6366f1;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 sidebar-gradient text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                        <i class="ri-motorbike-line text-2xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg">Мотосалон</div>
                        <div class="text-xs text-gray-400">Админ-панель</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 py-6 overflow-y-auto">
                <div class="px-4 mb-2 text-xs text-gray-400 uppercase tracking-wider">Основное</div>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'active text-white' : '' }}">
                    <i class="ri-dashboard-line mr-3 text-xl"></i>
                    <span>Дашборд</span>
                </a>

                <div class="px-4 mt-6 mb-2 text-xs text-gray-400 uppercase tracking-wider">Управление</div>
                
                <a href="{{ route('admin.motorcycles.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.motorcycles.*') ? 'active text-white' : '' }}">
                    <i class="ri-motorbike-line mr-3 text-xl"></i>
                    <span>Мотоциклы</span>
                    <span class="ml-auto bg-indigo-500 text-xs px-2 py-1 rounded-full">{{ \App\Models\Motorcycle::count() }}</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.categories.*') ? 'active text-white' : '' }}">
                    <i class="ri-price-tag-3-line mr-3 text-xl"></i>
                    <span>Категории</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.orders.*') ? 'active text-white' : '' }}">
                    <i class="ri-shopping-bag-3-line mr-3 text-xl"></i>
                    <span>Заказы</span>
                    @php
                        $newOrdersCount = \App\Models\Order::where('status', 'new')->count();
                    @endphp
                    @if($newOrdersCount > 0)
                        <span class="ml-auto bg-red-500 text-xs px-2 py-1 rounded-full">{{ $newOrdersCount }}</span>
                    @endif
                </a>

                <div class="px-4 mt-6 mb-2 text-xs text-gray-400 uppercase tracking-wider">Магазин</div>
                
                <a href="{{ route('home') }}" target="_blank" 
                   class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                    <i class="ri-external-link-line mr-3 text-xl"></i>
                    <span>Перейти в магазин</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Администратор</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white" title="Выйти">
                            <i class="ri-logout-box-line text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            {{ $header ?? 'Админ-панель' }}
                        </h1>
                        @if(isset($subheader))
                            <p class="text-sm text-gray-500 mt-1">{{ $subheader }}</p>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" target="_blank" 
                           class="text-gray-500 hover:text-gray-700 flex items-center space-x-2 bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">
                            <i class="ri-external-link-line"></i>
                            <span class="hidden sm:inline">Магазин</span>
                        </a>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ now()->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center">
                        <i class="ri-check-line text-green-500 text-xl mr-3"></i>
                        <div class="text-green-700">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-center">
                        <i class="ri-error-warning-line text-red-500 text-xl mr-3"></i>
                        <div class="text-red-700">{{ session('error') }}</div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>