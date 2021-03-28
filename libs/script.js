//Menu
new Router([
    new Route('Curso'),
    new Route('Formacao')
]);

function dados() {
    var retorno = {};
    for (var dado of DADOS) {
        retorno[dado] = document.getElementById(dado).value;
    }
    return retorno;
}

function setDados($DADOS) {
    for (var dado of DADOS) {
        document.getElementById(dado).value = $DADOS[dado];
    }
}

function formReset() {
    ACAO_TITULO.innerHTML = 'Incluir'
    ACAO.value = 'Incluir'
    FORM.setAttribute('onsubmit', 'return incluir()');
    FORM.reset();
}

function retorno(resposta) {
    var $RETORNO = JSON.parse(resposta);
    if ($RETORNO.status == 'ok') {
        ACAO_MSG_OK.textContent = $RETORNO.mensagem;
        ACAO_MSG_ERRO.textContent = '';
        listar();
    } else {
        ACAO_MSG_OK.textContent = '';
        ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
    }
}

function incluir() {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', urlController + '/incluir');
    ajax.onload = function () {
        retorno(ajax.responseText)
    }
    ajax.send(JSON.stringify(dados()));
    return false;
}

function excluir(id, elemento) {
    var descricao = elemento.getAttribute('descricao');
    if (confirm('Confirma exclusão de ' + descricao + ' ?')) {
        var ajax = new XMLHttpRequest();
        ajax.open('DELETE', urlController + '/excluir/' + id);
        ajax.onload = function () {
            retorno(ajax.responseText);
        }
        ajax.send(JSON.stringify({descricao: descricao}));
    }
    return false;
}

function editar(id) {
    var ajax = new XMLHttpRequest();
    ajax.open('GET', urlController + '/buscar/' + id);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        var $DADO = $RETORNO.dado;
        if ($RETORNO.status == 'ok') {
            setDados($DADO);
            ACAO_TITULO.innerHTML = 'Alterar'
            ACAO.value = 'Alterar'
            FORM.setAttribute('onsubmit', 'return alterar(' + $DADO.ID + ')');
        } else {
            ACAO_MSG_OK.textContent = '';
            ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
        }
    }
    ajax.send(JSON.stringify());
    return false;
}

function alterar(id) {
    var ajax = new XMLHttpRequest();
    ajax.open('PUT', urlController + '/alterar/' + id);
    ajax.onload = function () {
        retorno(ajax.responseText);
    }
    ajax.onerror = function () {
        alert('teste erro');
    }
    ajax.onabort = function () {
        alert('teste aborto');
    }
    ajax.ontimeout = function () {
        alert('teste tempo');
    }
    ajax.send(JSON.stringify(dados()));
    return false;
}