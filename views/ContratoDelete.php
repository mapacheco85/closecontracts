<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ContratoDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcontratodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcontratodelete = currentForm = new ew.Form("fcontratodelete", "delete");
    loadjs.done("fcontratodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.contrato) ew.vars.tables.contrato = <?= JsonEncode(GetClientVar("tables", "contrato")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcontratodelete" id="fcontratodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
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
<?php if ($Page->CodContrato->Visible) { // CodContrato ?>
        <th class="<?= $Page->CodContrato->headerCellClass() ?>"><span id="elh_contrato_CodContrato" class="contrato_CodContrato"><?= $Page->CodContrato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
        <th class="<?= $Page->Fecha->headerCellClass() ?>"><span id="elh_contrato_Fecha" class="contrato_Fecha"><?= $Page->Fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
        <th class="<?= $Page->Lugar->headerCellClass() ?>"><span id="elh_contrato_Lugar" class="contrato_Lugar"><?= $Page->Lugar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <th class="<?= $Page->Vencimiento->headerCellClass() ?>"><span id="elh_contrato_Vencimiento" class="contrato_Vencimiento"><?= $Page->Vencimiento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <th class="<?= $Page->CodigoInterno->headerCellClass() ?>"><span id="elh_contrato_CodigoInterno" class="contrato_CodigoInterno"><?= $Page->CodigoInterno->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <th class="<?= $Page->MotivoBaja->headerCellClass() ?>"><span id="elh_contrato_MotivoBaja" class="contrato_MotivoBaja"><?= $Page->MotivoBaja->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
        <th class="<?= $Page->Vigente->headerCellClass() ?>"><span id="elh_contrato_Vigente" class="contrato_Vigente"><?= $Page->Vigente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <th class="<?= $Page->CodServicio->headerCellClass() ?>"><span id="elh_contrato_CodServicio" class="contrato_CodServicio"><?= $Page->CodServicio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <th class="<?= $Page->CodProveedor->headerCellClass() ?>"><span id="elh_contrato_CodProveedor" class="contrato_CodProveedor"><?= $Page->CodProveedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Monto->Visible) { // Monto ?>
        <th class="<?= $Page->Monto->headerCellClass() ?>"><span id="elh_contrato_Monto" class="contrato_Monto"><?= $Page->Monto->caption() ?></span></th>
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
<?php if ($Page->CodContrato->Visible) { // CodContrato ?>
        <td <?= $Page->CodContrato->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodContrato" class="contrato_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<?= $Page->CodContrato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
        <td <?= $Page->Fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Fecha" class="contrato_Fecha">
<span<?= $Page->Fecha->viewAttributes() ?>>
<?= $Page->Fecha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
        <td <?= $Page->Lugar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Lugar" class="contrato_Lugar">
<span<?= $Page->Lugar->viewAttributes() ?>>
<?= $Page->Lugar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <td <?= $Page->Vencimiento->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Vencimiento" class="contrato_Vencimiento">
<span<?= $Page->Vencimiento->viewAttributes() ?>>
<?= $Page->Vencimiento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <td <?= $Page->CodigoInterno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodigoInterno" class="contrato_CodigoInterno">
<span<?= $Page->CodigoInterno->viewAttributes() ?>>
<?= $Page->CodigoInterno->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <td <?= $Page->MotivoBaja->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_MotivoBaja" class="contrato_MotivoBaja">
<span<?= $Page->MotivoBaja->viewAttributes() ?>>
<?= $Page->MotivoBaja->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
        <td <?= $Page->Vigente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Vigente" class="contrato_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <td <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodServicio" class="contrato_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <td <?= $Page->CodProveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodProveedor" class="contrato_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<?= $Page->CodProveedor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Monto->Visible) { // Monto ?>
        <td <?= $Page->Monto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Monto" class="contrato_Monto">
<span<?= $Page->Monto->viewAttributes() ?>>
<?= $Page->Monto->getViewValue() ?></span>
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
