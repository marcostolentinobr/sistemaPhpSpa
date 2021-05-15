<?

class Curso extends Controller {

    protected $descricao = 'Curso';
    protected $tabela = 'CURSO C';
    protected $ID_CHAVE = 'ID_CURSO';
    protected $order = 'C.NOME';
    protected $colunaUnica = ['C.NOME/Nome'];

}
