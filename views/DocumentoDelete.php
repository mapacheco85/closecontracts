<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$DocumentoDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdocumentodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fdocumentodelete = currentForm = new ew.Form("fdocumentodelete", "delete");
    loadjs.done("fdocumentodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.documento) ew.vars.tables.documento = <?= JsonEncode(GetClientVar("tables", "documento")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdocumentodelete" id="fdocumentodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento">
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
<?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
        <th class="<?= $Page->CodDocumento->headerCellClass() ?>"><span id="elh_documento_CodDocumento" class="documento_CodDocumento"><?= $Page->CodDocumento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Gestion->Visible) { // Gestion ?>
        <th class="<?= $Page->Gestion->headerCellClass() ?>"><span id="elh_documento_Gestion" class="documento_Gestion"><?= $Page->Gestion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Codigo->Visible) { // Codigo ?>
        <th class="<?= $Page->Codigo->headerCellClass() ?>"><span id="elh_documento_Codigo" class="documento_Codigo"><?= $Page->Codigo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <th class="<?= $Page->CodServicio->headerCellClass() ?>"><span id="elh_documento_CodServicio" class="documento_CodServicio"><?= $Page->CodServicio->caption() ?></span></th>
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
<?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
        <td <?= $Page->CodDocumento->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_CodDocumento" class="documento_CodDocumento">
<span<?= $Page->CodDocumento->viewAttributes() ?>>
<?= $Page->CodDocumento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Gestion->Visible) { // Gestion ?>
        <td <?= $Page->Gestion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_Gestion" class="documento_Gestion">
<span<?= $Page->Gestion->viewAttributes() ?>>
<?= $Page->Gestion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Codigo->Visible) { // Codigo ?>
        <td <?= $Page->Codigo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_Codigo" class="documento_Codigo">
<span<?= $Page->Codigo->viewAttributes() ?>>
<?= $Page->Codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <td <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_CodServicio" class="documento_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
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
