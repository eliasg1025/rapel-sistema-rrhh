import React, {useEffect, useState} from 'react';
import {notification} from "antd";
import Axios from 'axios';

import {ListaBonos} from "../components/ListaBonos";
import { AgregarBono } from '../components';


export const Home = () => {

    const [bonos, setBonos] = useState([]);
    const [reloadData, setReloadData] = useState(false);

    useEffect(() => {
        Axios.get('/api/bonos')
            .then(res => {
                const { data, message } = res.data;
                notification['success']({
                    message: message
                });
               setBonos(data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    return (
        <>
            <h4>Bonos</h4>
            <br />
            <AgregarBono />
            <br />
            <ListaBonos bonos={bonos} />
        </>
    );
}
