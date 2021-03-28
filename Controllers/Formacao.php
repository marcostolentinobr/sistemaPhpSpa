<?

class Formacao extends Controller {

    protected $descricao = 'Formação';
    protected $ID_CHAVE = 'ID_FORMACAO';
    protected $model = 'FormacaoModel';

    protected function incluir() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "$this->descricao " . $this->post['NOME'] . ' já existe';

        $existeDado = $this->Model->listar(['NOME' => $this->post['NOME']]);
        if (!$existeDado) {
            parent::incluir();
        }
    }

    protected function alterar() {

        //NOME já existe?
        $DADO = @$this->Model->listar(['NOME' => $this->post['NOME']])[0];
        if ($DADO && $DADO[$this->ID_CHAVE] != CHAVE) {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = "$this->descricao " . $this->post['NOME'] . ' já existe';
            return false;
        }

        //PONTO já existe?
        $DADO = @$this->Model->listar(['PONTO' => $this->post['PONTO']])[0];
        if ($DADO && $DADO[$this->ID_CHAVE] != CHAVE) {
            $this->retorno['status'] = 'erro';
            $this->retorno['mensagem'] = "Ponto " . $this->post['PONTO'] . ' já existe';
            return false;
        }

        parent::alterar();
    }

}
