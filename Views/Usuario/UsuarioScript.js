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

function retorno(resposta) {
    var $RETORNO = JSON.parse(resposta);
    if ($RETORNO.status == 'ok') {
        ACAO_MSG_OK.textContent = $RETORNO.mensagem;
        ACAO_MSG_ERRO.textContent = '';
        localStorage.setItem('usuario', JSON.stringify($RETORNO.dado));
        hideAcesso();
    } else {
        ACAO_MSG_OK.textContent = '';
        ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
    }
}

function acessar() {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', urlController + '/acessar');
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        retorno(ajax.responseText, false);
    }
    ajax.send(JSON.stringify(dados()));
    return false;
}

function hideAcesso() {
    if (localStorage.getItem('usuario')) {
        FORM.style.display = 'none';
        menuSair.style.display = 'inline';
    }
}

hideAcesso();
tela();