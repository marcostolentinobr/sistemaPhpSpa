<?

class CursoModel extends Model {

    public function listar() {
        $sql = "
            SELECT C.$this->ID_CHAVE AS ID,
                   C.*
              FROM CURSO C
        ";
        $this->addOrder('C.NOME');
        $DADOS = $this->listaRetorno($sql);
        return $DADOS;
    }

}
