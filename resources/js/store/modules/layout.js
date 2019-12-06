import * as types from "../mutation-types";

export default {
    state: {
        layout: 'AppLayout'
    },
    getters: {
        layout (state) {
            return state.layout
        }
    },
    actions: {
    },
    mutations: {
        [types.SET_LAYOUT](state, payload) {
            state.layout = payload
        }
    }
}
