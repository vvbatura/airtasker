import {GET_CATEGORIES} from "../mutation-types";

export default {
    state: {
        categories: ""
    },
    getters: {
        categories: (state) => state.categories,
    },
    actions: {
        GET_CATEGORIES : async (context, payload) => {
            let {data}  = await axios.get('/categories');
            context.commit(GET_CATEGORIES, data.data)
        },
    },
    mutations: {
        GET_CATEGORIES (state, payload) {
            state.categories = payload
        }
    }
}
