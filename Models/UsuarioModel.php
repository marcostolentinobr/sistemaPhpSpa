<?

class UsuarioModel extends Model {

    public function listar() {
        $sql = "
            SELECT C.$this->ID_CHAVE AS ID,
                   C.*
              FROM USUARIO C
        ";
        $this->addOrder('C.NOME');
        $DADOS = $this->listaRetorno($sql);
        return $DADOS;
    }

}
