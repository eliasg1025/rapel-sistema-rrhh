import Axios from 'axios';

export class TiposCesesProvider {
    constructor() {
        this.url = '/api/tipos-ceses';
    }

    async get() {
        try {
            const res = await Axios.get(`${this.url}`);
            return res.data;
        } catch (e) {
            return e.response.data;
        }
    }
}
