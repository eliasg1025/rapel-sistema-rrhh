import React, { useState } from 'react';

export const BusquedaTrabajador = ({  }) => {

    const [rut, setRut] = useState('');

    const handleSubmit = e => {
        e.preventDefault();
        //fetchTrabajador();
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="input-group mb-3 col">
                    <input
                        type="text"
                        className="form-control"
                        name="_rut"
                        autoComplete="off"
                        placeholder="Buscar por RUT"
                        value={rut}
                        onChange={e => setRut(e.target.value)}
                    />
                    <div className="input-group-append">
                        <button className="btn btn-primary" type="submit" disabled={(rut.length < 8 || rut.length > 11) || loading}>
                            <i className="fas fa-search" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
}
