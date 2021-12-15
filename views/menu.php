<?php

namespace PHPMaker2021\CloseContracts;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
$topMenu->addMenuItem(4, "mi_region", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "regionlist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}region'), false, false, "", "", true);
$topMenu->addMenuItem(5, "mi_servicio", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "serviciolist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}servicio'), false, false, "", "", true);
$topMenu->addMenuItem(2, "mi_documento", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "documentolist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}documento'), false, false, "", "", true);
$topMenu->addMenuItem(3, "mi_proveedor", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "proveedorlist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}proveedor'), false, false, "", "", true);
$topMenu->addMenuItem(1, "mi_contrato", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "contratolist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}contrato'), false, false, "", "", true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(9, "mi_resumen", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "resumenlist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}resumen'), false, false, "", "", false);
$sideMenu->addMenuItem(8, "mi_vencimientos", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "vencimientoslist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}vencimientos'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_region", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "regionlist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}region'), false, false, "", "", true);
$sideMenu->addMenuItem(5, "mi_servicio", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "serviciolist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}servicio'), false, false, "", "", true);
$sideMenu->addMenuItem(2, "mi_documento", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "documentolist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}documento'), false, false, "", "", true);
$sideMenu->addMenuItem(3, "mi_proveedor", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "proveedorlist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}proveedor'), false, false, "", "", true);
$sideMenu->addMenuItem(1, "mi_contrato", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "contratolist", -1, "", IsLoggedIn() || AllowListMenu('{C3D45A32-4DD0-4A67-894A-3DE81DFB0FC6}contrato'), false, false, "", "", true);
echo $sideMenu->toScript();
