import React, { useState, useEffect } from 'react';
import { Table } from 'antd';

export const TablaResumen = ({ data, columns, loading }) => {


    return (
        <Table
            size="small"
            scroll={{ x: 1000 }}
            bordered
            dataSource={data}
            columns={columns}
            loading={loading}
        />
    );
}
