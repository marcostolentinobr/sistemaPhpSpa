<?

//Configurações do banco de dados
define('DB_LIB', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'CRUD');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

//require_once '../bd_crudPhpMvcPdoJs.php';
//PRINT_R PRE
function pr($dado, $print_r = true) {
    echo '<pre>';
    if ($print_r) {
        print_r($dado);
    } else {
        var_dump($dado);
    }
}

//URL
$url = [];
if (isset($_GET['pg'])) {
    $url = explode('/', $_GET['pg']);
}
define('CLASSE', isset($url[0]) ? $url[0] : '');
define('METODO', isset($url[1]) ? $url[1] : '');
define('CHAVE', isset($url[2]) ? $url[2] : '');

//Model
$FileModel = '../Models/' . CLASSE . 'Model.php';
if (file_exists($FileModel)) {
    require_once '../libs/Conexao.php';
    //require_once '../Models/Model.php';
    require_once $FileModel;
}

//Controller
$FileControler = '../Controllers/' . CLASSE . '.php';
if (file_exists($FileControler)) {
    require_once '../Controllers/Controller.php';
    require_once $FileControler;
}

//Classe
$Classe = CLASSE;
if (class_exists($Classe)) {
    $Classe = new $Classe();
}