const beforeEach = function (routerBeforeEach, transitionEach) {
    var _this = this;

    this.options.Vue.router.beforeEach(function (transition, location, next) {
        _this.options.setTransitions.call(this, transition);

        routerBeforeEach.call(_this, function () {
            var auth = _this.options.getAuthMeta(transition);

            transitionEach.call(_this, transition, auth, function (redirect) {
                if (!redirect) {

                    (next || transition.next)();
                    return;
                }

                // router v2.x
                if (next) {
                    next(redirect);
                } else {
                    this.options.router._routerReplace.call(this, redirect);
                }
            });

            if(_this.options.hasOwnProperty('status') && _this.user() !== _this.options.status){
                if (transition.hasOwnProperty('meta') && !transition.meta.hasOwnProperty('status') ){
                    let pushedRedirect =  _this.options.forbiddenRedirect
                    console.log('count Redirect');

                    if (next) {
                        next(pushedRedirect);
                    } else {
                        this.options.router._routerReplace.call(this, pushedRedirect);
                    }
                }
                console.log('don\'t Redirect');

            }

        });
    })
}
export default beforeEach;
