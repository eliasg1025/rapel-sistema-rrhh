import React from 'react';
import { Tag, Tooltip } from "antd";

export const EtiquetaAdministrador = () => {
    return (
        <Tooltip title="Tiene Rol de Administrador de este módulo">
            <Tag color="cyan">
                Modo Administrador
            </Tag>
        </Tooltip>
    );
}
