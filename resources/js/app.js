import Vue from 'vue'
import VueRouter from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import money from 'v-money'

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(money, {precision: 4})

import App          from './views/App'
import Home from './views/Home'
// import Dashboard    from './views/Board'
import Login        from './views/Login'
import Register     from './views/Register'

import CategoryList     from './views/Category/CategoryList.vue'
import CategoryForm     from './views/Category/CategoryForm.vue'

import AthorList from './views/Athor/AthorList';
import AthorForm from './views/Athor/AthorForm';

import CastForm from './views/Cast/CastForm';

import MovieList from './views/Movie/MovieList';
import MovieForm from './views/Movie/MovieForm';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
          path: '/categories',
          name: 'categories',
          component: CategoryList
        },
        {
          path: '/category/:id',
          name: 'category-edit',
          component: CategoryForm
        },
        {
          path: '/category',
          name: 'category',
          component: CategoryForm
        },
        {
          path: '/athors',
          name: 'athors',
          component: AthorList
        },
        {
          path: '/athor/:id',
          name: 'athor-edit',
          component: AthorForm
        },
        {
          path: '/athor',
          name: 'athor',
          component: AthorForm
        },
        {
          path: '/movies',
          name: 'movies',
          component: MovieList
        },
        {
          path: '/movie/:id',
          name: 'movie-edit',
          component: MovieForm
        },
        {
          path: '/movie/:id/cast',
          name: 'movie-cast',
          component: CastForm
        },
        {
          path: '/movie',
          name: 'movie',
          component: MovieForm
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

