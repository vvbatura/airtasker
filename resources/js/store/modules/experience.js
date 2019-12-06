import {GET_EXPERIENCES} from "../mutation-types";

export default {
    state: {
        experiences: ""
    },
    getters: {
        experiences: (state) => state.experiences,
    },
    actions: {
        GET_EXPERIENCES : async (context, payload) => {
            let {data}  = await axios.get('/experiences');
            context.commit(GET_EXPERIENCES, data.data)
        },
    },
    mutations: {
        GET_EXPERIENCES (state, payload) {
            state.experiences = payload
        }
    }
}
