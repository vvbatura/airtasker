import i18n from "../../i18n";
import * as types from '../mutation-types'

const LOCALE = 'locale';

const initLang = (() => {
    return window.localStorage.getItem(LOCALE) || 'en';
})();


export default {
    state: {
        locale: initLang
    },
    getters: {
        locale (state) {
            return state.locale
        }
    },
    actions: {
        setLocale({ commit }, payload) {
            commit(types.SET_LOCALE, payload);
        }
    },
    mutations: {
        [types.SET_LOCALE] (state, payload) {
            window.localStorage.setItem(LOCALE, payload.locale);
            i18n.locale = payload.locale;
            state.lang = payload.locale;
        }
    }
}
