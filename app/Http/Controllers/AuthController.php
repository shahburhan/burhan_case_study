<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Check for a valid user and return a token
     *
     * @param LoginRequest $request
     * @return string
     */
    public function __invoke(LoginRequest $request)
    {
        //Attempt to login user with validated request data
        if (auth()->attempt($request->validated())) {

            //Add same session cart to logged in user
            CartController::associateSessionCartWithUser();

            return response()->json($this->getToken());
        }

        // Credentials didn't match
        return response()->json(['message'=> 'Invalid credentials'], 401);
    }

    /**
     * Generate token for user
     *
     * @return array
     */
    public function getToken()
    {
        return [
            'token' => auth()->user()->createToken(request()->server('HTTP_USER_AGENT'))->plainTextToken
        ];
    }
}
