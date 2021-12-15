<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ProveedorDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fproveedordelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fproveedordelete = currentForm = new ew.Form("fproveedordelete", "delete");
    loadjs.done("fproveedordelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.proveedor) ew.vars.tables.proveedor = <?= JsonEncode(GetClientVar("tables", "proveedor")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fproveedordelete" id="fproveedordelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <th class="<?= $Page->CodProveedor->headerCellClass() ?>"><span id="elh_proveedor_CodProveedor" class="proveedor_CodProveedor"><?= $Page->CodProveedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <th class="<?= $Page->RazonSocial->headerCellClass() ?>"><span id="elh_proveedor_RazonSocial" class="proveedor_RazonSocial"><?= $Page->RazonSocial->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
        <th class="<?= $Page->Propietario->headerCellClass() ?>"><span id="elh_proveedor_Propietario" class="proveedor_Propietario"><?= $Page->Propietario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
        <th class="<?= $Page->NIT->headerCellClass() ?>"><span id="elh_proveedor_NIT" class="proveedor_NIT"><?= $Page->NIT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
        <th class="<?= $Page->Cedula->headerCellClass() ?>"><span id="elh_proveedor_Cedula" class="proveedor_Cedula"><?= $Page->Cedula->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Telefono->Visible) { // Telefono ?>
        <th class="<?= $Page->Telefono->headerCellClass() ?>"><span id="elh_proveedor_Telefono" class="proveedor_Telefono"><?= $Page->Telefono->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
        <th class="<?= $Page->Direccion->headerCellClass() ?>"><span id="elh_proveedor_Direccion" class="proveedor_Direccion"><?= $Page->Direccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
        <th class="<?= $Page->CodRegion->headerCellClass() ?>"><span id="elh_proveedor_CodRegion" class="proveedor_CodRegion"><?= $Page->CodRegion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
        <th class="<?= $Page->Vigente->headerCellClass() ?>"><span id="elh_proveedor_Vigente" class="proveedor_Vigente"><?= $Page->Vigente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MinimoValidado->Visible) { // MinimoValidado ?>
        <th class="<?= $Page->MinimoValidado->headerCellClass() ?>"><span id="elh_proveedor_MinimoValidado" class="proveedor_MinimoValidado"><?= $Page->MinimoValidado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_transferencia->Visible) { // tipo_transferencia ?>
        <th class="<?= $Page->tipo_transferencia->headerCellClass() ?>"><span id="elh_proveedor_tipo_transferencia" class="proveedor_tipo_transferencia"><?= $Page->tipo_transferencia->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <td <?= $Page->CodProveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_CodProveedor" class="proveedor_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<?= $Page->CodProveedor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <td <?= $Page->RazonSocial->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_RazonSocial" class="proveedor_RazonSocial">
<span<?= $Page->RazonSocial->viewAttributes() ?>>
<?= $Page->RazonSocial->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
        <td <?= $Page->Propietario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Propietario" class="proveedor_Propietario">
<span<?= $Page->Propietario->viewAttributes() ?>>
<?= $Page->Propietario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
        <td <?= $Page->NIT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_NIT" class="proveedor_NIT">
<span<?= $Page->NIT->viewAttributes() ?>>
<?= $Page->NIT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
        <td <?= $Page->Cedula->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Cedula" class="proveedor_Cedula">
<span<?= $Page->Cedula->viewAttributes() ?>>
<?= $Page->Cedula->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Telefono->Visible) { // Telefono ?>
        <td <?= $Page->Telefono->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Telefono" class="proveedor_Telefono">
<span<?= $Page->Telefono->viewAttributes() ?>>
<?= $Page->Telefono->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
        <td <?= $Page->Direccion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Direccion" class="proveedor_Direccion">
<span<?= $Page->Direccion->viewAttributes() ?>>
<?= $Page->Direccion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
        <td <?= $Page->CodRegion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_CodRegion" class="proveedor_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<?= $Page->CodRegion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
        <td <?= $Page->Vigente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Vigente" class="proveedor_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MinimoValidado->Visible) { // MinimoValidado ?>
        <td <?= $Page->MinimoValidado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_MinimoValidado" class="proveedor_MinimoValidado">
<span<?= $Page->MinimoValidado->viewAttributes() ?>>
<?= $Page->MinimoValidado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_transferencia->Visible) { // tipo_transferencia ?>
        <td <?= $Page->tipo_transferencia->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_tipo_transferencia" class="proveedor_tipo_transferencia">
<span<?= $Page->tipo_transferencia->viewAttributes() ?>>
<?= $Page->tipo_transferencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
