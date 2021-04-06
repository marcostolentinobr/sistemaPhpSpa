var ROUTE = [];
for (var dado of document.querySelectorAll('nav a')) {
    ROUTE.push(new Route(dado.href.split('#')[1]));
}
new Router(ROUTE);

function dados() {
    var retorno = {};
    for (var dado of DADOS) {
        var element = document.getElementById(dado);
        retorno[dado] = element.value;
        if (element.nodeName == 'SELECT' && element.hasAttribute('multiple')) {
            var OPTIONS = document.querySelectorAll('#' + dado + ' option:checked');
            retorno[dado] = [];
            OPTIONS.forEach(function (element, index) {
                retorno[dado][index] = element.value;
            });
        }
    }
    return retorno;
}

function setDados($DADOS, id) {
    for (var dado of DADOS) {
        document.getElementById(dado).value = $DADOS[dado];
    }
    editarOutros(id);
}

function editarOutros(id) {

}

function setOption(apiEndereco, ID, descricao) {
    if (descricao == undefined) {
        descricao = 'NOME';
    }
    var ajax = new XMLHttpRequest();
    ajax.open('GET', 'api/' + apiEndereco);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        if ($RETORNO.status == 'ok') {
            $LISTA = $RETORNO.lista;
            if ($LISTA.length > 0) {
                for (var $dado of $LISTA) {
                    var option = document.createElement("option");
                    option.text = $dado[descricao];
                    option.value = $dado[ID];
                    option.id = $dado[ID];
                    document.getElementById(ID).add(option);
                }
            }
        }
    }
    ajax.send();
}

function formReset() {
    ACAO_TITULO.innerHTML = 'Incluir'
    ACAO.value = 'Incluir'
    FORM.setAttribute('onsubmit', 'return incluir()');
    FORM.reset();
    for (var dado of FORM.elements) {
        if (dado.nodeName == 'SELECT' && dado.hasAttribute('multiple')) {
            var OPTIONS = document.querySelectorAll('#' + dado.id + ' option:checked');
            OPTIONS.forEach(function (element, index) {
                element.removeAttribute('selected');
            });
        }
    }
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
    formReset();
    var ajax = new XMLHttpRequest();
    ajax.open('GET', urlController + '/buscar/' + id);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        $DADO = $RETORNO.dado;
        if ($RETORNO.status == 'ok') {
            setDados($DADO, id);
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
    ajax.send(JSON.stringify(dados()));
    return false;
}