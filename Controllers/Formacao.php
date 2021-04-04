<?

class Formacao extends Controller {

    protected $descricao = 'Formação';
    protected $tabela = 'FORMACAO';
    protected $ID_CHAVE = 'ID_FORMACAO';
    protected $colunaUnica = ['F.NOME', 'F.PONTO'];

}
