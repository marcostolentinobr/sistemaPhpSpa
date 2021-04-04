ACAO_MSG_OK.textContent = '';
ACAO_MSG_ERRO.textContent = '';

var classe = document.currentScript.src.split('/')[6].replace('Script.js', '');
var urlController = 'api/' + classe;

var DADOS = [];
for (var dado of FORM.elements) {
    if (dado.id && dado.id != 'ACAO') {
        DADOS.push(dado.id);
    }
}

function listar() {
    formReset();
    var ajax = new XMLHttpRequest();
    ajax.overrideMimeType('application/json');
    ajax.open('GET', urlController + '/listar');
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        if ($RETORNO.status == 'ok') {
            $LISTA = $RETORNO.lista;
            var tr = '';
            if ($LISTA.length > 0) {
                for (var $dado of $LISTA) {
                    tr += '<tr>';
                    tr += ' <td>' + $dado.NOME + '</td>';
                    tr += ' <td>' + $dado.PONTO + '</td>';
                    tr += ' <td> ';
                    tr += '  <button onclick="editar(' + $dado.ID + ')">Editar</button>';
                    tr += '  <button descricao="' + $dado.NOME + '" onclick="excluir(' + $dado.ID + ',this)">Excluir</button>';
                    tr += ' </td>';
                    tr += '</tr>';
                }
            } else {
                tr += '<tr><td colspan="100%" style="text-align: center; color: blue">Sem dados</td></tr>';
            }
            TBODY.innerHTML = tr;
        } else {
            ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
        }
    }
    ajax.send();
}
listar();