import Axios from 'axios';

export class GruposFiniquitosProvider {
    constructor() {
        this.url = '/api/grupos-finiquitos';
    }

    async get() {
        try {
            const res = await Axios.get(`${this.url}`);
            return {
                ...res.data,
                status: 'success'
            };
        } catch (e) {
            return {
                ...e.response.data,
                status: 'error'
            };
        }
    }

    async create(data) {
        try {
            const res = await Axios.post(`${this.url}`, data);
            return {
                ...res.data,
                status: 'success'
            };
        } catch (e) {
            return {
                ...e.response.data,
                status: 'error'
            };
        }
    }

    async setState(data, id) {
        try {
            const res = await Axios.put(`${this.url}/${id}/set-state`, data);
            return {
                ...res.data,
                status: 'success'
            };
        } catch (e) {
            return {
                ...e.response.data,
                status: 'error'
            };
        }
    }

    async updateFiniquitos(id) {
        try {
            const res = await Axios.put(`${this.url}/${id}/finiquitos`, {});
            return {
                ...res.data,
                status: 'success'
            };
        } catch (e) {
            return {
                ...e.response.data,
                status: 'error'
            };
        }
    }

    async print(id) {
        try {
            const res = await Axios.get(`${this.url}/${id}/print`);
            return {
                ...res.data,
                status: 'success'
            };
        } catch (e) {
            return {
                ...e.response.data,
                status: 'error'
            };
        }
    }
}
