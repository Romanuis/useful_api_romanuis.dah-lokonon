<?php
protected $routeMiddleware = [
    'module.active' => \App\Http\Middleware\CheckModuleActive::class,
];