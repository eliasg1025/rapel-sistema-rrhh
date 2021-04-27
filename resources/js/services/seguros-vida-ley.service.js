import Axios from "axios";

import { API_URL } from './config';

const URL = `${API_URL}/seguros-vida`;

class SegurosVidaLeyService
{
    async getTrabajadores(query)
    {
        const res = await Axios.get(`${URL}/trabajadores?q=${query}`);
        return res.data;
    }
}

export default new SegurosVidaLeyService();
