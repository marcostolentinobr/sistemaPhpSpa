<?

class Formacao extends Controller {

    protected $descricao = 'Formação';
    protected $tabela = 'FORMACAO F';
    protected $ID_CHAVE = 'ID_FORMACAO';
    protected $order = 'F.PONTO';
    protected $colunaUnica = ['F.NOME/Nome', 'F.PONTO/Ponto'];

}
