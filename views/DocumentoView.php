<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$DocumentoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdocumentoview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fdocumentoview = currentForm = new ew.Form("fdocumentoview", "view");
    loadjs.done("fdocumentoview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.documento) ew.vars.tables.documento = <?= JsonEncode(GetClientVar("tables", "documento")) ?>;
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
<form name="fdocumentoview" id="fdocumentoview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
    <tr id="r_CodDocumento">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_CodDocumento"><?= $Page->CodDocumento->caption() ?></span></td>
        <td data-name="CodDocumento" <?= $Page->CodDocumento->cellAttributes() ?>>
<span id="el_documento_CodDocumento">
<span<?= $Page->CodDocumento->viewAttributes() ?>>
<?= $Page->CodDocumento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Gestion->Visible) { // Gestion ?>
    <tr id="r_Gestion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_Gestion"><?= $Page->Gestion->caption() ?></span></td>
        <td data-name="Gestion" <?= $Page->Gestion->cellAttributes() ?>>
<span id="el_documento_Gestion">
<span<?= $Page->Gestion->viewAttributes() ?>>
<?= $Page->Gestion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Codigo->Visible) { // Codigo ?>
    <tr id="r_Codigo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_Codigo"><?= $Page->Codigo->caption() ?></span></td>
        <td data-name="Codigo" <?= $Page->Codigo->cellAttributes() ?>>
<span id="el_documento_Codigo">
<span<?= $Page->Codigo->viewAttributes() ?>>
<?= $Page->Codigo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <tr id="r_CodServicio">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_CodServicio"><?= $Page->CodServicio->caption() ?></span></td>
        <td data-name="CodServicio" <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el_documento_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
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
