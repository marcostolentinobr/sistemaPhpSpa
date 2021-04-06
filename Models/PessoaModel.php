<?

class PessoaModel extends Model {

    public function listar() {
        $sql = "
            SELECT P.$this->ID_CHAVE AS ID,
                   P.*,
                   (SELECT COUNT(*) FROM PESSOA_FORMACAO PF WHERE PF.ID_PESSOA = P.ID_PESSOA) AS FORMACAO_QUANTIDADE,
                   (    SELECT COALESCE(SUM(F.PONTO),0) 
                          FROM PESSOA_FORMACAO PF 
                          JOIN FORMACAO F
                            ON F.ID_FORMACAO = PF.ID_FORMACAO
                          WHERE PF.ID_PESSOA = P.ID_PESSOA
                    ) AS FORMACAO_PONTOS,
                   C.NOME AS CUR_NOME
              FROM PESSOA P
              JOIN CURSO C
                ON C.ID_CURSO = P.ID_CURSO
        ";
        $this->addOrder('P.NOME');
        $DADOS = $this->listaRetorno($sql);
        return $DADOS;
    }

}
