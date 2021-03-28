<?

class CursoModel extends Conexao {

    private $ID_CHAVE;

    public function __construct($ID_CHAVE) {
        parent::__construct();
        $this->ID_CHAVE = $ID_CHAVE;
    }

    public function listar($CONSULTA = []) {
        $whereExecute = $this->whereExecute($CONSULTA);
        $sql = "
            SELECT C.$this->ID_CHAVE AS ID,
                   C.* 
              FROM CURSO C 
                   $whereExecute[where] 
          ORDER BY C.NOME
        ";

        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($whereExecute['execute']);

        $DADOS = $prepare->fetchAll(PDO::FETCH_ASSOC);
        return $DADOS;
    }

    public function incluir($DADOS) {
        $prepare = $this->pdo->prepare('
            INSERT INTO CURSO ( NOME ) VALUES (:NOME)
        ');

        return $prepare->execute($DADOS);
    }

    public function excluir($DADOS) {
        $prepare = $this->pdo->prepare("
            DELETE FROM CURSO WHERE $this->ID_CHAVE = :$this->ID_CHAVE
        ");

        return $prepare->execute($DADOS);
    }

    public function alterar($DADOS) {
        $prepare = $this->pdo->prepare("
            UPDATE CURSO SET NOME = :NOME
             WHERE $this->ID_CHAVE = :$this->ID_CHAVE
        ");

        return $prepare->execute($DADOS);
    }

}
