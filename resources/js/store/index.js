'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import layout from './modules/layout'
import locale from './modules/locale'
import country from "./modules/country";
import category from "./modules/category";
import city from "./modules/city";
import experience from "./modules/experience";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        layout,
        locale,
        country,
        category,
        city,
        experience
    },

})
