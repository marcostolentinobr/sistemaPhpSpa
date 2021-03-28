var DADOS = ['NOME'];
var classe = document.currentScript.src.split('/')[6].replace('Script.js', '');
var urlController = 'api/' + classe;

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
    ajax.send();
}
listar();