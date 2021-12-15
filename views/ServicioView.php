<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ServicioView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fservicioview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fservicioview = currentForm = new ew.Form("fservicioview", "view");
    loadjs.done("fservicioview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.servicio) ew.vars.tables.servicio = <?= JsonEncode(GetClientVar("tables", "servicio")) ?>;
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
<form name="fservicioview" id="fservicioview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="servicio">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <tr id="r_CodServicio">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_servicio_CodServicio"><?= $Page->CodServicio->caption() ?></span></td>
        <td data-name="CodServicio" <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el_servicio_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
    <tr id="r_Sigla">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_servicio_Sigla"><?= $Page->Sigla->caption() ?></span></td>
        <td data-name="Sigla" <?= $Page->Sigla->cellAttributes() ?>>
<span id="el_servicio_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<?= $Page->Sigla->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
    <tr id="r_Nombre">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_servicio_Nombre"><?= $Page->Nombre->caption() ?></span></td>
        <td data-name="Nombre" <?= $Page->Nombre->cellAttributes() ?>>
<span id="el_servicio_Nombre">
<span<?= $Page->Nombre->viewAttributes() ?>>
<?= $Page->Nombre->getViewValue() ?></span>
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
