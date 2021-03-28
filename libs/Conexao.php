<?

class Conexao {

    protected $pdo;

    public function __construct() {

        //GERAL
        $hostServer = ':host=' . DB_HOST;
        $nameDb = ';dbname=' . DB_NAME;
        $charset = ';charset=' . DB_CHARSET;

        //SQL SERVER 
        if (DB_LIB == 'sqlsrv') {
            $hostServer = ':Server=' . DB_HOST;
            $nameDb = ';Database=' . DB_NAME;
            $charset = '';
        }

        $this->pdo = new PDO(DB_LIB . $hostServer . $nameDb . $charset, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    protected function whereExecute($CONSULTA) {
        $retorno = [
            'where' => '',
            'execute' => [],
        ];

        $WHERE = [];
        foreach ($CONSULTA as $coluna => $valor) {
            $retorno['execute'][":$coluna"] = $valor;
            $WHERE[] = " $coluna = :$coluna";
        }

        if ($WHERE) {
            $retorno['where'] = ' WHERE ' . implode(' AND ', $WHERE);
        }

        return $retorno;
    }

}
