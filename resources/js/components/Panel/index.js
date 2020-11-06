import React from 'react';

export default function Panel() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <div>
            <h5>HI</h5>
        </div>
    );
}
