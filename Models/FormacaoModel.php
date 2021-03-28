<?

class FormacaoModel extends Model {

    public function listar() {
        $sql = "
            SELECT F.$this->ID_CHAVE AS ID,
                   F.*
              FROM FORMACAO F
        ";
        $this->addOrder('F.PONTO');
        $DADOS = $this->listaRetorno($sql);
        return $DADOS;
    }

}
