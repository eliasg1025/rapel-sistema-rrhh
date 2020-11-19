import React, { useState } from 'react';
import moment from 'moment';

export const ImportacionUtilidades = ({ reloadData, setReloadData, setIsVisibleParent }) => {

    const [form, setForm] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '9',
    });

    const handleSubmit = e => {
        e.preventDefault();
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">

            </div>
        </form>
    );
}
