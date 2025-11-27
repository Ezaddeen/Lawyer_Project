<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // تسجيل الدخول
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
            }

            $user = Auth::user();

            if (!$user->is_active) {
                JWTAuth::invalidate($token);
                return response()->json(['message' => 'الحساب غير مفعل'], 403);
            }

            $user->update(['last_login' => now()]);

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles ? $user->roles->pluck('name') : [],
                ],
                'token' => $token,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إنشاء التوكن',
                'error' => $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ غير متوقع أثناء تسجيل الدخول',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // بيانات المستخدم
    public function me()
    {
        try {
            $user = Auth::user();
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء جلب بيانات المستخدم',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // تسجيل الخروج
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء تسجيل الخروج',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
