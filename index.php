<?php

/*comentario de prueba para versionado*/
define('BASEURL',  (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])?  strtok($_SERVER['HTTP_X_FORWARDED_PROTO'], ','):'http') .'://' . $_SERVER['HTTP_HOST']. '/'. substr(pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME), 1) . '/' );

// Fix rapido a falta de intl
if(!function_exists('locale_set_default')) {
    function locale_set_default($a) {
    }
}

mkdir("Writable");
mkdir("Writable/cache");


// Defino la ruta base del sitio
define('ROOTPATH', __DIR__.'/');
/*
// Marco el sitio como entorno de desarollo si estas en modo servidor integrado
if(php_sapi_name() == 'cli-server') {
    define('ENVIRONMENT', 'development');
   
    if(!file_exists('Components/package-lock.json') or filemtime('Components/package-lock.json') < filemtime('Components/package.json') ) {
        shell_exec('npm install --prefix Components');
    }
    
    if(!file_exists('composer.lock') or filemtime('composer.lock') < filemtime('composer.json') ) {
        shell_exec('php composer.phar install');
    }
    
    
    function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);
    
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                getDirContents($path, $results);
                $results[] = $path;
            }
        }
    
        return $results;
    }
    
    
    
    
    $todos_los_archivos = getDirContents('Components');
    
    
    
    
    $todos_los_archivos = array_filter($todos_los_archivos, function($ruta) {
        $exclude = __DIR__. '/Components/node_modules/';
        return substr($ruta, 0, strlen($exclude)) != $exclude;
    });
    
    $ultima_modificacion_modulos = max(array_map('filemtime', $todos_los_archivos));
    

    if(!file_exists('Scripts/components.js') or $ultima_modificacion_modulos > filemtime('Scripts/components.js')) {
        chdir('Components');
        
        $salida_comando = array();
        $estado_comando = "";
        
        exec('webpack build', $salida_comando, $estado_comando);
        
        if($estado_comando)  {
            echo "<h1>ERROR DE COMPILACION DE REACT</h1>";
            echo "<pre>";
            
            foreach($salida_comando as $linea_del_comando) {
                echo htmlspecialchars("$linea_del_comando\n");
            }
            
            echo "</pre>";
            die;
        }

        chdir('..');
    }
} else {
    define('ENVIRONMENT', 'production');
}
*/
/*
require '/app/ThirdParty/autoload.php';
*/

// Valid PHP Version?
$minPHPVersion = '7.4';
if (phpversion() < $minPHPVersion)
{
	die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}
unset($minPHPVersion);


/*
// Check PHP version.
$minPhpVersion = '7.4'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}
*/

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);


// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);



/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '/app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

/*
 * ---------------------------------------------------------------
 * GRAB OUR CODEIGNITER INSTANCE
 * ---------------------------------------------------------------
 *
 * The CodeIgniter class contains the core functionality to make
 * the application run, and does all of the dirty work to get
 * the pieces all working together.
 */

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */

$app->run();
