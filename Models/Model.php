<?

class Model extends Conexao {

    protected $ID_CHAVE;
    protected $tabela;
    protected $valorBuscar;
    protected $APELIDO;
    protected $orderPadrao;
    public $paginacao = false;
    public $pagina_total = 8;
    public $keyChave = false;

    public function __construct($model) {
        parent::__construct();
        $this->tabela = $model['TABELA'];
        $this->ID_CHAVE = $model['ID_CHAVE'];
        $this->APELIDO = $model['APELIDO'];
        if ($model['ORDER']) {
            $this->orderPadrao = $model['ORDER'];
        }
    }

    public function listar() {
        $sql = "
            SELECT $this->APELIDO.$this->ID_CHAVE AS ID,
                   $this->APELIDO.*
              FROM $this->tabela $this->APELIDO
        ";
        $this->addOrder($this->orderPadrao);
        $DADOS = $this->listaRetorno($sql);
        return $DADOS;
    }

    protected function listaRetorno($sql) {

        //Orendação
        if (isset($_GET['order'])) {
            $campoOrder = explode('@', $_GET['order']);
            $this->order = array_merge(["$campoOrder[0] $campoOrder[1]"], $this->order);
        }

        $limit = '';
        if ($this->paginacao) {
            $inicio = (coalesce(@$_GET['pagina'], 1) - 1) * $this->pagina_total;
            $limit = " LIMIT $inicio,$this->pagina_total ";
            if (ehSqlServer()) {
                if (!$this->order) {
                    $this->addOrder("$this->ID_CHAVE DESC");
                }
                $limit = " OFFSET $inicio ROWS FETCH NEXT $this->pagina_total ROWS ONLY ";
            }
        }
        $retorno = $this->getListar($sql, $limit);
        if ($retorno && $this->keyChave) {
            $retornoNovo = [];
            foreach ($retorno as $dado) {
                $retornoNovo[$dado[$this->ID_CHAVE]] = $dado;
            }
            $retorno = $retornoNovo;
        }

        $this->linhasTotalMomento = $this->linhasTotal;

        //Apenas para declarar a quantidade de totais de linhas sem a paginação
        if ($this->paginacao) {
            $this->getListar($sql);
        }
        return $retorno;
    }

}
