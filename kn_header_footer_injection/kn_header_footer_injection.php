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

function kn_header_footer_injection_config()
{
    global $_ADDONLANG, $adminlang;

    $langFile = __DIR__ . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'english.php';
    if (file_exists($langFile)) {
        require $langFile;
    }

    if (!empty($adminlang)) {
        $override = __DIR__ . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $adminlang . '.php';
        if (file_exists($override)) {
            require $override;
        }
    }

    return array(
        "name" => $_ADDONLANG['module_name'],
        "description" => $_ADDONLANG['module_description'],
        "version" => "0.2",
        "author" => "MyPanelHost LLC",
        "language" => "english",
        "fields" => array(
            "head" => array (
                "FriendlyName" => $_ADDONLANG['head_friendly'],
                "Type" => "textarea",
                "Rows" => "10",
                "Cols" => "100",
                "Description" => $_ADDONLANG['head_description'],
                "Default" => "",
            ),
            "header" => array (
                "FriendlyName" => $_ADDONLANG['header_friendly'],
                "Type" => "textarea",
                "Rows" => "10",
                "Cols" => "100",
                "Description" => $_ADDONLANG['header_description'],
                "Default" => "",
            ),
            "footer" => array (
                "FriendlyName" => $_ADDONLANG['footer_friendly'],
                "Type" => "textarea",
                "Rows" => "10",
                "Cols" => "100",
                "Description" => $_ADDONLANG['footer_description'],
                "Default" => "",
            ),
            "head-enable" => array (
                "FriendlyName" => $_ADDONLANG['head_enable_friendly'],
                "Type" =>  "yesno",
                "Size" => "55",
                "Description" => $_ADDONLANG['head_enable_description'],
                "Default" => "yes",
            ),
            "header-enable" => array (
                "FriendlyName" => $_ADDONLANG['header_enable_friendly'],
                "Type" =>  "yesno",
                "Size" => "55",
                "Description" => $_ADDONLANG['header_enable_description'],
                "Default" => "yes",
            ),
            "footer-enable" => array (
                "FriendlyName" => $_ADDONLANG['footer_enable_friendly'],
                "Type" =>  "yesno",
                "Size" => "55",
                "Description" => $_ADDONLANG['footer_enable_description'],
                "Default" => "yes",
            )
        )
    );
}

// Incluir los hooks si existe el archivo
if (file_exists(__DIR__ . '/hooks.php')) {
    require_once __DIR__ . '/hooks.php';
}
