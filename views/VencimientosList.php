<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$VencimientosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fvencimientoslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fvencimientoslist = currentForm = new ew.Form("fvencimientoslist", "list");
    fvencimientoslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fvencimientoslist");
});
var fvencimientoslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fvencimientoslistsrch = currentSearchForm = new ew.Form("fvencimientoslistsrch");

    // Dynamic selection lists

    // Filters
    fvencimientoslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fvencimientoslistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fvencimientoslistsrch" id="fvencimientoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fvencimientoslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vencimientos">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> vencimientos">
<form name="fvencimientoslist" id="fvencimientoslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="vencimientos">
<div id="gmp_vencimientos" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_vencimientoslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->CodContrato->Visible) { // CodContrato ?>
        <th data-name="CodContrato" class="<?= $Page->CodContrato->headerCellClass() ?>"><div id="elh_vencimientos_CodContrato" class="vencimientos_CodContrato"><?= $Page->renderSort($Page->CodContrato) ?></div></th>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
        <th data-name="Sigla" class="<?= $Page->Sigla->headerCellClass() ?>"><div id="elh_vencimientos_Sigla" class="vencimientos_Sigla"><?= $Page->renderSort($Page->Sigla) ?></div></th>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <th data-name="Vencimiento" class="<?= $Page->Vencimiento->headerCellClass() ?>"><div id="elh_vencimientos_Vencimiento" class="vencimientos_Vencimiento"><?= $Page->renderSort($Page->Vencimiento) ?></div></th>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <th data-name="CodigoInterno" class="<?= $Page->CodigoInterno->headerCellClass() ?>"><div id="elh_vencimientos_CodigoInterno" class="vencimientos_CodigoInterno"><?= $Page->renderSort($Page->CodigoInterno) ?></div></th>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <th data-name="RazonSocial" class="<?= $Page->RazonSocial->headerCellClass() ?>"><div id="elh_vencimientos_RazonSocial" class="vencimientos_RazonSocial"><?= $Page->renderSort($Page->RazonSocial) ?></div></th>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
        <th data-name="Propietario" class="<?= $Page->Propietario->headerCellClass() ?>"><div id="elh_vencimientos_Propietario" class="vencimientos_Propietario"><?= $Page->renderSort($Page->Propietario) ?></div></th>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <th data-name="MotivoBaja" class="<?= $Page->MotivoBaja->headerCellClass() ?>"><div id="elh_vencimientos_MotivoBaja" class="vencimientos_MotivoBaja"><?= $Page->renderSort($Page->MotivoBaja) ?></div></th>
<?php } ?>
<?php if ($Page->DiasVcto->Visible) { // DiasVcto ?>
        <th data-name="DiasVcto" class="<?= $Page->DiasVcto->headerCellClass() ?>"><div id="elh_vencimientos_DiasVcto" class="vencimientos_DiasVcto"><?= $Page->renderSort($Page->DiasVcto) ?></div></th>
<?php } ?>
<?php if ($Page->Observacion->Visible) { // Observacion ?>
        <th data-name="Observacion" class="<?= $Page->Observacion->headerCellClass() ?>"><div id="elh_vencimientos_Observacion" class="vencimientos_Observacion"><?= $Page->renderSort($Page->Observacion) ?></div></th>
<?php } ?>
<?php if ($Page->Observacion->Visible) { // Observacion ?>
        <th data-name="Impresi??n" class="<?= $Page->Observacion->headerCellClass() ?>"><div id="elh_vencimientos_Observacion" class="vencimientos_Observacion">Impresi??n</div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_vencimientos", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->CodContrato->Visible) { // CodContrato ?>
        <td data-name="CodContrato" <?= $Page->CodContrato->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<?= $Page->CodContrato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sigla->Visible) { // Sigla ?>
        <td data-name="Sigla" <?= $Page->Sigla->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<?= $Page->Sigla->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <td data-name="Vencimiento" <?= $Page->Vencimiento->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_Vencimiento">
<span<?= $Page->Vencimiento->viewAttributes() ?>>
<?= $Page->Vencimiento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <td data-name="CodigoInterno" <?= $Page->CodigoInterno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_CodigoInterno">
<span<?= $Page->CodigoInterno->viewAttributes() ?>>
<?= $Page->CodigoInterno->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <td data-name="RazonSocial" <?= $Page->RazonSocial->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_RazonSocial">
<span<?= $Page->RazonSocial->viewAttributes() ?>>
<?= $Page->RazonSocial->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propietario->Visible) { // Propietario ?>
        <td data-name="Propietario" <?= $Page->Propietario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_Propietario">
<span<?= $Page->Propietario->viewAttributes() ?>>
<?= $Page->Propietario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <td data-name="MotivoBaja" <?= $Page->MotivoBaja->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_MotivoBaja">
<span<?= $Page->MotivoBaja->viewAttributes() ?>>
<?= $Page->MotivoBaja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php
      //vencimiento
      $color="style='color: #900C3F;'";
      if ($Page->DiasVcto->getViewValue()<= 30 && $Page->DiasVcto->getViewValue()>= 0)
        $color="style='color: #900C3F;'";
      elseif ($Page->DiasVcto->getViewValue()<= 45 && $Page->DiasVcto->getViewValue()> 30)
          $color="style='color: #FF5733;'";
      elseif ($Page->DiasVcto->getViewValue()> 45)
            $color="style='color: #145A32;'";
      else
              $color="style='color: #900C3F;'";

    ?>
    <?php if ($Page->DiasVcto->Visible) { // DiasVcto ?>
        <td data-name="DiasVcto" <?= $Page->DiasVcto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_DiasVcto">
<span<?= $Page->DiasVcto->viewAttributes() ?> <?= $color ?> >
<?= $Page->DiasVcto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Observacion->Visible) { // Observacion ?>
        <td data-name="Observacion" <?= $Page->Observacion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_Observacion">
<span<?= $Page->Observacion->viewAttributes() ?> <?= $color ?> >
<?= $Page->Observacion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>

    <?php if ($Page->Observacion->Visible) { // Observacion ?>
        <td data-name="Impresion" <?= $Page->Observacion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vencimientos_impresion">
<span<?= $Page->Observacion->viewAttributes() ?>>
<?php if ($Page->Sigla->getViewValue()=="RXS") {?>
<a target="_blank" href="impresionRxS.php?value=<?= $Page->CodContrato->getViewValue() ?>">Imprimir</a>
<?php } else { ?>
<a target="_blank" href="impresionProyVTA.php?value=<?= $Page->CodContrato->getViewValue() ?>">Imprimir</a>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("vencimientos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
