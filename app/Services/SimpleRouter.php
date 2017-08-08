<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-8-8
 * Time: 下午2:17
 */

namespace App\Services;


use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class SimpleRouter extends Router
{
    public function getRoute($uri)
    {
        $uri = '/courses/1?a=b';
//        $this->t($uri);
        $method = 'GET';
        $parameters = [];
        $cookies = [];
        $files = [];
        $server = [];
        $symfonyRequest = SymfonyRequest::create(
            $this->prepareUrlForRequest($uri), $method, $parameters,
            $cookies, $files,  $server, null
        );
        $request = Request::createFromBase($symfonyRequest);
        $this->dispatchToRoute($request);
//        $route = $this->findRoute($request);
//
//        $request->setRouteResolver(function () use ($route) {
//            return $route;
//        });
        return $request->route();
    }

    protected function prepareUrlForRequest($uri)
    {
        if (Str::startsWith($uri, '/')) {
            $uri = substr($uri, 1);
        }

        if (!Str::startsWith($uri, 'http')) {
            $uri = config('app.url') . '/' . $uri;
        }

        return trim($uri, '/');
    }
}