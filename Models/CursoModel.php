<?

class CursoModel extends Conexao {

    public function listar($CONSULTA = []) {
        $whereExecute = $this->whereExecute($CONSULTA);
        $sql = "SELECT * FROM CURSO $whereExecute[where] ORDER BY NOME";

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
        $prepare = $this->pdo->prepare('
            DELETE FROM CURSO WHERE ID_CURSO = :ID_CURSO
        ');

        return $prepare->execute($DADOS);
    }

    public function alterar($DADOS) {
        $prepare = $this->pdo->prepare('
            UPDATE CURSO SET NOME = :NOME
             WHERE ID_CURSO = :ID_CURSO
        ');

        return $prepare->execute($DADOS);
    }

}
