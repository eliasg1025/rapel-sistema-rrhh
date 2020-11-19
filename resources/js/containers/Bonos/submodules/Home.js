import React, { useEffect, useState } from "react";
import { notification, Spin } from "antd";
import Axios from "axios";

import { ListaBonos } from "../components/ListaBonos";
import { AgregarBono } from "../components";

export const Home = () => {
    const [bonos, setBonos] = useState([]);
    const [loadingBonos, setLoadingBonos] = useState(false);
    const [reloadData, setReloadData] = useState(false);

    useEffect(() => {
        setLoadingBonos(true);
        Axios.get("/api/bonos")
            .then(res => {
                const { data, message } = res.data;
                notification["success"]({
                    message: message
                });
                setBonos(data);
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoadingBonos(false));
    }, [reloadData]);

    return (
        <>
            <h4>Bonos</h4>
            <br />
            <AgregarBono reload={reloadData} setReload={setReloadData} />
            <br />
            <Spin spinning={loadingBonos}>
                <ListaBonos bonos={bonos} />
            </Spin>
        </>
    );
};
