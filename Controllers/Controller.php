<?

class Controller {

    public $retorno;
    protected $Model;
    protected $post;
    protected $colunaUnica = [];

    public function __construct() {

        $tabela = explode(' ', $this->tabela);
        $this->tabela = $tabela[0];
        $this->APELIDO = $tabela[1];

        $this->retorno = [
            'status' => 'erro',
            'mensagem' => 'Ação não confirmada',
            'lista' => [],
            'dado' => []
        ];

        try {
            $model = CLASSE . 'Model';
            $FileModel = "../Models/$model.php";
            if (!file_exists($FileModel)) {
                $this->retorno['status'] = 'erro';
                $this->retorno['mensagem'] = 'Classe não encontrada';
                return;
            }
            $this->acao($model, $FileModel);
        } catch (Exception $ex) {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = $ex->getMessage();
        }
    }

    private function acao($model, $FileModel) {
        require_once '../libs/Conexao.php';
        require_once '../Models/Model.php';
        require_once $FileModel;
        $DADOS = [
            'TABELA' => $this->tabela,
            'ID_CHAVE' => $this->ID_CHAVE,
            'ORDER' => $this->order,
            'APELIDO' => $this->APELIDO
        ];
        $this->Model = new $model($DADOS);
        $this->post = json_decode(file_get_contents('php://input'), true);
        $Metodo = METODO;
        if (method_exists($this, $Metodo)) {
            $this->$Metodo();
        } else {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = 'Método não existe';
        }
    }

    protected function listar() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = "$this->descricao(s) listado(a)s";
        $DADOS = $this->Model->listar();
        $this->retorno['lista'] = $DADOS;
    }

    protected function msgDescricaoColunaUnica() {
        $descricaoColuna = [];
        foreach ($this->colunaUnica as $coluna) {
            $descricaoColuna[] = explode('/', $coluna)[1];
        }
        return $descricaoColuna;
    }

    protected function incluir() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "$this->descricao " . implode(' ou ', $this->msgDescricaoColunaUnica()) . ' já existe';
        $existeDado = $this->valorExistente();
        if (!$existeDado) {
            $this->retorno['status'] = 'ok';
            $this->retorno['mensagem'] = $this->post['NOME'] . ' incluído(a)';
            $execute = $this->Model->incluir($this->tabela, $this->post);
        }
    }

    protected function excluir() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = $this->post['descricao'] . ' excluído(a)';
        $this->Model->addWhere($this->ID_CHAVE, CHAVE, 'updateExcluir');
        $execute = $this->Model->excluir($this->tabela);
    }

    protected function buscar() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = "$this->descricao listado(a)";
        $this->Model->addWhere($this->ID_CHAVE, CHAVE);
        $DADO = $this->Model->listar();
        $this->retorno['dado'] = @$DADO[0];
        if (!$DADO) {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = "$this->descricao não localizado(a)";
        }
    }

    protected function alterar() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "$this->descricao " . implode(' ou ', $this->msgDescricaoColunaUnica()) . ' já existe';
        $existeDado = $this->valorExistente();
        if (!$existeDado || $existeDado[$this->ID_CHAVE] == CHAVE) {
            $this->retorno['status'] = 'ok';
            $this->retorno['mensagem'] = $this->post['NOME'] . ' alterado(a)';
            $this->Model->addWhere($this->ID_CHAVE, CHAVE, 'updateExcluir');
            $execute = $this->Model->alterar($this->tabela, $this->post);
        }
    }

    protected function valorExistente() {
        $valores = [];
        foreach ($this->colunaUnica as $coluna) {
            $coluna = explode('/', $coluna)[0];
            $colunaPost = explode('.', $coluna)[1];
            $valores[$coluna] = $this->post[$colunaPost];
        }
        $this->Model->addWhereOr($valores);
        return @$this->Model->listar()[0];
    }

}
