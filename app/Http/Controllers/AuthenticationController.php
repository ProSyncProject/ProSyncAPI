<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class AuthenticationController extends Controller
{
    /**
     * Login a user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "User logged in successfully.", "data": UserResource}
     * @response array{"status": 401, "message": "Invalid credentials.", "data": null}
     * @unauthenticated
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $login = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $user = User::where($login, $request->login)->first();
            if (!$user || !password_verify($request->password, $user->password)) {
                return Response::error("Invalid credentials.", 403);
            }
            $token = $user->createToken("auth_token")->plainTextToken;
            $user->token = $token;
            $resource = new UserResource($user);
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success($resource, "User logged in successfully.");
    }
}
