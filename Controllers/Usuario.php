<?

class Usuario extends Controller {

    protected $descricao = 'Usuário';
    protected $tabela = 'USUARIO U';
    protected $ID_CHAVE = 'ID_USUARIO';
    protected $colunaUnica = ['C.CPF'];
    protected $order = 'C.NOME';

    protected function acessar() {
        $this->retorno['status'] = 'erro';
        $this->retorno['mensagem'] = "Credênciais inválidas";
        
        $this->Model->addWhere('CPF',$this->post['CPF']);
        $this->Model->addWhere('SENHA',$this->post['SENHA']);
        $USUARIO = @$this->Model->listar()[0];
        
        if ($USUARIO) {
            $this->retorno['status'] = 'ok';
            $this->retorno['mensagem'] = "Bem vindo(a) $USUARIO[NOME]";
            
            unset($USUARIO['SENHA']);
            $this->retorno['dado'] = $USUARIO;
        }
    }

}
