import React, { useEffect, useState } from "react";
import { Card, Tag } from "antd";
import Axios from "axios";
import moment from "moment";

export const HistorialGrupos = () => {
    const [grupos, setGrupos] = useState([]);

    useEffect(() => {
        Axios.get("/api/cortes-renovaciones-fotocheck")
            .then(res => {
                setGrupos(res.data.data);
            })
            .catch(err => {
                console.log(err);
            });
    }, []);

    return (
        <>
            {grupos.map(grupo => {
                return (
                    <div key={grupo.id}>
                        <Card>
                            <div className="row">
                                <div className="col-md-6">
                                    <p>
                                        <b>Estado:</b>{" "}
                                        {grupo.activo ? (
                                            <Tag color="warning">ACTIVO</Tag>
                                        ) : (
                                            <Tag color="default">NO ACTIVO</Tag>
                                        )}
                                    </p>
                                    <p>
                                        <b>Codigo:</b> {grupo.id}
                                    </p>
                                    <p>
                                        <b>Fecha y hora:</b>{" "}
                                        {moment(grupo.fecha_hora_corte).format(
                                            "DD/MM/YYYY hh:mm"
                                        )}
                                    </p>
                                    <p>
                                        <b>Creado por:</b>{" "}
                                        {`${grupo.usuario.trabajador.apellido_paterno} ${grupo.usuario.trabajador.apellido_materno} ${grupo.usuario.trabajador.nombre}`}
                                    </p>
                                </div>
                                <div className="col-md-6">
                                    <p>
                                        <b># Registros:</b>{" "}
                                        {grupo.registros.length}
                                    </p>
                                    <p>
                                        <b># Pendientes de Recepción:</b>{" "}
                                        {
                                            grupo.registros.filter(
                                                registro =>
                                                    registro.estado_documento ===
                                                        0 ||
                                                    registro.estado_documento ===
                                                        1
                                            ).length
                                        }{" "}
                                        de {
                                            grupo.registros.filter(registro => registro.estado_documento !== null).length
                                        }
                                    </p>
                                </div>
                            </div>
                        </Card>
                        <br />
                    </div>
                );
            })}
        </>
    );
};
