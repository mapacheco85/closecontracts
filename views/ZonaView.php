<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ZonaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fzonaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fzonaview = currentForm = new ew.Form("fzonaview", "view");
    loadjs.done("fzonaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.zona) ew.vars.tables.zona = <?= JsonEncode(GetClientVar("tables", "zona")) ?>;
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
<form name="fzonaview" id="fzonaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="zona">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CodZona->Visible) { // CodZona ?>
    <tr id="r_CodZona">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_zona_CodZona"><?= $Page->CodZona->caption() ?></span></td>
        <td data-name="CodZona" <?= $Page->CodZona->cellAttributes() ?>>
<span id="el_zona_CodZona">
<span<?= $Page->CodZona->viewAttributes() ?>>
<?= $Page->CodZona->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
    <tr id="r_Nombre">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_zona_Nombre"><?= $Page->Nombre->caption() ?></span></td>
        <td data-name="Nombre" <?= $Page->Nombre->cellAttributes() ?>>
<span id="el_zona_Nombre">
<span<?= $Page->Nombre->viewAttributes() ?>>
<?= $Page->Nombre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Color->Visible) { // Color ?>
    <tr id="r_Color">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_zona_Color"><?= $Page->Color->caption() ?></span></td>
        <td data-name="Color" <?= $Page->Color->cellAttributes() ?>>
<span id="el_zona_Color">
<span<?= $Page->Color->viewAttributes() ?>>
<?= $Page->Color->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Coordenada->Visible) { // Coordenada ?>
    <tr id="r_Coordenada">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_zona_Coordenada"><?= $Page->Coordenada->caption() ?></span></td>
        <td data-name="Coordenada" <?= $Page->Coordenada->cellAttributes() ?>>
<span id="el_zona_Coordenada">
<span<?= $Page->Coordenada->viewAttributes() ?>>
<?= $Page->Coordenada->getViewValue() ?></span>
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
