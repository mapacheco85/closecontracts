<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$RegionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fregionview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fregionview = currentForm = new ew.Form("fregionview", "view");
    loadjs.done("fregionview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.region) ew.vars.tables.region = <?= JsonEncode(GetClientVar("tables", "region")) ?>;
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
<form name="fregionview" id="fregionview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="region">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
    <tr id="r_CodRegion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_region_CodRegion"><?= $Page->CodRegion->caption() ?></span></td>
        <td data-name="CodRegion" <?= $Page->CodRegion->cellAttributes() ?>>
<span id="el_region_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<?= $Page->CodRegion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
    <tr id="r_Sigla">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_region_Sigla"><?= $Page->Sigla->caption() ?></span></td>
        <td data-name="Sigla" <?= $Page->Sigla->cellAttributes() ?>>
<span id="el_region_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<?= $Page->Sigla->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Descripcion->Visible) { // Descripcion ?>
    <tr id="r_Descripcion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_region_Descripcion"><?= $Page->Descripcion->caption() ?></span></td>
        <td data-name="Descripcion" <?= $Page->Descripcion->cellAttributes() ?>>
<span id="el_region_Descripcion">
<span<?= $Page->Descripcion->viewAttributes() ?>>
<?= $Page->Descripcion->getViewValue() ?></span>
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
