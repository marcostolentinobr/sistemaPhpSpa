<?

class Controller {

    protected $retorno;
    protected $Model;
    protected $post;

    public function __construct() {

        $this->retorno = [
            'status' => 'erro',
            'mensagem' => 'Ação não confirmada',
            'lista' => [],
            'dado' => []
        ];

        try {
            $model = CLASSE . 'Model';
            require_once "../Models/$model.php";
            $this->Model = new $model([$this->tabela, $this->ID_CHAVE]);
            $this->post = json_decode(file_get_contents('php://input'), true);
            $Metodo = METODO;
            if (method_exists($this, $Metodo)) {
                $this->$Metodo();
            } else {
                $this->retorno['status'] = 'erro';
                $this->retorno['mensagem'] = 'Método não existe';
            }
        } catch (Exception $ex) {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = $ex->getMessage();
        }
        exit(json_encode($this->retorno));
    }

    protected function listar() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = "$this->descricao(s) listado(a)s";
        $DADOS = $this->Model->listar();
        $this->retorno['lista'] = $DADOS;
    }

    protected function incluir() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = $this->post['NOME'] . ' incluído(a)';
        $execute = $this->Model->incluir($this->tabela, $this->post);
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
        $DADO = $this->Model->listar([$this->ID_CHAVE => CHAVE]);
        $this->retorno['dado'] = @$DADO[0];
        if (!$DADO) {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = "$this->descricao não localizado(a)";
        }
    }

    protected function alterar() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = $this->post['NOME'] . ' alterado(a)';
        $this->Model->addWhere($this->ID_CHAVE, CHAVE, 'updateExcluir');
        $execute = $this->Model->alterar($this->tabela, $this->post);
    }

}
