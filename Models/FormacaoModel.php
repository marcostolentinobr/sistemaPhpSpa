<?

class FormacaoModel extends Model {

    public function listar($CONSULTA = []) {
        $whereExecute = $this->whereExecute($CONSULTA);
        $sql = "
            SELECT F.$this->ID_CHAVE AS ID,
                   F.*
              FROM FORMACAO F
                   $whereExecute[where] 
           ORDER BY F.PONTO DESC
        ";

        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($whereExecute['execute']);

        $DADOS = $prepare->fetchAll(PDO::FETCH_ASSOC);
        return $DADOS;
    }

    public function incluir($DADOS) {
        $prepare = $this->pdo->prepare('
            INSERT INTO FORMACAO ( NOME, PONTO ) VALUES (:NOME, :PONTO)
        ');

        return $prepare->execute($DADOS);
    }

    public function excluir($DADOS) {
        $prepare = $this->pdo->prepare("
            DELETE FROM FORMACAO WHERE $this->ID_CHAVE = :$this->ID_CHAVE
        ");

        return $prepare->execute($DADOS);
    }

    public function alterar($DADOS) {
        $prepare = $this->pdo->prepare("
            UPDATE FORMACAO 
               SET NOME = :NOME,
                  PONTO = :PONTO
             WHERE $this->ID_CHAVE = :$this->ID_CHAVE
        ");

        return $prepare->execute($DADOS);
    }

}
