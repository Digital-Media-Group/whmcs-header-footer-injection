<?php
/**
 * Header & Footer Code Injection
 * https://mypanelhost.com
 * 
 * Permite inyectar código JS, CSS o HTML en el <head>, tras abrir <body> y antes de cerrar </body>
 * en el área de clientes de WHMCS.
 * 
 * Autor: MyPanelHost LLC
 */
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function kn_header_footer_injection_config() {
    return array(
        "name" => "Header & Footer Code Injection",
        "description" => "A module designed to inject static code (js, css, html) to header & footer of clientarea.",
        "version" => "0.1",
        "author" => "MyPanelHost LLC",
        "language" => "english",
        "fields" => array(
            "head" => array (
                "FriendlyName" => "Code in Head (between <head></head> tag i.e. JS, CSS, Meta, OG etc)",
                "Type" => "textarea",
                "Rows" => "10",
                "Cols" => "100",
                "Description" => "Example- FB Pixel Tracking.",
                "Default" => "",
            ),
            "header" => array (
                "FriendlyName" => "Code in Header (after <body> tag starts i.e. JS, CSS, HTML)",
                "Type" => "textarea",
                "Rows" => "10",
                "Cols" => "100",
                "Description" => "Example- Topbar for displaying offer or coupon code.",
                "Default" => "",
            ),
            "footer" => array (
                "FriendlyName" => "Code in Footer (before </body> i.e. JS, CSS, HTML)",
                "Type" => "textarea",
                "Rows" => "10",
                "Cols" => "100",
                "Description" => "Example- Google Analytics, Live Chat, Messenger Chat etc code.",
                "Default" => "",
            ),
            "head-enable" => array (
                "FriendlyName" => "Enable code in Head?",
                "Type" =>  "yesno",
                "Size" => "55",
                "Description" => "A quick way to enable or disable the head code on your website ",
                "Default" => "yes",
            ),
            "header-enable" => array (
                "FriendlyName" => "Enable code in Header?",
                "Type" =>  "yesno",
                "Size" => "55",
                "Description" => "A quick way to enable or disable the header code on your website ",
                "Default" => "yes",
            ),
            "footer-enable" => array (
                "FriendlyName" => "Enable code in Footer?",
                "Type" =>  "yesno",
                "Size" => "55",
                "Description" => "A quick way to enable or disable the footer code on your website ",
                "Default" => "yes",
            )
        )
    );
}

// Incluir los hooks si existe el archivo
if (file_exists(__DIR__ . '/hooks.php')) {
    require_once __DIR__ . '/hooks.php';
}
