protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

    'checkLogin' => \App\Http\Middleware\CheckLogin::class,
];
