import VueRouter from 'vue-router'
import ForgotPassword from "../pages/Auth/ForgotPassword";
import ResetPassword from "../pages/Auth/ResetPassword";
import Register from '../pages/Auth/Register';
import Login from '../pages/Auth/Login';
import HomePage from '../pages/Home';
import VerifyEmail from "../pages/Auth/VerifyEmail";
import VerifyPhone from "../pages/Auth/VerifyPhone";
import ConfirmPhone from "../pages/Auth/ConfirmPhone";
import store from "../store"

//Errors
import AccessDeniedComponent from '../pages/errors/403';
import NoFoundComponent from '../pages/errors/404';

//variables
import {authLayout, appLayout, errorLayout} from '../common/variables/layout';
import beforeEach from "../common/module/websanovaRoueterBeforeEach";

const routes = [
    {
        path: '/',
        name: 'home-page',
        component: HomePage,
        meta: { guest: true, layout: appLayout }
    },
    {
        path: '/verify/:token',
        name: 'email-verify',
        component: VerifyEmail,
        meta: { guest: true, layout: authLayout }
    },
    {
        path: '/verify',
        name: 'phone-verify',
        component: VerifyPhone,
        meta: { guest: true, layout: authLayout }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { guest: true, layout: authLayout }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { guest: true, layout: authLayout }
    },
    {
        path: '/forgot-password',
        name: 'forgot',
        component: ForgotPassword,
        meta: { guest: true, layout: authLayout }
    },
    {
        path: '/reset-password/:token',
        name: 'reset_password',
        component: ResetPassword,
        meta: {guest: true, layout: authLayout}
    },
    {
        path: '/confirm-phone/',
        name: 'ConfirmPhone',
        component: ConfirmPhone,
        meta: {guest: true, layout: authLayout}
    },
    //Errors
    {
        path: '/403',
        name: '403',
        component: AccessDeniedComponent,
        meta: { auth: undefined, layout: errorLayout, user_roles: [], title: '403' }
    },
    {
        path: '*',
        name: '404',
        component: NoFoundComponent,
        meta: { auth: undefined, layout: errorLayout, user_roles: [], title: '404' }
    }
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    linkExactActiveClass: 'is-active',
    routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

export default router;
