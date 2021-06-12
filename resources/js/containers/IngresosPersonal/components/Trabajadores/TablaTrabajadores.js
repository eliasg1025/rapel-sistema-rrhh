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
            title: 'Regimen',
            dataIndex: 'regimen'
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
        <Button.Group size="small">
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
                    onClick={() => window.open(`/ingresos/registro-individual/editar/${record.contrato_id}`)}
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
                    <ButtonGroup size="small">
                        <Button
                            type="primary"
                            onClick={generarContrato}
                            disabled={!hasSelected}
                            loading={props.loading}
                        >
                            <i className="far fa-file-alt" />&nbsp;Generar Contratos
                        </Button>
                        <Button
                            type="primary"
                            onClick={generarFicha}
                            disabled={!hasSelected}
                            loading={props.loading}
                        >
                            <i className="far fa-file-excel" />&nbsp;Exportar Registros
                        </Button>
                    </ButtonGroup>

                    <span style={{ marginLeft: 8 }}>
                        {hasSelected
                            ? `${selectedRowKeys.length} elementos seleccionados `
                            : ''}
                    </span>
                </div>
            </div>
            {props.estadoCarga && (
                <div className="alert alert-success" role="alert">
                    <b>Estado de carga:</b>
                    {props.estadoCarga.carga_excel && (
                        <>
                            <br />
                            <span>Código de la carga: <b>{props.estadoCarga.carga_excel.id}</b></span>
                            <p>
                                <span>{props.estadoCarga.message}</span>. Puede descargar el documento <b><u><a href={`/storage/${props.estadoCarga.carga_excel.link}`} target="_blank">AQUÍ</a></u></b> o dirigirse a la pestaña <b><u><a
                                href="/ingresos" target="_blank">Inicio</a></u></b> a la sección <b>Cargas realizadas &gt; Fichas excel</b>.
                            </p>
                        </>
                    )}
                    {props.estadoCarga.carga_pdf && (
                        <>
                            <br/>
                            <span>Código de la carga: <b>{props.estadoCarga.carga_pdf.id}</b></span>
                            <p>
                                Se procesaron {props.estadoCarga.generados.length} registro(s) correctamente con {props.estadoCarga.errores.length} error(es).
                                Puede descargar el documento <b><u><a href={`/storage/${props.estadoCarga.carga_pdf.link}`} target="_blank">AQUÍ</a></u></b> o dirigirse a la pestaña <b><u><a
                                href="/ingresos" target="_blank">Inicio</a></u></b> a la sección <b>Cargas realizadas &gt; Contratos</b>.
                            </p>
                        </>
                    )}
                </div>
            )}
            <Table
                rowSelection={rowSelection}
                columns={getColumns(props.eliminarContrato)}
                dataSource={props.trabajadores}
                size="small"
                scroll={{ x: 1200 }}
                pagination={{ pageSize: 20 }}
            />
        </div>
    );
};

export default TablaTrabajadores;
