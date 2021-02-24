import React, { useState } from "react";
import {
    Table,
    Tag,
    Form,
    Input,
    InputNumber,
    Popconfirm,
    Typography,
    DatePicker,
    notification
} from "antd";
import Axios from "axios";
import moment from 'moment';

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
        inputType === "number" ? (
            <InputNumber size="small" />
        ) : inputType === "date" ? (
            <input type="date" className="form-control" />
        ) : (
            <Input />
        );
    return (
        <td {...restProps}>
            {editing ? (
                <Form.Item
                    name={dataIndex}
                    style={{
                        margin: 0
                    }}
                    rules={[
                        {
                            required: true,
                            message: `Please Input ${title}!`
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

export const TablaPlanillas = ({ data, loading, reload, setReload }) => {
    const [form] = Form.useForm();
    const [editingKey, setEditingKey] = useState("");

    const isEditing = record => record.key === editingKey;

    const edit = record => {
        form.setFieldsValue({
            name: "",
            age: "",
            address: "",
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
                const item = newData[index];
                newData.splice(index, 1, { ...item, ...row });

                console.log({ id: key, ...row });

                const result = await Axios.put(
                    `/api/planillas-manuales/${key}`,
                    {
                        fecha_inicio: row.fecha_inicio.toString(),
                        fecha_fin: row.fecha_fin.toString(),
                        horas: row.horas
                    }
                );

                notification["success"]({
                    message: result.data.message
                });

                setReload(!reload);

                setEditingKey("");
            } else {
                newData.push(row);
                setData(newData);
                setEditingKey("");
            }
        } catch (errInfo) {
            console.log("Validate Failed:", errInfo);

            notification["error"]({
                message: errInfo
            });
        }
    };

    const columns = [
        {
            title: "Fecha",
            dataIndex: "fecha_solicitud"
        },
        {
            title: "DNI",
            dataIndex: "trabajador",
            render: item => item?.rut
        },
        {
            title: "Trabajador",
            dataIndex: "trabajador",
            render: item =>
                item?.apellido_paterno +
                " " +
                item?.apellido_materno +
                " " +
                item?.nombre
        },
        {
            title: "Fecha Inicio",
            dataIndex: "fecha_inicio",
            editable: true
        },
        {
            title: "Fecha Fin",
            dataIndex: "fecha_fin",
            editable: true
        },
        {
            title: "Horas",
            dataIndex: "horas",
            editable: true
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: item =>
                item === 0 ? (
                    <Tag color="blue">GENERADO</Tag>
                ) : (
                    <Tag color="green">ENVIADO</Tag>
                )
        },
        {
            title: "Acciones",
            dataIndex: "id",
            /* render: (id, record) => (
                <button className="btn btn-primary btn-sm">
                    <i className="fas fa-edit"></i>
                </button>
            ) */
            render: (_, record) => {
                const editable = isEditing(record);
                return editable ? (
                    <span>
                        <Popconfirm title="¿Desea Guardar?" onConfirm={() => save(record.key)}>
                        <a
                            href="#"
                            style={{
                                marginRight: 8
                            }}
                        >
                            Guardar
                        </a>
                        </Popconfirm>
                        <a href="#" onClick={cancel}>Cancelar</a>
                    </span>
                ) : (
                    <button
                        className="btn btn-primary btn-sm"
                        onClick={() => edit(record)}
                    >
                        <i className="fas fa-edit"></i>
                    </button>
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
                inputType:
                    col.dataIndex === "fecha_inicio" ||
                    col.dataIndex === "fecha_fin"
                        ? "date"
                        : col.dataIndex === "horas"
                        ? "number"
                        : "text",
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
                size="small"
                bordered
                columns={mergedColumns}
                dataSource={data}
                loading={loading}
            />
        </Form>
    );
};
