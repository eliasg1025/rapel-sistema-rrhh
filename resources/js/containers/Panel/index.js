import React, { useState, useEffect } from 'react';
import { Input } from 'antd';

export default function Panel() {
    const { usuario, modulos  } = JSON.parse(sessionStorage.getItem('data'));

    const [query, setQuery] = useState('');
    const [data, setData] = useState(modulos);

    useEffect(() => {
        const x = modulos.filter(modulo => modulo.name.toLowerCase().includes(query.toLowerCase()));
        setData(x);
    }, [query]);

    const modulosNormales = data.filter(item => item.para_admins === 0);
    const modulosAdministrador = data.filter(item => item.para_admins === 1);

    return (
        <div className="container p-5">
            <div className="text-center">
                <h3>¿Á que módulo deseas entrar?</h3>
            </div>
            <br />
            <Input
                placeholder="Buscar por nombre"
                value={query}
                onChange={e => setQuery(e.target.value)}
                allowClear
            />
            <div className="py-5">
                <div className="row">
                    {
                        modulosNormales.map(modulo => {
                            return (
                                <div className="col-md-6" key={modulo.id}>
                                    <a className="btn btn-block btn-light" href={modulo.slug}>
                                        <i className={modulo.fa_icon_classname}></i> {modulo.name}
                                    </a>
                                </div>
                            );
                        })
                    }
                </div>
            </div>
            <br />
            {usuario.rol === 'admin' && (
                <>
                    <div className="text-center">
                        <h4>Módulos de Administrador</h4>
                    </div>
                    <div className="py-5">
                        <div className="row">
                            {
                                modulosAdministrador.map(modulo => {
                                    return (
                                        <div className="col-md-6" key={modulo.id}>
                                            <a className="btn btn-block btn-light" href={modulo.slug} >
                                                <i className={modulo.fa_icon_classname}></i> {modulo.name}
                                            </a>
                                        </div>
                                    );
                                })
                            }
                        </div>
                    </div>
                </>
            )}
        </div>
    );
}
