<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasirinAja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <aside class="hidden md:flex md:flex-col w-64 bg-blue-600 text-white">
            <div class="p-6 border-b border-blue-500">
                <h1 class="font-bold text-2xl">KasirinAja</h1>
            </div>
            <nav class="flex-1 px-4 py-6">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="block px-3 py-2 rounded hover:bg-blue-500">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('kategori.index') }}" class="block px-3 py-2 rounded hover:bg-blue-500">Kategori</a>
                    </li>
                    <li>
                        <a href="{{ route('produk.index') }}" class="block px-3 py-2 rounded hover:bg-blue-500">Produk</a>
                    </li>
                    <li>
                        <a href="{{ route('customers.index') }}" class="block px-3 py-2 rounded hover:bg-blue-500">Pelanggan</a>
                    </li>
                    <li>
                        <a href="{{ route('transaksi.index') }}" class="block px-3 py-2 rounded hover:bg-blue-500">Transaksi</a>
                    </li>
                </ul>
            </nav>
            <div class="p-4 border-t border-blue-500">
                <a href="{{ route('logout') }}" class="text-red-200 hover:underline">Logout</a>
            </div>
        </aside>

        <nav class="md:hidden bg-blue-600 p-4 text-white w-full">
            <div class="flex items-center justify-between">
                <h1 class="font-bold text-lg">KasirinAja</h1>
                <div class="space-x-3">
                    <a href="{{ route('produk.index') }}" class="text-sm">Produk</a>
                    <a href="{{ route('customers.index') }}" class="text-sm">Pelanggan</a>
                    <a href="{{ route('transaksi.index') }}" class="text-sm">Transaksi</a>
                </div>
            </div>
        </nav>

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
    @include('sweetalert2::index')
</body>
</html>