<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthenticationController extends Controller
{
    /**
     * Login a user
     *
     * @param LoginRequest $request
     * @return JsonResponse<UserResource>
     * @response array{"status": 200, "message": "User logged in successfully.", "data": UserResource}
     * @response array{"status": 401, "message": "Invalid credentials.", "data": null}
     * @response array{"status": 422, "message": "The given data was invalid.", "data": null}
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

    /**
     * Verify the access token
     *
     * @return JsonResponse<bool>
     * @response array{"status": 200, "message": "Token is valid.", "data": true}
     */
    public function echo(): JsonResponse
    {
        return Response::success(true, "Token is valid.");
    }

    /**
     * Get the authenticated user profile
     *
     * @return JsonResponse
     * @response array{"status": 200, "message": "User profile fetched successfully.", "data": UserResource}
     */
    public function profile(): JsonResponse
    {
        try {
            $user = User::findOrFail(auth()->id());
            $resource = new UserResource($user);
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success($resource, "User profile fetched successfully.");
    }

    /**
     * Logout a user
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "User logged out successfully."}
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success(null, "User logged out successfully.");
    }
}
