<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ContratoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcontratoview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcontratoview = currentForm = new ew.Form("fcontratoview", "view");
    loadjs.done("fcontratoview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.contrato) ew.vars.tables.contrato = <?= JsonEncode(GetClientVar("tables", "contrato")) ?>;
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
<form name="fcontratoview" id="fcontratoview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CodContrato->Visible) { // CodContrato ?>
    <tr id="r_CodContrato">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_CodContrato"><?= $Page->CodContrato->caption() ?></span></td>
        <td data-name="CodContrato" <?= $Page->CodContrato->cellAttributes() ?>>
<span id="el_contrato_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<?= $Page->CodContrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
    <tr id="r_Fecha">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_Fecha"><?= $Page->Fecha->caption() ?></span></td>
        <td data-name="Fecha" <?= $Page->Fecha->cellAttributes() ?>>
<span id="el_contrato_Fecha">
<span<?= $Page->Fecha->viewAttributes() ?>>
<?= $Page->Fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
    <tr id="r_Lugar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_Lugar"><?= $Page->Lugar->caption() ?></span></td>
        <td data-name="Lugar" <?= $Page->Lugar->cellAttributes() ?>>
<span id="el_contrato_Lugar">
<span<?= $Page->Lugar->viewAttributes() ?>>
<?= $Page->Lugar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
    <tr id="r_Vencimiento">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_Vencimiento"><?= $Page->Vencimiento->caption() ?></span></td>
        <td data-name="Vencimiento" <?= $Page->Vencimiento->cellAttributes() ?>>
<span id="el_contrato_Vencimiento">
<span<?= $Page->Vencimiento->viewAttributes() ?>>
<?= $Page->Vencimiento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
    <tr id="r_CodigoInterno">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_CodigoInterno"><?= $Page->CodigoInterno->caption() ?></span></td>
        <td data-name="CodigoInterno" <?= $Page->CodigoInterno->cellAttributes() ?>>
<span id="el_contrato_CodigoInterno">
<span<?= $Page->CodigoInterno->viewAttributes() ?>>
<?= $Page->CodigoInterno->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
    <tr id="r_MotivoBaja">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_MotivoBaja"><?= $Page->MotivoBaja->caption() ?></span></td>
        <td data-name="MotivoBaja" <?= $Page->MotivoBaja->cellAttributes() ?>>
<span id="el_contrato_MotivoBaja">
<span<?= $Page->MotivoBaja->viewAttributes() ?>>
<?= $Page->MotivoBaja->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
    <tr id="r_Vigente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_Vigente"><?= $Page->Vigente->caption() ?></span></td>
        <td data-name="Vigente" <?= $Page->Vigente->cellAttributes() ?>>
<span id="el_contrato_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <tr id="r_CodServicio">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_CodServicio"><?= $Page->CodServicio->caption() ?></span></td>
        <td data-name="CodServicio" <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el_contrato_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
    <tr id="r_CodProveedor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_CodProveedor"><?= $Page->CodProveedor->caption() ?></span></td>
        <td data-name="CodProveedor" <?= $Page->CodProveedor->cellAttributes() ?>>
<span id="el_contrato_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<?= $Page->CodProveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Monto->Visible) { // Monto ?>
    <tr id="r_Monto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_Monto"><?= $Page->Monto->caption() ?></span></td>
        <td data-name="Monto" <?= $Page->Monto->cellAttributes() ?>>
<span id="el_contrato_Monto">
<span<?= $Page->Monto->viewAttributes() ?>>
<?= $Page->Monto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Archivo->Visible) { // Archivo ?>
    <tr id="r_Archivo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contrato_Archivo"><?= $Page->Archivo->caption() ?></span></td>
        <td data-name="Archivo" <?= $Page->Archivo->cellAttributes() ?>>
<span id="el_contrato_Archivo">
<span<?= $Page->Archivo->viewAttributes() ?>>
<?= GetFileViewTag($Page->Archivo, $Page->Archivo->getViewValue(), false) ?>
</span>
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
