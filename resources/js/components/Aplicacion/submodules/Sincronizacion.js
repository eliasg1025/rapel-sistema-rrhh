import React from 'react';
import { Card, Select } from 'antd';

export const Sincronizacion = () => {
    return (
        <>
            <h4>Sincronización</h4>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <Card>
                        hi
                    </Card>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-6">
                    <h5>Trabajadores:</h5><br />
                    <Card>
                        <SyncForm
                            table="trabajadores"
                        />
                    </Card>
                </div>
                <div className="col-md-6">
                    <h5>Pagos:</h5><br />
                    <Card>
                        <SyncForm
                            table="pagos"
                        />
                    </Card>
                </div>
            </div>
        </>
    );
}


const SyncForm = ({ table }) => {
    const handleSubmit = e => {
        e.preventDefault();
        console.log('submit ' + table);
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="col-md-4">
                    <Select
                        mode="multiple"
                        allowClear
                        style={{ width: '100%' }}
                        placeholder="Seleccione ZONA LABOR"
                    >
                        <Select.Option key={1}>{1}</Select.Option>
                    </Select>
                </div>
                <div className="col-md-4">
                    <input
                        type="text" className="form-control"
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <button type="submit" className="btn btn-primary">
                        <i className="fas fa-sync-alt"></i>{" "}Sincronizar <b>{ table.toUpperCase() }</b>
                    </button>
                </div>
            </div>
        </form>
    );
}
