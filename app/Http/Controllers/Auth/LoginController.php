<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {

        foreach($user->getRoleNames() as $role){
            if($role === 'Admin') {
                return redirect()->intended(route('admin'));
            }
    
        }
        return redirect()->intended($this->redirectTo);
        
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }
 
    public function google_callback()
    {
        try {
     
            $user = Socialite::driver('google')->stateless()->user();
            /// lakukan pengecekan apakah google id nya sudah ada apa belum
            $isUser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();
            
            /// jika sudah ada, langsung login
            if($isUser){
                //jika belum ada google id maka langsung diisi
                if(!$isUser->google_id){
                    $isUser->google_id = $user->getId();
                    $isUser->email_verified_at = Carbon::now();
                    $isUser->photo_profile = $user->getAvatar();
                    $isUser->save();
                }

                Auth::login($isUser);
                return redirect($this->redirectTo);
 
            } else { /// jika belum ada, register baru
 
                $createUser = new User;
                $createUser->name =  $user->getName();
 
                /// mendapatkan email dari google
                if($user->getEmail() != null){
                    $createUser->email = $user->getEmail();
                    $createUser->email_verified_at = Carbon::now();
                    $createUser->photo_profile = $user->getAvatar();

                }  
                 
                /// tambahkan google id
                $createUser->google_id = $user->getId();
 
                /// membuat random password
                $rand = rand(111111,999999);
                $createUser->password = Hash::make($user->getName().$rand);
 
                /// save
                $createUser->assignRole('User');
                $createUser->save();
                /// login
                Auth::login($createUser);
                return redirect($this->redirectTo);
            }
     
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
