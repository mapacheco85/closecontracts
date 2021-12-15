<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ZonaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fzonadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fzonadelete = currentForm = new ew.Form("fzonadelete", "delete");
    loadjs.done("fzonadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.zona) ew.vars.tables.zona = <?= JsonEncode(GetClientVar("tables", "zona")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fzonadelete" id="fzonadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="zona">
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
<?php if ($Page->CodZona->Visible) { // CodZona ?>
        <th class="<?= $Page->CodZona->headerCellClass() ?>"><span id="elh_zona_CodZona" class="zona_CodZona"><?= $Page->CodZona->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
        <th class="<?= $Page->Nombre->headerCellClass() ?>"><span id="elh_zona_Nombre" class="zona_Nombre"><?= $Page->Nombre->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Color->Visible) { // Color ?>
        <th class="<?= $Page->Color->headerCellClass() ?>"><span id="elh_zona_Color" class="zona_Color"><?= $Page->Color->caption() ?></span></th>
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
<?php if ($Page->CodZona->Visible) { // CodZona ?>
        <td <?= $Page->CodZona->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_zona_CodZona" class="zona_CodZona">
<span<?= $Page->CodZona->viewAttributes() ?>>
<?= $Page->CodZona->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
        <td <?= $Page->Nombre->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_zona_Nombre" class="zona_Nombre">
<span<?= $Page->Nombre->viewAttributes() ?>>
<?= $Page->Nombre->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Color->Visible) { // Color ?>
        <td <?= $Page->Color->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_zona_Color" class="zona_Color">
<span<?= $Page->Color->viewAttributes() ?>>
<?= $Page->Color->getViewValue() ?></span>
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
