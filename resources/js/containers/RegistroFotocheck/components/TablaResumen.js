import React, { useState, useEffect } from 'react';
import { Table } from 'antd';

export const TablaResumen = ({ data, columns, loading, selectedRowKeys, setSelectedRowKeys }) => {

    return (
        <Table
            rowClassName={(record, index) => record.key === 'TOTAL' && 'table-row-primary'}
            rowSelection={{
                onChange: selectedRowKeys => setSelectedRowKeys(selectedRowKeys),
                getCheckboxProps: (record) => ({
                    disabled: record.key === 'TOTAL'
                }),
                checkStrictly: false,
            }}
            size="small"
            scroll={{ x: 1000 }}
            bordered
            dataSource={data}
            columns={columns}
            loading={loading}
            defaultExpandAllRows
        />
    );
}
