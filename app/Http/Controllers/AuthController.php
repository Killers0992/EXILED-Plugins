<?php
namespace App\Http\Controllers;

use Invisnik\LaravelSteamAuth\SteamAuth;
use App\User;
use Auth;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;

class AuthController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected $steam;

    /**
     * The redirect URL.
     *
     * @var string
     */
    protected $redirectURL = '/';

    /**
     * AuthController constructor.
     * 
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    /**
     * Redirect the user to the authentication page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToSteam()
    {
        return $this->steam->redirect();
    }

    /**
     * Get user info and log in
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle()
    {
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();

            if (!is_null($info)) {
                $user = $this->findOrNewUser($info);

                if(is_null($user))
                {
                    return redirect(route('accessdenied'));
                } else {
                    Auth::login($user, true);
                    return redirect($this->redirectURL); // redirect to site
                }
            }
        }
        return $this->redirectToSteam();
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }

    /**
     * Getting user by info or created if not exists
     *
     * @param $info
     * @return User
     */
    protected function findOrNewUser($info)
    {
        $steamid = $info->steamID64;
        $user = User::where('id', $steamid)->first();
        if (!is_null($user)) {
            $user->nickname = $info->personaname;
            $user->profile_url = $info->avatarfull;
            $user->save();
            return $user;
        }

        $user = new User();
        $user->id = $steamid;
        $user->nickname = $info->personaname;
        $user->profile_url = $info->avatarfull;
        $user->save();
        $role = Role::where('name', '=', 'User')->first(); 
        $user->attachRole($role);
        return $user;
    }

    public function getAvatarUrl($steamid){
        $ch = curl_init('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.env('STEAM_API_KEY','').'&steamids='.$steamid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = json_decode(curl_exec($ch));

        curl_close($ch);
        return $data->response->players[0]->avatarfull;
    }
}