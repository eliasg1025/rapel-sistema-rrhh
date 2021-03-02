import React, { useEffect, useState } from 'react';
import { Card, Tag } from 'antd';
import Axios from 'axios';
import moment from 'moment';

export const HistorialGrupos = () => {

    const [grupos, setGrupos] = useState([]);

    useEffect(() => {
        Axios.get('/api/cortes-renovaciones-fotocheck')
            .then(res => {
                setGrupos(res.data.data);
            })
            .catch(err => {
                console.log(err);
            })
    }, []);

    return (
        <>
            {grupos.map(grupo => (
                <>
                    <div key={grupo.id}>
                        <Card>
                            <p>{grupo.activo ? <Tag color="green">ACTIVO</Tag> : ''}</p>
                            <p><b>Codigo:</b> {grupo.id}</p>
                            <p><b>Fecha y hora:</b> {moment(grupo.fecha_hora_corte).format("DD/MM/YYYY hh:mm")}</p>
                            <p><b>Creado por:</b> {`${grupo.usuario.trabajador.apellido_paterno} ${grupo.usuario.trabajador.apellido_materno} ${grupo.usuario.trabajador.nombre}`}</p>
                        </Card>
                        <br />
                    </div>
                </>
            ))}
        </>
    );
}
