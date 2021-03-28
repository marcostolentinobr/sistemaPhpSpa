<?

class Curso extends Controller {

    protected $descricao = 'Curso';
    protected $tabela = 'CURSO';
    protected $ID_CHAVE = 'ID_CURSO';

    protected function incluir() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "Curso " . $this->post['NOME'] . ' já existe';
        $existeDado = $this->Model->listar(['NOME' => $this->post['NOME']]);
        if (!$existeDado) {
            parent::incluir();
        }
    }

    protected function alterar() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "Curso " . $this->post['NOME'] . ' já existe';
        $DADO = @$this->Model->listar(['NOME' => $this->post['NOME']])[0];
        if (!$DADO || $DADO[$this->ID_CHAVE] == CHAVE) {
            parent::alterar();
        }
    }

}
