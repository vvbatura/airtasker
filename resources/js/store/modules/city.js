import {GET_CITIES} from "../mutation-types";

export default {
    state: {
        cities: ""
    },
    getters: {
        cities: (state) => state.cities,
    },
    actions: {
        GET_CITIES : async (context, payload) => {
            let {data}  = await axios.get('/cities');
            context.commit(GET_CITIES, data.data)
        },
    },
    mutations: {
        GET_CITIES (state, payload) {
            state.cities = payload
        }
    }
}
