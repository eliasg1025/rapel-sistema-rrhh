import React from "react";
import {
    List,
    Button,
    Tag,
    Dropdown,
    Menu,
    Modal,
    notification,
    Badge
} from "antd";
import Axios from "axios";

export const BonoInfo = ({ bono }) => {
    const confirmarEliminacion = () => {
        Modal.confirm({
            title: "Eliminar Bono",
            content: (
                <>
                    Se eliminará el bono{" "}
                    <span style={{ fontSize: "15px", fontWeight: "bold" }}>
                        {bono.name}
                    </span>
                    . ¿Está seguro que desea realizar esta acción?
                </>
            ),
            okText: "Eliminar",
            cancelText: "Cancelar",
            onOk: () => deleteBono()
        });
    };

    const deleteBono = () => {
        Axios.delete(`/api/bonos/${bono?.id}`)
            .then(res => {
                const { message, data } = res.data;

                notification["warning"]({
                    message: message
                });

                setTimeout(() => {
                    location.reload();
                }, 1000);
            })
            .catch(err => {
                console.error(err);
            });
    };

    const menu = (
        <Menu>
            <Menu.Item>
                <i className="fas fa-pencil-alt"></i> Modificar
            </Menu.Item>
            <Menu.Item danger onClick={() => confirmarEliminacion()}>
                <i className="fas fa-trash"></i> Eliminar Bono
            </Menu.Item>
        </Menu>
    );

    const BonoTitle = ({ bono }) => {
        return (
            <>
                <a href={`/bonos/editar/${bono.id}`} style={{ fontSize: '14px' }}>{bono.name}</a>&nbsp;&nbsp;
                <small style={{ fontSize: '9px !important' }}>
                    {bono.listo_para_usar ? (
                        <>
                            <Badge status="success" />Habilitado
                        </>
                    ) : (
                        <>
                            <Badge status="error" />No habilitado
                        </>
                    )}
                </small>
            </>
        );
    };

    return (
        <List.Item key={bono.id}>
            <div className="rapel-list-item">
                <div
                    onClick={() => location.replace(`/bonos/editar/${bono.id}`)}
                >
                    <List.Item.Meta title={<BonoTitle bono={bono} />} description={bono.descripcion} />
                </div>
                EMPRESA:{" "}
                <Tag color="processing">
                    {bono.empresa_id === 9 ? "RAPEL" : "VERFRUT"}
                </Tag>{" "}
                |  Creado por: <b>{bono.usuario.username}</b>
                <div style={{ float: "right" }}>
                    <Dropdown overlay={menu}>
                        <Button type="text">
                            <i className="fas fa-ellipsis-v" />
                        </Button>
                    </Dropdown>
                </div>
            </div>
        </List.Item>
    );
};
