<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$RegionDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregiondelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fregiondelete = currentForm = new ew.Form("fregiondelete", "delete");
    loadjs.done("fregiondelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.region) ew.vars.tables.region = <?= JsonEncode(GetClientVar("tables", "region")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregiondelete" id="fregiondelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="region">
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
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
        <th class="<?= $Page->CodRegion->headerCellClass() ?>"><span id="elh_region_CodRegion" class="region_CodRegion"><?= $Page->CodRegion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
        <th class="<?= $Page->Sigla->headerCellClass() ?>"><span id="elh_region_Sigla" class="region_Sigla"><?= $Page->Sigla->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Descripcion->Visible) { // Descripcion ?>
        <th class="<?= $Page->Descripcion->headerCellClass() ?>"><span id="elh_region_Descripcion" class="region_Descripcion"><?= $Page->Descripcion->caption() ?></span></th>
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
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
        <td <?= $Page->CodRegion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_region_CodRegion" class="region_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<?= $Page->CodRegion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
        <td <?= $Page->Sigla->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_region_Sigla" class="region_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<?= $Page->Sigla->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Descripcion->Visible) { // Descripcion ?>
        <td <?= $Page->Descripcion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_region_Descripcion" class="region_Descripcion">
<span<?= $Page->Descripcion->viewAttributes() ?>>
<?= $Page->Descripcion->getViewValue() ?></span>
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
