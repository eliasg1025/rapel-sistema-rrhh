import React, { useState, useEffect } from 'react';
import Axios from 'axios';

import ListaUsuarios from '../components/ListaUsuarios';

export const Usuarios = () => {
    const [reloadUser, setReloadUser] = useState(false);
    const [usersActive, setUsersActive] = useState([]);
    const [usersInactive, setUsersInactive] = useState([]);

    useEffect(() => {
        Axios.get(`/api/usuario?activo=${true}`)
            .then(res => setUsersActive(res.data.data))
            .catch(err => console.log(err.response));

        Axios.get(`/api/usuario?activo=${false}`)
            .then(res => setUsersInactive(res.data.data))
            .catch(err => console.log(err.response));
    }, [reloadUser]);

    return (
        <div className="users">
            <h3>Usuarios</h3>
            <ListaUsuarios
                reloadUser={reloadUser}
                setReloadUser={setReloadUser}
                usersActive={usersActive}
                usersInactive={usersInactive}
            />
        </div>
    );
}
