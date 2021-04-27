import React, { useState } from 'react';
import { notification } from 'antd';

import SegurosVidaLeyService from '../../../services/seguros-vida-ley.service';

export const Busqueda = ({ setDataSource, setIsLoading }) => {
    const [query, setQuery] = useState('');

    const handleSubmit = async e => {
        e.preventDefault();

        setIsLoading(true);
        try {
            const { message, data } = await SegurosVidaLeyService.getTrabajadores(query);

            notification['success']({
                message: message
            });

            setDataSource(data.map(item => {
                return {
                    ...item,
                    key: item.id
                };
            }));
        } catch (err) {
            notification['error']({
                message: err.response.data.message
            });
        } finally {
            setIsLoading(false);
        }
    }

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="input-group">
                    <input
                        type="text"
                        className="form-control"
                        autoComplete="off"
                        placeholder="Buscar por DNI, Nombre o Apellidos"
                        onChange={e => setQuery(e.target.value)}
                    />
                    <div className="input-group-append">
                        <button className="btn btn-primary" type="submit">
                            <i className="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </>
    );
}
