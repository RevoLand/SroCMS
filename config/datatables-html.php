<?php

return [
    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'table table-hover data-table no-wrap mb-0 fs--1 w-100',
        'id' => 'dataTableBuilder',
    ],

    /*
     * Default condition to determine if a parameter is a callback or not.
     * Callbacks needs to start by those terms or they will be casted to string.
     */
    'callback' => ['$', '$.', 'function'],

    /*
     * Html builder script template.
     */
    'script' => 'datatables::script',

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'datatables::editor',
];
