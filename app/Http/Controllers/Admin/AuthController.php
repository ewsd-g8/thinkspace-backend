<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' =>'required|email|exists:users,email',
            'password' => 'required|string|min:6'
        ]);
        
        $input = $request->only('email', 'password');

        $auth = Auth::attempt($input);

        if (!$auth) {
            return response()->error('The given data was invalid.', 422, ['password' => ['The password you entered is incorrect!']]);
        }

        $user = $request->user();

        if (! $user->is_active) {
            return response()->error("You don't have permission to access on this application.", Response::HTTP_FORBIDDEN, ['email' => ['Invalid user!']]);
        }

        Auth::guard('admin')->setUser($user);
        $data['access_token'] = $user->createToken('adminAuthToken')->plainTextToken;
        $data['user']['id'] = $user->id;
        $data['user']['name'] = $user->name;
        $data['user']['email'] = $user->email;
        $data['user']['mobile'] = $user->mobile;
        $data['user']['profile'] = $user->profile ? $user->profile : null;
        $data['roles'] = $user->getRoleNames();
        $data['permissions'] = $user->getPermissionsViaRoles()->pluck('name');

        return response()->success('Login Success!', Response::HTTP_OK, $data);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->currentAccessToken()->delete();
        }
        
        return response()->success('Successfully Logout', Response::HTTP_OK);
    }

    /**
     * Confirm password.
     *
     * @return \Illuminate\Http\Response
     */
    //  public function passwordConfirm(Request $request)
    //  {
    //      $password_confirmed = Hash::check($request->password, auth('admin')->user()->password);
    //      return response()->success(
    //          'Success',
    //          Response::HTTP_OK,
    //          $password_confirmed
    //      );
    //  }

    public function getAuthUser()
    {
        $user = auth()->user();
        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['profile'] = $user->profile ? $user->profile : null;
        // if ($user->profile) {
        //     $data['profile'] = (Storage::disk('s3')->exists($user->profile)) ? Storage::disk('s3')->url($user->profile) : null;
        // }

        return response()->success(
            'Success',
            Response::HTTP_OK,
            $data
        );
    }
}
