<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-6 rounded shadow w-full max-w-sm">
    <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>

    @if(session('error'))
        <p class="bg-red-100 text-red-700 p-2 mb-4 rounded">{{ session('error') }}</p>
    @endif

    <form action="{{ route('login.submit') }}" method="POST" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm font-semibold">Username</label>
            <input type="text" name="username" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-semibold">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Login
        </button>
    </form>
</div>
</body>
</html>
