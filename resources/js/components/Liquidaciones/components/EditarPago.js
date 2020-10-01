import React, { useState } from "react";
import {
    DatePicker,
    Form,
    Input,
    InputNumber,
    Popconfirm,
    Select,
    Table,
    Tag
} from "antd";
import {
    CheckCircleOutlined,
    SyncOutlined,
    CloseCircleOutlined,
    ClockCircleOutlined
} from "@ant-design/icons";
import Axios from "axios";

export const EditarPago = () => {
    const [pagos, setPagos] = useState([]);
    const [form, setForm] = useState({
        rut: ""
    });

    const handleSubmit = event => {
        event.preventDefault();
        fetchPagos();
    };

    const fetchPagos = () => {
        Axios.get(`/api/pagos/${form.rut}/trabajador`)
            .then(res => {
                setPagos(
                    res.data.map(item => {
                        return {
                            ...item,
                            key: item._id
                        };
                    })
                );
            })
            .catch(err => {
                console.error(err);
            });
    };

    const handleChange = event =>
        setForm({ ...form, [event.target.name]: event.target.value });

    const columns = [
        {
            title: "Tipo",
            dataIndex: "tipo_pago"
        },
        {
            title: "Empresa",
            dataIndex: "empresa"
        },
        {
            title: "Periodo",
            dataIndex: "periodo",
            render: (_, record) => `${record.mes} -  ${record.ano}`
        },
        {
            title: "Monto",
            dataIndex: "monto"
        },
        {
            title: "Fecha pago",
            dataIndex: "fecha_pago"
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: (_, record) => renderTags(record.estado)
        },
        {
            title: "Acciones",
            dataIndex: "acciones"
        }
    ];

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="form-row">
                    <div className="col-md-12 input-group">
                        <input
                            type="text"
                            name="rut"
                            className="form-control"
                            placeholder="Buscar por RUT"
                            onChange={handleChange}
                        />
                        <div className="input-group-append">
                            <button
                                className="btn btn-primary"
                                type="submit"
                                disabled={
                                    !(
                                        form.rut.length >= 8 &&
                                        form.rut.length <= 12
                                    )
                                }
                            >
                                <i className="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <br />
            {/* <Table columns={columns} size="small" dataSource={pagos} /> */}
            <EditableTable data={pagos} fetchPagos={fetchPagos} />
        </>
    );
};

const renderTags = estado => {
    switch (estado) {
        case 0:
            return (
                <Tag color="default" icon={<ClockCircleOutlined />}>
                    PENDIENTE
                </Tag>
            );
        case 1:
            return (
                <Tag color="warning" icon={<ClockCircleOutlined />}>
                    FIRMADO
                </Tag>
            );
        case 2:
            return (
                <Tag color="processing" icon={<SyncOutlined spin />}>
                    PARA PAGO
                </Tag>
            );
        case 3:
            return (
                <Tag color="success" icon={<CheckCircleOutlined />}>
                    PAGADO
                </Tag>
            );
        case 4:
            return (
                <Tag color="error" icon={<CloseCircleOutlined />}>
                    RECHAZADO
                </Tag>
            );
        case 5:
            return (
                <Tag color="success" icon={<CheckCircleOutlined />}>
                    PAGADO.
                </Tag>
            );
        default:
            return null;
    }
};

const EditableCell = ({
    editing,
    dataIndex,
    title,
    inputType,
    record,
    index,
    children,
    ...restProps
}) => {
    const inputNode =
        inputType === "date" ? (
            <input type="date" className="form-control" />
        ) : (
            <Select>
                <Select.Option value={0} key={0}>PENDIENTE</Select.Option>
                <Select.Option value={1} key={1}>FIRMADO</Select.Option>
                <Select.Option value={2} key={2}>PARA PAGO</Select.Option>
                <Select.Option value={3} key={3}>PAGADO</Select.Option>
                <Select.Option value={4} key={4}>RECHAZADO</Select.Option>
                <Select.Option value={5} key={5}>PAGADO.</Select.Option>
            </Select>
        );

    return (
        <td {...restProps}>
            {editing ? (
                <Form.Item
                    name={dataIndex}
                    style={{ margin: 0 }}
                    rules={[
                        {
                            required: dataIndex !== "fecha_pago",
                            message: `Completar ${title}!`
                        }
                    ]}
                >
                    {inputNode}
                </Form.Item>
            ) : (
                children
            )}
        </td>
    );
};

const EditableTable = ({ data, fetchPagos }) => {
    const [form] = Form.useForm();
    const [editingKey, setEditingKey] = useState("");

    const isEditing = record => record.key === editingKey;

    const edit = record => {
        console.log(record);
        form.setFieldsValue({
            fecha_pago: "",
            estado: "",
            ...record
        });
        setEditingKey(record.key);
    };

    const cancel = () => {
        setEditingKey("");
    };

    const save = async key => {
        try {
            const row = await form.validateFields();
            const newData = [...data];

            const index = newData.findIndex(item => key === item.key);

            if (index > -1) {
                //const item = newData[index];

                console.log(key, row);

                Axios.put(`/api/pagos/${key}`, { ...row })
                    .then(res => {
                        console.log(res);
                        fetchPagos();
                    })
                    .catch(err => console.error(err));
                setEditingKey("");
            } else {
                //newData.push(row);
                //setData(newData);
                console.log(newData);
                setEditingKey("");
            }
        } catch (errInfo) {
            console.log("Validación Fallida:", errInfo);
        }
    };

    const columns = [
        {
            title: "Tipo",
            dataIndex: "tipo_pago"
        },
        {
            title: "Empresa",
            dataIndex: "empresa"
        },
        {
            title: "Periodo",
            dataIndex: "periodo",
            render: (_, record) => `${record.mes} -  ${record.ano}`
        },
        {
            title: "Monto",
            dataIndex: "monto"
        },
        {
            title: "Fecha pago",
            dataIndex: "fecha_pago",
            editable: true
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: (_, record) => renderTags(record.estado),
            editable: true
        },
        {
            title: "Acciones",
            dataIndex: "operation",
            render: (_, record) => {
                const editable = isEditing(record);
                return editable ? (
                    <span>
                        <Popconfirm
                            title="¿Deseas Guardar?"
                            onConfirm={() => save(record.key)}
                        >
                            <a
                                href="#"
                                style={{
                                    marginRight: 8
                                }}
                            >
                                Guardar
                            </a>
                        </Popconfirm>
                        <a href="#" onClick={cancel}>
                            Cancelar
                        </a>
                    </span>
                ) : (
                    <a
                        href="#"
                        disabled={editingKey !== ""}
                        onClick={() => edit(record)}
                    >
                        Editar
                    </a>
                );
            }
        }
    ];
    const mergedColumns = columns.map(col => {
        if (!col.editable) {
            return col;
        }

        return {
            ...col,
            onCell: record => ({
                record,
                inputType: col.dataIndex === "fecha_pago" ? "date" : "text",
                dataIndex: col.dataIndex,
                title: col.title,
                editing: isEditing(record)
            })
        };
    });
    return (
        <Form form={form} component={false}>
            <Table
                components={{
                    body: {
                        cell: EditableCell
                    }
                }}
                bordered
                dataSource={data}
                columns={mergedColumns}
                rowClassName="editable-row"
                pagination={{
                    onChange: cancel
                }}
                size="small"
            />
        </Form>
    );
};
