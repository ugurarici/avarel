<?php

namespace App\Http\Middleware;

use Closure;

class Feyzlendir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $feyzliSozler = [
            "İtaat ettikleri zincirlerden aptalları serbest bırakmak zordur. Voltaire",
            "Dünyada iki farklı insan var, bilmek isteyenler ve inanmak isteyenler. Friedrich Nietzsche",
            "Engelsiz bir yol bulursanız, muhtemelen hiçbir yere gitmez. Frank A. Clark",
            "İntikam ve aşkta, kadın insandan daha barbardır. Friedrich Nietzsche",
        ];

        $request->feyzli_soz = collect($feyzliSozler)->random();

        return $next($request);
    }
}
