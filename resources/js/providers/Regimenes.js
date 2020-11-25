import Axios from 'axios';

export class RegimenesProvider {
    constructor() {
        this.url = 'http://192.168.60.16/api/regimen';
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
