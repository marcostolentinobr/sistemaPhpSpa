<?

//Configurações do banco de dados
  //Conteudo do bd.php
  define('DB_LIB', 'mysql');
  define('DB_HOST', '127.0.0.1');
  define('DB_NAME', 'CRUD');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_CHARSET', 'utf8');
 
//PRINT_R PRE
function pr($dado, $print_r = true) {
    echo '<pre>';
    if ($print_r) {
        print_r($dado);
    } else {
        var_dump($dado);
    }
}

require_once 'Controller.php';

class Curso extends Controller {

    private $descricao = 'Curso';
    private $ID_CHAVE = 'ID_CURSO';
    private $model = 'CursoModel';

    private function dados() {
        return [
            'NOME' => $this->post['NOME']
        ];
    }

    public function __construct() {
        parent::__construct($this->model);

        try {

            //LISTAR
            if (@$this->post['ACAO'] == 'Listar') {
                $this->retorno['status'] = 'ok';
                $this->retorno['mensagem'] = "$this->descricao(s) listado(a)s";

                $DADOS = $this->Model->listar();
                //pr($DADOS); exit('<br>Curso post[ACAO] = listar');
                $this->retorno['lista'] = $DADOS;
            }
            //INCLUIR
            elseif (@$this->post['ACAO'] == 'Incluir') {
                $this->retorno['status'] = 'erro';
                $this->retorno['mensagem'] = $this->post['NOME'] . ' já existe';

                $existeDado = $this->Model->listar(['NOME' => $this->post['NOME']]);
                if (!$existeDado) {
                    $DADOS = $this->dados();
                    $execute = $this->Model->incluir($DADOS);

                    $this->retorno['status'] = 'ok';
                    $this->retorno['mensagem'] = $this->post['NOME'] . ' incluído(a)';
                }
            }
            //EXCLUIR
            elseif (@$this->post['ACAO'] == 'Excluir') {
                $this->retorno['status'] = 'ok';
                $this->retorno['mensagem'] = $this->post['descricao'] . ' excluído(a)';
                $execute = $this->Model->excluir([$this->ID_CHAVE => $this->post['ID']]);
            }
            //Consulta
            elseif (@$this->post['ACAO'] == 'Buscar') {
                $this->retorno['status'] = 'ok';
                $this->retorno['mensagem'] = "$this->descricao listado(a)";

                $DADO = $this->Model->listar([$this->ID_CHAVE => $this->post['ID']]);
                $this->retorno['dado'] = $DADO[0];

                if (!$DADO) {
                    $this->retorno['status'] = 'erro';
                    $this->retorno['mensagem'] = "$this->descricao não localizado(a)";
                }
            }
            //ALTERAR
            elseif (@$this->post['ACAO'] == 'Alterar') {
                $this->retorno['status'] = 'erro';
                $this->retorno['mensagem'] = $this->post['NOME'] . ' já existe';

                $DADO = @$this->Model->listar(['NOME' => $this->post['NOME']])[0];
                if (!$DADO || $DADO[$this->ID_CHAVE] == $this->post['ID']) {
                    $this->retorno['status'] = 'ok';
                    $this->retorno['mensagem'] = $this->post['NOME'] . ' alterado(a)';

                    $DADOS = $this->dados();
                    $DADOS[$this->ID_CHAVE] = $this->post['ID'];
                    $execute = $this->Model->alterar($DADOS);
                }
            }
        } catch (Exception $ex) {
            $this->retorno = [
                'status' => 'erro',
                'mensagem' => $ex->getMessage()
            ];
        }

        exit(json_encode($this->retorno));
    }

}

$Curso = new Curso();
