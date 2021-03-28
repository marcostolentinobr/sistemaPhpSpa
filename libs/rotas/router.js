function Router(routes) {
    this.constructor(routes);
    this.init();
}

Router.prototype = {
    constructor: function (routes) {
        this.routes = routes;
        this.rootElem = document.getElementById('app');
    },
    init: function () {
        var r = this.routes;
        (function (scope, r) {
            window.addEventListener('hashchange', function (e) {
                scope.hasChanged(scope, r);
            });
        })(this, r);
        this.hasChanged(this, r);
    },
    hasChanged: function (scope, r) {
        for (var i = 0, length = r.length; i < length; i++) {
            var route = r[i];
            if (route.isActiveRoute(window.location.hash.substr(1))) {
                scope.goToRoute(route);
            }
        }
    },
    goToRoute: function (route) {
        (function (scope) {
            var url = 'Views/' + route.classe + '/' + route.classe + '.html';
            xhttp = new XMLHttpRequest();
            xhttp.onloadend = function () {
                scope.rootElem.innerHTML = this.responseText;
            };

            xhttp.open('GET', url, true);
            xhttp.send();

            var newScript = document.createElement("script");
            newScript.src = 'Views/' + route.classe + '/' + route.classe + 'Script.js';
            scope.rootElem.appendChild(newScript);

        })(this);
    }
};