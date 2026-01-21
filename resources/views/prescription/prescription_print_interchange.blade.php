<style type="text/css">
.barcode {
    border: 1px solid black;
    width: 230px;
    float: right;
}

.barcode table {
    display: flex;
    justify-content: center;
    margin: 0px 15px 0px 5px;
    line-height: 1.2;
    border: 0px !important;
}

.barcode table tbody {
    margin-right: 15px;
}

.prescription-data-list .barcode table td {
    font-weight: normal !important;
    padding: 0px !important;
}

.barcode table td.text-center {
    text-align: center;
}

.barcode .empty {
    padding: 40px 20px;
    display: block;
}

.barcode .barcode-content {
    display: block;
    margin-left: 5px;
}

.barcode tr,
.barcode td {
    border: 0px !important;
}

.barcode .hosptial-name {
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    background-color: black;
    color: white !important;
    padding: 2px 2px;
    vertical-align: middle;
    font-size: 10px
}

.barcode .baby-mrn {
    display: unset;
    float: right;
    padding: 2px 0px;
}

.prescribed-info-border-bottom {
    text-align: center;
}

.prescribed-info-td img {
    width: 25px;
    height: 15px;
}

.confirm-date,
.stop-date,
.cancel-date {
    text-align: center;
    white-space: pre;
}

.prescription-print-sheet img:not(.user-sign):not(.image-logo):not(.alt-image):not(.barcode-content img) {
    height: 16px !important;
}

.print table:not(.ui-datepicker-calendar) td,
.print table:not(.ui-datepicker-calendar) th {
/*    padding: unset !important;*/
}

.plr-must-0 {
    padding-left: 0px !important;
    padding-right: 0px !important;
}

.mt-10 {
    margin-top: 10px;
}

.max-width {
    max-width: 100px;
}

.header-content {
    display: none;
}

.barcode td {
    width: unset !important;
    height: unset !important;
}

.barcode b {
    color: unset !important;
}

@media only screen {
    .header-text {
        margin-top: 15px;
    }
}

@media print {
    body.print .container {
        /*padding: 0px !important;*/
    }
    .prescription-data-list td {
        font-size: 13px;
    }
    /*.prescription-data-list>div>table>tbody>tr>td {
            height: 21px;
            }*/
    #regulardrug_1 .cell-bg {
        height: 33px;
    }
    .once_only_1 .user-info-cell {
        height: 30px;
    }
    #regulardrug_2 .cell-bg {
        height: 30px;
    }
    .once_only_2 .user-info-cell {
        height: 30px;
    }
    #requireddrug .cell-bg {
        height: 26px;
    }
    /*    #regulardrug_1 .cell-bg.prescription-empty,
            #regulardrug_2 .cell-bg.prescription-empty {
            height: 22px;
            }*/
    /*#requireddrug .cell-bg.prescription-empty {
            height: 18px;
            }*/
    .intravenous-full td,
    .intravenous-empty td {
        height: 37px;
    }
    /*.intravenous-empty td {
            height: 35px;
            }*/
    .user-sign {
        width: 100px !important;
        height: 30px !important;
    }
    .prescribed-by {
        /*width: 350px;*/
    }
    .print table .prescribed-by td span {
        display: block;
        font-size: 9px;
        width: max-content;
    }
    .prescribed-by img {
        width: 25px;
        height: 15px;
    }
}

@page {
    /*size: A3;*/
}

</style>
