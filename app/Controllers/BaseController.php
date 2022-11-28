<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	
	protected $session;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		$this->session = \Config\Services::session();

        $migrate = \Config\Services::migrations();
        $migrate->findMigrations() and $migrate->latest();
		
        // Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}
	
	private function get_authentication_config()
	{
	    $configfile = ROOTPATH. 'config.ini';
		
		if(file_exists($configfile))
		{
			$inifile = parse_ini_file($configfile, true);
			
			if(array_key_exists('authentication', $inifile))
			{
				return (object)$inifile['authentication'];
			}
		}
	}

    private function force_login()
    {
        if($config = $this->get_authentication_config())
        {
            $oidc = new \Jumbojett\OpenIDConnectClient($config->provider, $config->clientid, $config->clientsecret);
            
            $oidc->setRedirectURL(current_url());
            $oidc->addScope('profile');
            $oidc->addScope('email');
            $oidc->authenticate();
            
            $profile = $oidc->requestUserInfo();
        }
        else if(isset($_GET['code']))
        {
            $profiles = $this->profiles();
            foreach($profiles as $profile)
            {
                if($profile->sub == $_GET['code'])
                {
                    break;
                }
            }
        }
        else
        {
            echo view('login/select', array(
    			'profiles' => $this->profiles()
    		));
    		
            exit;
        }
        
        $this->session->set('sub', $profile->sub);
        $this->session->set('name', $profile->name);
        $this->session->set('email', $profile->email);
        $this->session->set('groups', isset($profile->groups) ? $profile->groups : array());
        
        throw new \CodeIgniter\Router\Exceptions\RedirectException('/');
    }

    private function profiles()
    {
        $approot = dirname($_SERVER['SCRIPT_FILENAME']);
	
		$profiles = json_decode(file_get_contents("$approot/profiles.json"));
		
		return $profiles;
    }
    
    protected function require_valid_user() 
    {
        if($this->session->get('sub') == null)
        {
            $this->force_login();
        }
    }
    
    protected function require_group($groupname)
    {
        $this->require_valid_user();
       
        if(!in_array($groupname, $this->session->get('groups')))
        {
            throw \CodeIgniter\Security\Exceptions\SecurityException::forDisallowedAction();
        }
    }
    
    protected function directory_search($username = null)
    {
        $configfile = ROOTPATH. 'config.ini';
		$config = null;
		
		
		if(file_exists($configfile))
		{
			$inifile = parse_ini_file($configfile, true);
			
			if(array_key_exists('directory', $inifile))
			{
				$config = (object)$inifile['directory'];
			}
		}

        if($config)
        {
            if($username == null) {
                $username = "*";
            }
            $ds=ldap_connect($config->hostname, $config->port);
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            $r=ldap_bind($ds, $config->admindn, $config->password);
            $sr=ldap_search($ds, $config->usersdn, $config->userid . "=$username"); 
            $entries = ldap_get_entries($ds, $sr);
            
            array_shift($entries);
            
            $entries = array_map(function($first) use($config) {
                $first = array_filter($first, function($k) { return !is_int($k); }, ARRAY_FILTER_USE_KEY);
                
                
                $first = array_map(function($item) use($config){
                    if(is_array($item)) {
                        array_shift($item);
                        
                        if(count($item) == 1) {
                            return $item[0];
                        } else {
                            return implode(',', $item);
                        }
                    }
                    
                    return $item;
                }, $first);

                $output = (object)array(
                    'id' => @$first[$config->userid],
                    'name' => @$first[$config->username],
                    'email' => @$first[$config->useremail],
                    'phone' => @$first[$config->userphone],
                    'sector' => @$first[$config->sector],
                    'position' => @$first[$config->position]
                );

                return $output;
            }, $entries);
            
            return $entries;
        }
        else
        {
            $rv = array();
            foreach(json_decode(file_get_contents(ROOTPATH. 'profiles.json')) as $entry) {
                if($username == null or $entry->sub == $username) {
                    $rv[] = (object)array(
                        'id' => $entry->sub,
                        'name' => $entry->name,
                        'email' => $entry->name,
                        'phone' => @$entry->phone
                    );
                }
            }
            return $rv;        
        }
    }
}
