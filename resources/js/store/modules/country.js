import {GET_COUNTRIES} from "../mutation-types";

export default {
    state: {
        countries: ""
    },
    getters: {
        countries: (state) => state.countries,
    },
    actions: {
        GET_COUNTRIES : async (context, payload) => {
            let {data}  = await axios.get('/countries');
            context.commit(GET_COUNTRIES, data.data)
        },
    },
    mutations: {
        GET_COUNTRIES (state, payload) {
            state.countries = payload
        }
    }
}
