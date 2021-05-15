<?

class Pessoa extends Controller {

    protected $descricao = 'Pessoa';
    protected $tabela = 'PESSOA P';
    protected $ID_CHAVE = 'ID_PESSOA';
    protected $order = 'F.NOME';
    protected $colunaUnica = ['P.NOME/Nome'];

    protected function incluir() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "$this->descricao " . implode(' ou ', $this->msgDescricaoColunaUnica()) . ' já existe';
        $existeDado = $this->valorExistente();
        if (!$existeDado) {
            $this->retorno['status'] = 'ok';
            $this->retorno['mensagem'] = $this->post['NOME'] . ' incluído(a)';

            $FORMACAO = $this->post['ID_FORMACAO'];
            unset($this->post['ID_FORMACAO']);

            $this->post['ID_USUARIO'] = 1;
            $execute = $this->Model->incluir($this->tabela, $this->post);

            $id_pessoa = $this->Model->ultimoInsertId();
            $this->PessoaFormacaoExcluirIncluir($FORMACAO, $id_pessoa);
        }
    }

    protected function alterar() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "$this->descricao " . implode(' ou ', $this->msgDescricaoColunaUnica()) . ' já existe';
        $existeDado = $this->valorExistente();
        if (!$existeDado || $existeDado[$this->ID_CHAVE] == CHAVE) {
            $this->retorno['status'] = 'ok';
            $this->retorno['mensagem'] = $this->post['NOME'] . ' alterado(a)';

            $FORMACAO = $this->post['ID_FORMACAO'];
            unset($this->post['ID_FORMACAO']);

            $this->post['ID_USUARIO'] = 1;
            $this->Model->addWhere($this->ID_CHAVE, CHAVE, 'updateExcluir');
            $execute = $this->Model->alterar($this->tabela, $this->post);

            $this->PessoaFormacaoExcluirIncluir($FORMACAO, CHAVE);
        }
    }

    protected function excluir() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = $this->post['descricao'] . ' excluído(a)';

        //PESSOA_FORMACAO
        $this->Model->addWhere($this->ID_CHAVE, CHAVE, 'updateExcluir');
        $execute = $this->Model->excluir('PESSOA_FORMACAO');

        //PESSOA
        $this->Model->addWhere($this->ID_CHAVE, CHAVE, 'updateExcluir');
        $execute = $this->Model->excluir($this->tabela);
    }

    private function PessoaFormacaoExcluirIncluir($DADOS, $idChave) {
        $this->Model->addWhere($this->ID_CHAVE, $idChave, 'updateExcluir');
        $execute = $this->Model->excluir('PESSOA_FORMACAO');
        foreach ($DADOS as $idDados) {
            $DADO = [
                'ID_PESSOA' => $idChave,
                'ID_FORMACAO' => $idDados
            ];
            $execute = $this->Model->incluir('PESSOA_FORMACAO', $DADO);
        }
    }

    protected function PessoaFormacaoListar() {
        $this->retorno['status'] = 'ok';
        $this->retorno['mensagem'] = 'PESSOA_FORMACAO listado(a)s';
        $this->Model->addWhere($this->ID_CHAVE, CHAVE);
        $DADOS = $this->Model->getListar('SELECT * FROM PESSOA_FORMACAO');
        $this->retorno['lista'] = $DADOS;
    }

}
