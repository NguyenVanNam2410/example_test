import {defineStore} from "pinia";

const useDataStore = defineStore('app', {
    state: () => ({
        data: '',
    }),
    getters: {
        getData: (state) => state.data,
    },
    actions: {

    }
})
export default useDataStore
