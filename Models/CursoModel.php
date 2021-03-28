<?

class CursoModel extends Model {

    public function listar($where = []) {
        $sql = "
            SELECT C.$this->ID_CHAVE AS ID,
                   C.*
              FROM CURSO C
        ";
        $this->addOrder('C.NOME');
        $DADOS = $this->listaRetorno($sql, $where);
        return $DADOS;
    }

    /*
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
     */
}
