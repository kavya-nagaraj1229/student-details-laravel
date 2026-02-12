<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-6 rounded shadow w-80">
    <h2 class="text-xl font-bold mb-4 text-center">Login</h2>

    @if(session('error'))
        <p class="text-red-600 text-sm mb-3 text-center">
            {{ session('error') }}
        </p>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input type="text" name="username" placeholder="Username"
            class="w-full border p-2 rounded mb-3" required>

        <input type="password" name="password" placeholder="Password"
            class="w-full border p-2 rounded mb-4" required>

        <button class="w-full bg-blue-600 text-white py-2 rounded">
            Login
        </button>
    </form>
</div>

</body>
</html>
