<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Builder;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!is_null($request->input('users'))){
        foreach($request->input('users') as $user)
        {
            if(is_null($user['first_name']) || is_null($user['last_name']) ){
                return response()->json(['message' => 'Both First and Last names have to be filled!'], 409);
            }
            $fullname[] =['full_name' => $user['first_name'].' '.$user['last_name']];
        }
        return response()->json(['users' => $fullname], 200);
    }
        else {
            return response()->json(['message' => 'No users given!'], 409);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $signer = new Sha256();
            $token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
                ->setAudience('http://example.org') // Configures the audience (aud claim)
                ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                ->setIssuedAt(time()) // Configures the time that the token was issued (iat claim)
                ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
                ->setExpiration(time() + 2629743) // Configures the expiration time of the token (exp claim)
                ->set('uid', 1) // Configures a new claim, called 'uid'
                ->sign($signer, 'testing') // creates a signature using 'testing' as key
                ->getToken(); // Retrieves the generated token

            $token->getHeaders(); // Retrieves the token headers
            $token->getClaims(); // Retrieves the token claims
          
            //return response()->json((string)$token, 200);
            Cache::put('Authorization', (string)$token, now()->addMinutes(5));
            return redirect('/api/users');
    }

    
}
