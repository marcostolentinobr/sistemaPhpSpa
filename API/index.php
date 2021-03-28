<?

//Configurações do banco de dados
define('DB_LIB', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'CRUD');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

//require_once '../bd_crudPhpMvcPdoJs.php';

define('DB_CONVERTE_UTF8', FALSE);

//PRINT_R PRE
function pr($dado, $print_r = true) {
    echo '<pre>';
    if ($print_r) {
        print_r($dado);
    } else {
        var_dump($dado);
    }
}

//Se não for um vai o outro
function coalesce() {
    foreach (func_get_args() as $arg) {
        if (!empty($arg) || $arg === 0 || $arg === '0') {
            return $arg;
        }
    }
    return null;
}

//Eh sql serve?
function ehSqlServer() {
    if (DB_LIB == 'sqlsrv' || DB_LIB == 'dblib') {
        return true;
    }
    return false;
}

//URL
$url = [];
if (isset($_GET['pg'])) {
    $url = explode('/', $_GET['pg']);
}
define('CLASSE', isset($url[0]) ? $url[0] : '');
define('METODO', isset($url[1]) ? $url[1] : '');
define('CHAVE', isset($url[2]) ? $url[2] : '');

//Controller
$FileControler = '../Controllers/' . CLASSE . '.php';
require_once '../Controllers/Controller.php';
if (file_exists($FileControler)) {
    require_once $FileControler;
}

//Classe
$Classe = CLASSE;
if (class_exists($Classe)) {
    $Classe = new $Classe();
} else {
    $Classe = new Controller();
}
exit(json_encode($Classe->retorno));
