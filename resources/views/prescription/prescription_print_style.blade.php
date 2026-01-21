<style type="text/css">
.basic-details tr,
.basic-details td {
    font-size: 12px !important;
}

.time-font b {
    font-size: 16px;
}

.date-selection input {
    font-weight: bold !important;
}

.alt-image {
    width: 25px !important;
    height: 25px !important;
}

.print table .prescribed-by td {
    font-size: 12px;
}

@media only screen {
    .basic-details td {
        width: unset;
        height: unset;
    }
}

@media print {
    body.print {
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
    .prescription-data-list td {
        font-size: 12px;
    }
    #regulardrug_1 .cell-bg {
        height: 20px;
    }
    .once_only_1 .user-info-cell {
        height: 23px;
    }
    #regulardrug_2 .cell-bg {
        height: 22px;
    }
    .once_only_2 .user-info-cell {
        height: 21px;
    }
    #requireddrug .cell-bg {
        height: 21px;
    }
    .intravenous-full td,
    .intravenous-empty td {
        height: 27px;
    }
    #regulardrug_1 .user-sign,
    #regulardrug_2 .user-sign {
        width: 100px !important;
        height: 25px !important;
    }
    .once_only_1 .user-sign,
    .once_only_2 .user-sign {
        width: 100px !important;
        height: 25px !important;
    }
    .confirm-date,
    .stop-date,
    .cancel-date {
        font-size: 10px !important;
    }
    .time-font {
        font-size: 14px !important;
    }
    .prescribed-by {
        width: 300px;
    }
    .print table:not(.ui-datepicker-calendar) td,
    .print table:not(.ui-datepicker-calendar) th {
/*        padding: unset !important;*/
    }
    .prescription-print-sheet img:not(.user-sign):not(.image-logo):not(.alt-image):not(.barcode-content img) {
        width: 25px !important;
/*        height: 12px !important;*/
    }
    .print table .prescribed-by td {
        white-space: nowrap;
        font-size: 10px !important;
    }
    .print table .prescribed-by td span {
        white-space: nowrap;
        font-size: 9px;
    }
}

@page {
    /*size: A4;*/
}

</style>
