import React from 'react';
import {Select} from "antd";
import {empresa} from "../../../../data/default.json";

export const First = ({ form, setForm, zonas }) => {

    console.log(form);

    return (
        <div className="row">
            <div className="col-md-4">
                Empresa:<br />
                <Select
                    value={form.empresaId} showSearch
                    style={{ width: '100%' }} optionFilterProp="children"
                    filterOption={(input, option) =>
                        option.children
                            .toLowerCase()
                            .indexOf(input.toLowerCase()) >= 0
                    }
                    onChange={e => setForm({ ...form, empresaId: e })}
                    size="small"
                >
                    {empresa.map(e => (
                        <Select.Option value={e.id} key={e.id}>
                            {`${e.id} - ${e.name}`}
                        </Select.Option>
                    ))}
                </Select>
            </div>
            <div className="col-md-4">
                Zonas Labor:<br />
                <Select
                    value={form.empresaId} showSearch
                    style={{ width: '100%' }} optionFilterProp="children"
                    filterOption={(input, option) =>
                        option.children
                            .toLowerCase()
                            .indexOf(input.toLowerCase()) >= 0
                    }
                    onChange={e => setForm({ ...form, empresaId: e })}
                    size="small"
                >
                    {zonas.map(item => (
                        <Select.Option key={item.id} value={item.id}>
                            {`${item.id} - ${item.name}`}
                        </Select.Option>
                    ))}
                </Select>
            </div>
        </div>
    );
}
