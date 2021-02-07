<?php

namespace App\Http\Middleware;

use Closure;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Cache;

class EnsureTokenIsValid
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
       
        $signer = new Sha256();
        $value = Cache::get('Authorization');
        if(is_null($value)){
            return response()->json(['message' => 'No token given'], 401);
        }
        $token = (new Parser())->parse($value); // Parses from a string
        
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer('http://example.com');
        $data->setAudience('http://example.org');
        $data->setId('4f1g23a12aa');
        $data->setCurrentTime(time()+ 10080);
        if (!$token->validate($data)) {
            return response()->json(['message' => 'wrong token'], 401);
        }
        if (!$token->verify($signer, 'testing')) {
            return response()->json(['message' => 'Unauthorized sign'], 401);
        }
        return $next($request);
    }
}
