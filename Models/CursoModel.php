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

}
