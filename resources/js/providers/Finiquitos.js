import Axios from 'axios';

export class FiniquitosProvider {
    constructor() {
        this.url = '/api/finiquitos';
    }

    async get(usuarioId, { desde, hasta, rut, estado_id }) {
        try {
            const res = await Axios.get(`${this.url}?usuario_id=${usuarioId}&tipo=individual&desde=${desde}&hasta=${hasta}&persona_id=${rut}&estado_id=${estado_id}`);
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

    async changeState(id, data) {
        try {
            const res = await Axios.put(`${this.url}/${id}/state`, data);
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

    async delete(id, { justificacion }) {
        try {
            const res = await Axios.post(`${this.url}/${id}/delete`, { justificacion });
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
