var urlController = 'Controllers/Curso.php';

function dados() {
    return {
        NOME: NOME.value
    };
}

function setDados($DADOS) {
    NOME.value = $DADOS.NOME;
}

function listar() {
    formReset();

    var $_POST = {
        ACAO: 'Listar'
    };

    var ajax = new XMLHttpRequest();
    ajax.open('POST', urlController);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        if ($RETORNO.status == 'ok') {
            $LISTA = $RETORNO.lista;
            var tr = '';
            if ($LISTA.length > 0) {
                for (var $dado of $LISTA) {
                    tr += '<tr>';
                    tr += ' <td>' + $dado.NOME + '</td>';
                    tr += ' <td> ';
                    tr += '  <button onclick="editar(' + $dado.ID_CURSO + ')">Editar</button>';
                    tr += '  <button descricao="' + $dado.NOME + '" onclick="excluir(' + $dado.ID_CURSO + ',this)">Excluir</button>';
                    tr += ' </td>';
                    tr += '</tr>';
                }
            } else {
                tr += '<tr><td colspan="3" style="text-align: center; color: blue">Sem dados</td></tr>';
            }
            TBODY.innerHTML = tr;
        } else {
            ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
        }
    }
    ajax.send(JSON.stringify($_POST));
}

//Listar
listar();