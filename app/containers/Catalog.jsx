// @flow

import React from "react";

import CatalogTable from "../components/CatalogTable";

function Catalog(props: { posts: array, loading: boolean }) {
  const tableOptions = {
    loading: props.loading,
    defaultPageSize: 20,
    showPagination: true,
    showPageSizeOptions: true,
    pageSizeOptions: [10, 20, 50, 100],
    showPageJump: true,
    collapseOnSortingChange: true,
    collapseOnPageChange: true,
    collapseOnDataChange: true,
    freezeWhenExpanded: false,
    filterable: true,
    sortable: true,
    resizable: true,
    defaultSorted: [
      {
        id: "title",
        desc: false
      }
    ],
    defaultFilterMethod: (filter: shape, row: shape) =>
      row[filter.id].toLowerCase().indexOf(filter.value.toLowerCase()) > -1
  };

  const columns = [
    {
      Header: "Expand",
      expander: true,
      width: 75,

      style: {
        cursor: "pointer",
        fontSize: 25,
        padding: "0",
        textAlign: "center",
        userSelect: "none"
      }
    },
    {
      Header: "Title",
      accessor: "title",
      minWidth: 300
    },
    {
      Header: "Country",
      accessor: "country"
    },
    {
      Header: "Discipline",
      accessor: "discipline"
    }
  ];

  return (
    <CatalogTable
      posts={props.posts}
      columns={columns}
      tableOptions={tableOptions}
    />
  );
}

export default Catalog;
