window.CrudProjectBus = new window.CrudProject.Vue();

window.CrudProject.Vue.mixin({
    methods: {
        applyFilters: window.CrudProject.applyFilters,
        addFilter: window.CrudProject.addFilter,
        addAction: window.CrudProject.addFilter,
        doAction: window.CrudProject.doAction,
        $get: window.CrudProject.$get,
        $adminGet: window.CrudProject.$adminGet,
        $adminPost: window.CrudProject.$adminPost,
        $post: window.CrudProject.$post
    }
});

import {routes} from './routes'

const router = new window.CrudProject.Router({
    routes: window.CrudProject.applyFilters('CrudProject_global_vue_routes', routes),
    linkActiveClass: 'active'
});

import App from './AdminApp'

new window.CrudProject.Vue({
    el: '#crud_project_app',
    render: h => h(App),
    router: router
});

