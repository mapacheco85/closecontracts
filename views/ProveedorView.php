<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ProveedorView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproveedorview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fproveedorview = currentForm = new ew.Form("fproveedorview", "view");
    loadjs.done("fproveedorview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.proveedor) ew.vars.tables.proveedor = <?= JsonEncode(GetClientVar("tables", "proveedor")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fproveedorview" id="fproveedorview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
    <tr id="r_CodProveedor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_CodProveedor"><?= $Page->CodProveedor->caption() ?></span></td>
        <td data-name="CodProveedor" <?= $Page->CodProveedor->cellAttributes() ?>>
<span id="el_proveedor_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<?= $Page->CodProveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
    <tr id="r_RazonSocial">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_RazonSocial"><?= $Page->RazonSocial->caption() ?></span></td>
        <td data-name="RazonSocial" <?= $Page->RazonSocial->cellAttributes() ?>>
<span id="el_proveedor_RazonSocial">
<span<?= $Page->RazonSocial->viewAttributes() ?>>
<?= $Page->RazonSocial->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
    <tr id="r_Propietario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_Propietario"><?= $Page->Propietario->caption() ?></span></td>
        <td data-name="Propietario" <?= $Page->Propietario->cellAttributes() ?>>
<span id="el_proveedor_Propietario">
<span<?= $Page->Propietario->viewAttributes() ?>>
<?= $Page->Propietario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
    <tr id="r_NIT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_NIT"><?= $Page->NIT->caption() ?></span></td>
        <td data-name="NIT" <?= $Page->NIT->cellAttributes() ?>>
<span id="el_proveedor_NIT">
<span<?= $Page->NIT->viewAttributes() ?>>
<?= $Page->NIT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
    <tr id="r_Cedula">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_Cedula"><?= $Page->Cedula->caption() ?></span></td>
        <td data-name="Cedula" <?= $Page->Cedula->cellAttributes() ?>>
<span id="el_proveedor_Cedula">
<span<?= $Page->Cedula->viewAttributes() ?>>
<?= $Page->Cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Telefono->Visible) { // Telefono ?>
    <tr id="r_Telefono">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_Telefono"><?= $Page->Telefono->caption() ?></span></td>
        <td data-name="Telefono" <?= $Page->Telefono->cellAttributes() ?>>
<span id="el_proveedor_Telefono">
<span<?= $Page->Telefono->viewAttributes() ?>>
<?= $Page->Telefono->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
    <tr id="r_Direccion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_Direccion"><?= $Page->Direccion->caption() ?></span></td>
        <td data-name="Direccion" <?= $Page->Direccion->cellAttributes() ?>>
<span id="el_proveedor_Direccion">
<span<?= $Page->Direccion->viewAttributes() ?>>
<?= $Page->Direccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
    <tr id="r_CodRegion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_CodRegion"><?= $Page->CodRegion->caption() ?></span></td>
        <td data-name="CodRegion" <?= $Page->CodRegion->cellAttributes() ?>>
<span id="el_proveedor_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<?= $Page->CodRegion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
    <tr id="r_Vigente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_Vigente"><?= $Page->Vigente->caption() ?></span></td>
        <td data-name="Vigente" <?= $Page->Vigente->cellAttributes() ?>>
<span id="el_proveedor_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MinimoValidado->Visible) { // MinimoValidado ?>
    <tr id="r_MinimoValidado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_MinimoValidado"><?= $Page->MinimoValidado->caption() ?></span></td>
        <td data-name="MinimoValidado" <?= $Page->MinimoValidado->cellAttributes() ?>>
<span id="el_proveedor_MinimoValidado">
<span<?= $Page->MinimoValidado->viewAttributes() ?>>
<?= $Page->MinimoValidado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_transferencia->Visible) { // tipo_transferencia ?>
    <tr id="r_tipo_transferencia">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_proveedor_tipo_transferencia"><?= $Page->tipo_transferencia->caption() ?></span></td>
        <td data-name="tipo_transferencia" <?= $Page->tipo_transferencia->cellAttributes() ?>>
<span id="el_proveedor_tipo_transferencia">
<span<?= $Page->tipo_transferencia->viewAttributes() ?>>
<?= $Page->tipo_transferencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
