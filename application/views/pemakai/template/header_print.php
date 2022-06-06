<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NAVARA</title>
    <link rel="shortcut icon" href="<?= base_url('assets/') ?>logo/favicon.png" type="image/x-icon" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <!-- <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/fontawesome-free/css/all.min.css"> -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">


    <!-- DataTables -->
    <link rel="stylesheet"
        href="<?= base_url('assets/admin/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?= base_url('assets/admin/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
        href="<?= base_url('assets/admin/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/daterangepicker/daterangepicker.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>dist/css/adminlte.min.css">
    <style type="text/css">
    .jedatombol {
        margin: 2px;
    }

    .text-center {
        text-align: center !important
    }

    .logodisp {
        float: left;
        position: relative;
        width: 80px;
        height: 80px;
        margin: .5rem 0 5 .5rem;
    }

    .header {
        text-align: center;
        margin: 0;

    }

    .pemkot {
        font-size: 20pt;
        font-family: Arial, Helvetica, sans-serif;
    }

    .dinas {
        font-size: 28pt;
        font-family: Arial, Helvetica, sans-serif;
    }

    .alamat {
        text-align: center;
        font-family: 'Times New Roman', Times, serif;
        font-size: 10pt;
    }

    .title {
        margin-top: 10;
        text-align: center;
        font-family: 'Times New Roman';
        font-size: 14pt;
    }

    .text-bap {
        text-align: justify;
        font-family: 'Times New Roman';
        font-size: 12pt;
        line-height: 1.6;
    }

    .hr-satu {
        display: block;
        height: 1px;
        border: 0;
        border-top: 2px solid #000;
        margin-top: 10;
    }

    .hr-dua {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #000;
    }

    #inner {
        margin: 0 auto;
    }

    /* body {
            background-image: url("<?php echo base_url('assets/logo/pemkot.png'); ?>");
        } */
    .content-container:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        background-image: url("<?php echo base_url('assets/logo/logo-pemkot.png'); ?>");
        background-size: 500px;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;
        height: 100%;
        opacity: .2;
        z-index: 2;

    }

    @media screen {
        div.footer-print {
            display: none;
        }
    }

    @media print {
        div.footer-print {
            position: fixed;
            bottom: 0;
        }
    }

    /* .table-content {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    .th-content,
    .td-content {
        text-align: left;
        padding: 8px;
    }

    .tr-content:nth-child(even) {
        background-color: #f2f2f2
    } */

    /* ol {
        display: table !important;
        width: 100% !important;
    }

    ol li {
		display: table-cell !important;
    } */

    /* table,
    th,
    td {
		border: 1px solid black;
        border-collapse: collapse;
    } */
    </style>
</head>

<body>