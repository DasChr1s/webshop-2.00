<?php

// app/Http/Middleware/BrowserLanguageMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class BrowserLanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        $defaultLocale = 'en';
        $browserLocale = $request->server('HTTP_ACCEPT_LANGUAGE');
        $locale = $defaultLocale;
        $supportedLocales = ['en', 'de'];
    
        if ($browserLocale) {
            $locales = explode(',', $browserLocale);
            $parsedLocales = [];
            
            foreach ($locales as $localeStr) {
                $parts = explode(';q=', $localeStr);
                $lang = $parts[0];
                $qValue = isset($parts[1]) ? (float)$parts[1] : 1.0;
                $parsedLocales[$lang] = $qValue;
            }
            
            arsort($parsedLocales);
            
            foreach ($parsedLocales as $lang => $qValue) {
                if (in_array($lang, $supportedLocales)) {
                    $locale = $lang;
                    break;
                }
            }
        }
    
    
        App::setLocale($locale);
    
        return $next($request);
    }
}
