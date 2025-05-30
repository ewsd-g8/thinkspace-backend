<?php

namespace App\Http\Controllers\Admin;

use App\Mail\WelcomeEmail;
use App\Models\Department;
use App\Models\User;
use App\Models\Browser;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' =>'required|email|exists:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if (!$user->is_active) {
                    return response()->error("Account is not active. Please contact admin to login.", Response::HTTP_FORBIDDEN, ['email' => ['Inactive account!']]);
                }

                $department = Department::where('id', $user->department_id)->first();
                $agent = new Agent();
                $browser = Browser::firstOrCreate(
                    ['name' => $agent->browser()],
                    ['color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))]
                );
                $user->browsers()->syncWithoutDetaching([$browser->id]);

                Auth::guard('admin')->setUser($user);
                $data['access_token'] = $user->createToken('adminAuthToken')->accessToken;
                $data['user']['id'] = $user->id;
                $data['user']['name'] = $user->name;
                $data['user']['email'] = $user->email;
                $data['user']['mobile'] = $user->mobile;
                $data['user']['profile'] = $user->profile ? $user->profile : null;
                $data['user']['last_logout_at'] = $user->last_logout_at ? $user->last_logout_at : null;
                $data['department']['id'] = $user->department_id;
                $data['department']['name'] = $department->name;
                $data['roles'] = $user->getRoleNames();
                $data['permissions'] = $user->getPermissionsViaRoles()->pluck('name');

                if(is_null($user->last_logout_at)) {
                    Mail::to($user->email)->send(new WelcomeEmail($user));
                }

                return response()->success('Login Success!', Response::HTTP_OK, $data);
            } else {
                return response()->error('The given data was invalid.', Response::HTTP_UNPROCESSABLE_ENTITY, ['password' => ['Password is incorrect!']]);
            }
        } else {
            return response()->error('User Not Found', Response::HTTP_NOT_FOUND, ['email' => ['User Not Found!']]);
        }

        
        // $input = $request->only('email', 'password');

        // $auth = Auth::attempt($input);

        // if (!$auth) {
        //     return response()->error('The given data was invalid.', 422, ['password' => ['The password you entered is incorrect!']]);
        // }

        // $user = $request->user();

        // if (! $user->is_active) {
        //     return response()->error("You don't have permission to access on this application.", Response::HTTP_FORBIDDEN, ['email' => ['Invalid user!']]);
        // }

        // Auth::guard('admin')->setUser($user);
        // $data['access_token'] = $user->createToken('adminAuthToken')->accessToken;
        // $data['user']['id'] = $user->id;
        // $data['user']['name'] = $user->name;
        // $data['user']['email'] = $user->email;
        // $data['user']['mobile'] = $user->mobile;
        // $data['user']['profile'] = $user->profile ? $user->profile : null;
        // $data['roles'] = $user->getRoleNames();
        // $data['permissions'] = $user->getPermissionsViaRoles()->pluck('name');

        // return response()->success('Login Success!', Response::HTTP_OK, $data);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->update(['last_logout_at' => now()]);
            $request->user()->tokens()->delete();
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
        $data['is_blocked'] = $user->is_blocked;
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
