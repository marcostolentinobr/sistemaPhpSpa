function formReset() {
    ACAO_TITULO.innerHTML = 'Incluir'
    ACAO.value = 'Incluir'
    FORM.setAttribute('onsubmit', 'return incluir()');
    FORM.reset();
}

function incluir() {

    var $_POST = dados();
    $_POST.ACAO = 'Incluir';

    var ajax = new XMLHttpRequest();
    ajax.open('POST', urlController);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        if ($RETORNO.status == 'ok') {

            //Mensagem
            ACAO_MSG_OK.textContent = $RETORNO.mensagem;
            ACAO_MSG_ERRO.textContent = '';

            //Listar
            listar();
        } else {
            ACAO_MSG_OK.textContent = '';
            ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
        }
    }

    ajax.send(JSON.stringify($_POST));
    return false;
}

function excluir(id, elemento) {
    var descricao = elemento.getAttribute('descricao');
    if (confirm('Confirma exclusão de ' + descricao + ' ?')) {

        var $_POST = {
            ACAO: 'Excluir',
            ID: id,
            descricao: descricao
        };

        var ajax = new XMLHttpRequest();
        ajax.open('POST', urlController);
        ajax.onload = function () {
            var $RETORNO = JSON.parse(ajax.responseText);
            if ($RETORNO.status == 'ok') {

                //Mensagem
                ACAO_MSG_OK.textContent = $RETORNO.mensagem;
                ACAO_MSG_ERRO.textContent = '';

                //Listar
                listar();
            } else {
                ACAO_MSG_OK.textContent = '';
                ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
            }
        }

        ajax.send(JSON.stringify($_POST));
    }
    return false;
}

function editar(id) {

    var $_POST = {
        ACAO: 'Buscar',
        ID: id
    };

    var ajax = new XMLHttpRequest();
    ajax.open('POST', urlController);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        var $DADO = $RETORNO.dado;
        if ($RETORNO.status == 'ok') {
            setDados($DADO);

            //Estrutura
            ACAO_TITULO.innerHTML = 'Alterar'
            ACAO.value = 'Alterar'
            FORM.setAttribute('onsubmit', 'return alterar(' + $DADO.ID_CURSO + ')');

        } else {
            ACAO_MSG_OK.textContent = '';
            ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
        }
    }

    ajax.send(JSON.stringify($_POST));
    return false;
}

function alterar(id) {

    var $_POST = dados();
    $_POST.ACAO = 'Alterar';
    $_POST.ID = id;

    var ajax = new XMLHttpRequest();
    ajax.open('POST', urlController);
    ajax.onload = function () {
        var $RETORNO = JSON.parse(ajax.responseText);
        if ($RETORNO.status == 'ok') {

            //Mensagem
            ACAO_MSG_OK.textContent = $RETORNO.mensagem;
            ACAO_MSG_ERRO.textContent = '';

            //Lisar
            listar();
        } else {
            ACAO_MSG_OK.textContent = '';
            ACAO_MSG_ERRO.textContent = $RETORNO.mensagem;
        }
    }

    ajax.send(JSON.stringify($_POST));
    return false;
}
