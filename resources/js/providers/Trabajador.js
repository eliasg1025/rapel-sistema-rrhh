import Axios from 'axios';

export class TrabajadorProvider {
    constructor() {
        this.url = '/api/sqlsrv/trabajador';
    }

    async getParaFiniquito(rut, fechaFiniquito) {
        try {
            const res = await Axios.get(`${this.url}/${rut}/finiquito?fecha_finiquito=${fechaFiniquito}`);
            return res.data;
        } catch (e) {
            return e.response.data;
        }
    }
}
