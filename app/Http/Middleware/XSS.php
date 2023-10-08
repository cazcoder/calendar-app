<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
//use Illuminate\Support\Facades\Log;
//use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class XSS 
{

    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);
            $input = trim(preg_replace("'<script[^>]*>.*?</script>'si", '', $input)); //This completely strips out any content between script tags
            $input = preg_replace('/<!--.+?-->/', '', $input); //remove comments
        });

        $request->merge($input);
        
        return $next($request);
    }
}