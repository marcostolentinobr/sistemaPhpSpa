<?

class Model extends Conexao {

    protected $ID_CHAVE;
    protected $tabela;
    protected $valorBuscar;
    public $paginacao = true;
    public $pagina_total = 8;
    public $keyChave = false;

    public function __construct($model) {
        parent::__construct();
        $this->tabela = $model[0];
        $this->ID_CHAVE = $model[1];
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
