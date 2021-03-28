function Route(classe) {
    this.constructor(classe);
}

Route.prototype = {
    constructor: function (classe) {
        this.classe = classe;
    },
    isActiveRoute: function (hashedPath) {
        return hashedPath.replace('#', '') === this.classe;
    }
}