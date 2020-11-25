import Axios from 'axios';

export class FiniquitosProvider {
    constructor() {
        this.url = '/api/finiquitos';
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

    async import(data) {

        const formData = new FormData();

        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                formData.append(key, data[key]);
            }
        }

        try {
            const res = await Axios.post(`${this.url}/import`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
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

    async delete(id) {
        try {
            const res = await Axios.delete(`${this.url}/${id}`);
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
