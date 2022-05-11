<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Role;

class LoginController extends Controller
{
    
    public function Login(Request $request){

        $userName = explode("@",$request->email)[0];
        $credenciales = $request->only('email' , 'password');
        if(1==2)//$this->authenticate($userName, $request->password) == true){
	{

            $user = User::where('email', '=', $request->email)->first();
            if($user === NULL)
            {
                $user = User::create([
                    'name' => $userName,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);                
                $user
                    ->roles()
                    ->attach(Role::where('name', 'user')->first());
            }
            Auth::loginUsingId($user->id);
            return redirect()->action('HomeController@index');
        }
        else // Intentar desde la base de datos
        {
             
            if(Auth::attempt($credenciales)){
                
                return redirect()->action('HomeController@index');
            }
            else{
                return redirect()->route('login')->with('ErrorLogin', 'Usuario y/o Contraseña Incorrecto.');
            }
            
        }
    }


    function authenticate($user, $password) {
       // if(empty($user) || empty($password)) return false;
     
        // active directory server
        $ldap_host = "ldap.forumsys.com";
        $ldapport = 389;


        $ldap_dn = "uid=".$user.",dc=example, dc=com";
        // connect to active directory
        $ldap = @ldap_connect($ldap_host, $ldapport) or die('no se puede conectar al servidor');
    
        // configure ldap params
        @ldap_set_option($ldap,LDAP_OPT_PROTOCOL_VERSION,3) or die ('error en los protocolos');
        @ldap_set_option($ldap,LDAP_OPT_REFERRALS,0) or die('error en protocolos');
     
        // verify user and password
        if($bind = @ldap_bind($ldap, $ldap_dn, $password)) {
            return true;

        } else {
            // invalid name or password
            return false;
        }
    }
}
