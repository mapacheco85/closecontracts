<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ServicioDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fserviciodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fserviciodelete = currentForm = new ew.Form("fserviciodelete", "delete");
    loadjs.done("fserviciodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.servicio) ew.vars.tables.servicio = <?= JsonEncode(GetClientVar("tables", "servicio")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fserviciodelete" id="fserviciodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="servicio">
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
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <th class="<?= $Page->CodServicio->headerCellClass() ?>"><span id="elh_servicio_CodServicio" class="servicio_CodServicio"><?= $Page->CodServicio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
        <th class="<?= $Page->Sigla->headerCellClass() ?>"><span id="elh_servicio_Sigla" class="servicio_Sigla"><?= $Page->Sigla->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
        <th class="<?= $Page->Nombre->headerCellClass() ?>"><span id="elh_servicio_Nombre" class="servicio_Nombre"><?= $Page->Nombre->caption() ?></span></th>
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
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <td <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_servicio_CodServicio" class="servicio_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
        <td <?= $Page->Sigla->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_servicio_Sigla" class="servicio_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<?= $Page->Sigla->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
        <td <?= $Page->Nombre->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_servicio_Nombre" class="servicio_Nombre">
<span<?= $Page->Nombre->viewAttributes() ?>>
<?= $Page->Nombre->getViewValue() ?></span>
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
