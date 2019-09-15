import React, { Component } from 'react';
import { withRouter } from 'react-router-dom';
// import auth0Client from '../utils/Auth';

import {
    EuiBasicTable,
    EuiHealth,
    EuiIcon,
    EuiLink,
    EuiToolTip,
    EuiSwitch,
    EuiSpacer,
    EuiFlexGroup,
    EuiFlexItem
} from '@elastic/eui';
import DataApi from "../services/dataApi";


class VehicleList extends Component {

    constructor(props) {
        super(props);

        this.state = {
            pageIndex: 0,
            pageSize: 10,
            pageOfItems: [],
            showPerPageOptions: true,
        };
    }

    onTableChange = ({ page = {} }) => {
        const { index: pageIndex, size: pageSize } = page;

        this.setState({
            pageIndex,
            pageSize,
        });
    };

    componentDidMount() {
        DataApi.get('/api/vehicle').then((response) => {
            this.setState({
                pageOfItems: response.data
            })
        });
    }

    togglePerPageOptions = () => this.setState(state => ({ showPerPageOptions: !state.showPerPageOptions }));

    render() {
        const { pageIndex, pageSize, pageOfItems, showPerPageOptions } = this.state;
        const totalItemCount = 10;

        const columns = [
            {
                field: 'brand',
                name: 'Brand',
                truncateText: true,
                hideForMobile: true,
                mobileOptions: {
                    show: false,
                },
            },
            {
                field: 'model',
                name: 'Model',
                truncateText: true,
                mobileOptions: {
                    show: false,
                },
            },
            {
                field: 'made_from',
                name: 'Year made',
                mobileOptions: {
                    header: false,
                    only: true,
                    enlarge: true,
                    fullWidth: true,
                },
                render: (name, item) => (
                    <EuiFlexGroup responsive={false} alignItems="center">
                        <EuiFlexItem>
                            {item.made_from}-{item.made_to}
                        </EuiFlexItem>
                    </EuiFlexGroup>
                ),
            },
            {
                field: 'fuel_type',
                name: 'Fuel Type',
                truncateText: true,
                mobileOptions: {
                    show: false,
                },
            },
            {
                field: 'engine_capacity',
                name: 'Engine Capacity',
                render: capacity => capacity / 1000 + "l",
            },
            {
                field: 'power',
                name: 'Power',
                render: power => power + "kw",

            }
        ];

        const pagination = {
            pageIndex,
            pageSize,
            totalItemCount,
            pageSizeOptions: [5, 10, 20],
            hidePerPageOptions: !showPerPageOptions,
        };

        return (
            <div>
                <EuiSwitch
                    label={
                        <span>
              Hide per page options with{' '}
            </span>
                    }
                    onChange={this.togglePerPageOptions}
                />
                <EuiSpacer size="xl" />
                <EuiBasicTable
                    items={pageOfItems}
                    columns={columns}
                    pagination={pagination}
                    onChange={this.onTableChange}
                />
            </div>

        );
    }
}

export default withRouter(VehicleList);
