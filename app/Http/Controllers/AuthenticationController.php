<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Mail\Auth\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            $user = User::where($login, $request->login)->firstOrFail();
            if (!$user || !password_verify($request->password, $user->password)) {
                return Response::validate("password", "Invalid credentials.", 422);
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
     * Send Forgot Password OTP (through Email)
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "Email sent successfully.", "data": array{"login": "achyut", "success": true}}
     * @unauthenticated
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $login = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $user = User::where($login, $request->login)->firstOrFail();

            $otp = random_int(100000, 999999);
            $user->otpCodes()->create([
                'otp' => $otp,
                'type' => 'reset_password'
            ]);

            Mail::to($user->email)->queue(new ResetPasswordEmail([
                'otp' => $otp,
                'name' => $user->full_name
            ]));

        } catch (\Exception $exception) {
            return Response::error($exception);
        }
        $response = [
            'login' => $request->login,
            'success' => true
        ];
        return Response::success($response, "Email sent successfully.");
    }

    /**
     * Reset the password
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "Password reset successfully.", "data": array{"login": "achyut", "success": true}}
     * @response array{"status": 404, "message": "Invalid OTP."}
     * @unauthenticated
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $login = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $user = User::where($login, $request->login)->firstOrFail();
            $otp = $user->otpCodes()->where('otp', $request->otp)->orderBy('created_at', 'desc')->first();
            if (!$otp) {
                return Response::validate("otp", "Invalid OTP.", 404);
            }
            if ($otp->created_at->diffInMinutes(now()) > 5) {
                return Response::validate("otp", "OTP has expired.", 422);
            }
            if (password_verify($request->password, $user->password)) {
                return Response::validate("password", "New password cannot be the same as the old password.", 422);
            }
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            $otp->delete();
        } catch (\Exception $e) {
            return Response::error($e);
        }
        $response = [
            'success' => true,
            'login' => $request->login
        ];
        return Response::success($response, "Password reset successfully.");
    }

    /**
     * Verify the access token
     *
     * @return JsonResponse<bool>
     * @response array{"status": 200, "message": "Token is valid.", "data": true}
     */
    public function echo(): JsonResponse
    {
        return Response::success(true, null);
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
        return Response::success($resource);
    }

    /**
     * Refresh the access token
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "Token refreshed successfully.", "data": UserResource}
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $request->user()->currentAccessToken()->delete();

            $token = $user->createToken("auth_token")->plainTextToken;
            $user->token = $token;
            $resource = new UserResource($user);
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success($resource, "Token refreshed successfully.");
    }

    /**
     * Change the password
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "Password changed successfully."}
     */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed'
            ]);
            $user = $request->user();
            if (!password_verify($request->old_password, $user->password)) {
                return Response::validate("old_password", "Old password is incorrect.", 422);
            }
            if (password_verify($request->new_password, $user->password)) {
                return Response::validate("new_password", "New password cannot be the same as the old password.", 422);
            }
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success(null, "Password changed successfully.");
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

    /**
     * Assign a user to Github
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "User assigned to Github successfully."}
     */
    public function github(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->update([
                'firebase_id' => $request->firebase_id,
                'github_id' => $request->github_id,
                'github_token' => $request->github_token,
                'github_refresh_token' => $request->github_refresh_token,
                'github_username' => $request->github_username,
            ]);
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success(null, "Github authorized successfully.");
    }

    /**
     * Login a user using Github
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{"status": 200, "message": "User logged in using Github successfully.", "data": UserResource}
     */
    public function githubLogin(Request $request): JsonResponse
    {
        try {
            $user = User::where('github_id', $request->github_id)->first();
            if (!$user) {
                Response::validate("login", "No user found with the given Github ID.");
            }
            $token = $user->createToken("auth_token")->plainTextToken;
            $user->token = $token;
            $resource = new UserResource($user);
        } catch (\Exception $e) {
            return Response::error($e);
        }
        return Response::success($resource, "User logged in using Github successfully.");
    }
}
