import React, { useState } from 'react';
import { Table, Button, Tooltip, Checkbox } from 'antd';
import {
    EditOutlined,
    DeleteOutlined,
    FileAddOutlined,
} from '@ant-design/icons';
import ButtonGroup from 'antd/lib/button/button-group';

const getColumns = (eliminarContrato) => {
    return [
        {
            title: 'Empresa',
            dataIndex: 'empresa',
        },
        {
            title: 'DNI',
            dataIndex: 'dni',
        },
        {
            title: 'Apellidos',
            dataIndex: 'apellidos',
        },
        {
            title: 'Nombre',
            dataIndex: 'nombre',
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor',
        },
        {
            title: 'Grupo',
            dataIndex: 'grupo',
        },
        {
            title: 'Fecha Ingreso',
            dataIndex: 'fecha_ingreso',
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => (
                <Acciones
                    record={record}
                    eliminarContrato={eliminarContrato}
                />
            ),
        },
    ];
};

function Acciones({ record, eliminarContrato }) {
    return (
        <Button.Group>
            <Tooltip title="Ver ficha-trabajador">
                <Button
                    type="primary"
                    onClick={() =>
                        window.open(
                            `/ficha/${record.contrato_id}`,
                            '_blank'
                        )
                    }
                >
                    <FileAddOutlined />
                </Button>
            </Tooltip>
            <Tooltip title="Editar registro">
                <Button
                    type="primary"
                    onClick={() => window.open(`/registro-individual/editar/${record.contrato_id}`)}
                >
                    <EditOutlined />
                </Button>
            </Tooltip>
            <Tooltip title="Borrar trabajador">
                <Button type="danger" onClick={() => eliminarContrato(record.contrato_id)}>
                    <DeleteOutlined />
                </Button>
            </Tooltip>
        </Button.Group>
    );
}

const TablaTrabajadores = props => {
    const [state, setState] = useState({
        selectedRowKeys: [], // Check here to configure the default column
        data: {},
        all: false,
    });

    const obetenerSeleccionados = () => {
        return props.trabajadores.filter((e, index) => {
            return state.selectedRowKeys.includes(index);
        });
    };

    const generarContrato = () => {
        const seleccionados = obetenerSeleccionados();
        props.generarContrato(seleccionados);
    };

    const generarFicha = () => {
        const seleccionados = obetenerSeleccionados();
        console.log('Contrato seleccionados para fichas excel: ', seleccionados);
        props.generarFicha(seleccionados);
    };

    const onSelectChange = selectedRowKeys => {
        setState({ ...state, selectedRowKeys });
    };

    const toggleSeleccionarTodos = () => {
        if (state.all) {
            setState({
                ...state,
                selectedRowKeys: [],
                all: false,
            });

            return 0;
        }
        const x = Array.from(Array(props.trabajadores.length).keys());
        setState({
            ...state,
            selectedRowKeys: x,
            all: true,
        });
    };

    const { selectedRowKeys, all } = state;
    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <div>
            <div style={{ marginBottom: 16 }}>
                <div>
                    <Checkbox
                        onClick={toggleSeleccionarTodos}
                        checked={all}
                    >
                        Seleccionar todos
                    </Checkbox>
                </div>
                <br />
                <div>
                    <ButtonGroup>
                        <Button
                            type="primary"
                            onClick={generarContrato}
                            disabled={!hasSelected}
                            loading={props.loading}
                        >
                            Generar Contrato
                        </Button>
                        <Button
                            type="primary"
                            onClick={generarFicha}
                            disabled={!hasSelected}
                            loading={props.loading}
                        >
                            Generar Ficha
                        </Button>
                    </ButtonGroup>

                    <span style={{ marginLeft: 8 }}>
                            {hasSelected
                                ? `${selectedRowKeys.length} elementos seleccionados `
                                : ''}
                        </span>
                </div>
            </div>
            <Table
                rowSelection={rowSelection}
                columns={getColumns(props.eliminarContrato)}
                dataSource={props.trabajadores}
                scroll={{ x: 1300 }}
            />
        </div>
    );
};

export default TablaTrabajadores;
