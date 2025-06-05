<?php
use WHMCS\Database\Capsule;

function kn_hfi_getData()
{
    if (isset($_POST["kn_hfi"])) {
        return $_POST["kn_hfi"];
    }
    $query = Capsule::table('tbladdonmodules')->where('module', '=', 'kn_header_footer_injection');
    $data = [];
    foreach ($query->get() as $res)
        $data[$res->setting] = $res->value;
    $_POST["kn_hfi"] = $data;
    return $_POST["kn_hfi"];
}

function kn_hfi_head($vars)
{
    $data = kn_hfi_getData();
    return ($data["head-enable"] == "on" && $data["head"]) ? trim($data["head"]) : '';
}

function kn_hfi_header($vars)
{
    $data = kn_hfi_getData();
    return ($data["header-enable"] == "on" && $data["header"]) ? trim($data["header"]) : '';
}

function kn_hfi_footer($vars)
{
    $data = kn_hfi_getData();
    return ($data["footer-enable"] == "on" && $data["footer"]) ? trim($data["footer"]) : '';
}

add_hook("ClientAreaHeadOutput", 1, "kn_hfi_head");
add_hook("ClientAreaHeaderOutput", 1, "kn_hfi_header");
add_hook("ClientAreaFooterOutput", 1, "kn_hfi_footer");
