import React, { useState } from "react";
import { Form, Input, InputNumber, Table, Tag } from "antd";
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
                        PAGADO
                    </Tag>
                );
            default:
                return null;
        }
    };

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="form-row">
                    <div className="col-md-6">
                        <input
                            type="text"
                            name="rut"
                            className="form-control"
                            placeholder="Buscar por RUT"
                            onChange={handleChange}
                        />
                    </div>
                    <div className="col-md-6">
                        <button type="submit" className="btn btn-primary">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
            <br />
            {/* <Table columns={columns} size="small" dataSource={pagos} /> */}
        </>
    );
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
    const inputNode = inputType === "number" ? <InputNumber /> : <Input />;

    return (
        <td {...restProps}>
            {editing ? (
                <Form.Item
                    name={dataIndex}
                    style={{ margin: 0 }}
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

const originData = [];
const EditableTable = () => {
    const [form] = Form.useForm();
    const [data, setData] = useState(originData);
    const [editingKey, setEditingKey] = useState('');

    const isEditing = (record) => record.key === editingKey;

    const edit = (record) => {
        form.setFieldsValue({
          name: '',
          age: '',
          address: '',
          ...record,
        });
        setEditingKey(record.key);
    };

    const cancel = () => {
        setEditingKey('');
    };

    const save = async (key) => {
        try {
          const row = await form.validateFields();
          const newData = [...data];
          const index = newData.findIndex((item) => key === item.key);

          if (index > -1) {
            const item = newData[index];
            newData.splice(index, 1, { ...item, ...row });
            setData(newData);
            setEditingKey('');
          } else {
            newData.push(row);
            setData(newData);
            setEditingKey('');
          }
        } catch (errInfo) {
          console.log('Validate Failed:', errInfo);
        }
    };

    const columns = [
        {
          title: 'name',
          dataIndex: 'name',
          width: '25%',
          editable: true,
        },
        {
          title: 'age',
          dataIndex: 'age',
          width: '15%',
          editable: true,
        },
        {
          title: 'address',
          dataIndex: 'address',
          width: '40%',
          editable: true,
        },
        {
          title: 'operation',
          dataIndex: 'operation',
          render: (_, record) => {
            const editable = isEditing(record);
            return editable ? (
              <span>
                <a
                  href="javascript:;"
                  onClick={() => save(record.key)}
                  style={{
                    marginRight: 8,
                  }}
                >
                  Save
                </a>
                <Popconfirm title="Sure to cancel?" onConfirm={cancel}>
                  <a>Cancel</a>
                </Popconfirm>
              </span>
            ) : (
              <a disabled={editingKey !== ''} onClick={() => edit(record)}>
                Edit
              </a>
            );
          },
        },
      ];
      const mergedColumns = columns.map((col) => {
        if (!col.editable) {
          return col;
        }

        return {
          ...col,
          onCell: (record) => ({
            record,
            inputType: col.dataIndex === 'age' ? 'number' : 'text',
            dataIndex: col.dataIndex,
            title: col.title,
            editing: isEditing(record),
          }),
        };
      });
      return (
        <Form form={form} component={false}>
          <Table
            components={{
              body: {
                cell: EditableCell,
              },
            }}
            bordered
            dataSource={data}
            columns={mergedColumns}
            rowClassName="editable-row"
            pagination={{
              onChange: cancel,
            }}
          />
        </Form>
      );
}
