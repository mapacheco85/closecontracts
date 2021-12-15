<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$Impresiones2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fimpresiones2list;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fimpresiones2list = currentForm = new ew.Form("fimpresiones2list", "list");
    fimpresiones2list.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fimpresiones2list");
});
var fimpresiones2listsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fimpresiones2listsrch = currentSearchForm = new ew.Form("fimpresiones2listsrch");

    // Dynamic selection lists

    // Filters
    fimpresiones2listsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fimpresiones2listsrch");
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
<form name="fimpresiones2listsrch" id="fimpresiones2listsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fimpresiones2listsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="impresiones2">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> impresiones2">
<form name="fimpresiones2list" id="fimpresiones2list" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="impresiones2">
<div id="gmp_impresiones2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_impresiones2list" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="CodContrato" class="<?= $Page->CodContrato->headerCellClass() ?>"><div id="elh_impresiones2_CodContrato" class="impresiones2_CodContrato"><?= $Page->renderSort($Page->CodContrato) ?></div></th>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
        <th data-name="Sigla" class="<?= $Page->Sigla->headerCellClass() ?>"><div id="elh_impresiones2_Sigla" class="impresiones2_Sigla"><?= $Page->renderSort($Page->Sigla) ?></div></th>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <th data-name="Vencimiento" class="<?= $Page->Vencimiento->headerCellClass() ?>"><div id="elh_impresiones2_Vencimiento" class="impresiones2_Vencimiento"><?= $Page->renderSort($Page->Vencimiento) ?></div></th>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <th data-name="CodigoInterno" class="<?= $Page->CodigoInterno->headerCellClass() ?>"><div id="elh_impresiones2_CodigoInterno" class="impresiones2_CodigoInterno"><?= $Page->renderSort($Page->CodigoInterno) ?></div></th>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <th data-name="RazonSocial" class="<?= $Page->RazonSocial->headerCellClass() ?>"><div id="elh_impresiones2_RazonSocial" class="impresiones2_RazonSocial"><?= $Page->renderSort($Page->RazonSocial) ?></div></th>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
        <th data-name="Propietario" class="<?= $Page->Propietario->headerCellClass() ?>"><div id="elh_impresiones2_Propietario" class="impresiones2_Propietario"><?= $Page->renderSort($Page->Propietario) ?></div></th>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <th data-name="MotivoBaja" class="<?= $Page->MotivoBaja->headerCellClass() ?>"><div id="elh_impresiones2_MotivoBaja" class="impresiones2_MotivoBaja"><?= $Page->renderSort($Page->MotivoBaja) ?></div></th>
<?php } ?>
<?php if ($Page->DiasVcto->Visible) { // DiasVcto ?>
        <th data-name="DiasVcto" class="<?= $Page->DiasVcto->headerCellClass() ?>"><div id="elh_impresiones2_DiasVcto" class="impresiones2_DiasVcto"><?= $Page->renderSort($Page->DiasVcto) ?></div></th>
<?php } ?>
<?php if ($Page->Observacion->Visible) { // Observacion ?>
        <th data-name="Observacion" class="<?= $Page->Observacion->headerCellClass() ?>"><div id="elh_impresiones2_Observacion" class="impresiones2_Observacion"><?= $Page->renderSort($Page->Observacion) ?></div></th>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
        <th data-name="Lugar" class="<?= $Page->Lugar->headerCellClass() ?>"><div id="elh_impresiones2_Lugar" class="impresiones2_Lugar"><?= $Page->renderSort($Page->Lugar) ?></div></th>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
        <th data-name="Fecha" class="<?= $Page->Fecha->headerCellClass() ?>"><div id="elh_impresiones2_Fecha" class="impresiones2_Fecha"><?= $Page->renderSort($Page->Fecha) ?></div></th>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
        <th data-name="Cedula" class="<?= $Page->Cedula->headerCellClass() ?>"><div id="elh_impresiones2_Cedula" class="impresiones2_Cedula"><?= $Page->renderSort($Page->Cedula) ?></div></th>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
        <th data-name="NIT" class="<?= $Page->NIT->headerCellClass() ?>"><div id="elh_impresiones2_NIT" class="impresiones2_NIT"><?= $Page->renderSort($Page->NIT) ?></div></th>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
        <th data-name="Direccion" class="<?= $Page->Direccion->headerCellClass() ?>"><div id="elh_impresiones2_Direccion" class="impresiones2_Direccion"><?= $Page->renderSort($Page->Direccion) ?></div></th>
<?php } ?>
<?php if ($Page->Monto->Visible) { // Monto ?>
        <th data-name="Monto" class="<?= $Page->Monto->headerCellClass() ?>"><div id="elh_impresiones2_Monto" class="impresiones2_Monto"><?= $Page->renderSort($Page->Monto) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_impresiones2", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_impresiones2_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<?= $Page->CodContrato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sigla->Visible) { // Sigla ?>
        <td data-name="Sigla" <?= $Page->Sigla->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<?= $Page->Sigla->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <td data-name="Vencimiento" <?= $Page->Vencimiento->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Vencimiento">
<span<?= $Page->Vencimiento->viewAttributes() ?>>
<?= $Page->Vencimiento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <td data-name="CodigoInterno" <?= $Page->CodigoInterno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_CodigoInterno">
<span<?= $Page->CodigoInterno->viewAttributes() ?>>
<?= $Page->CodigoInterno->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <td data-name="RazonSocial" <?= $Page->RazonSocial->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_RazonSocial">
<span<?= $Page->RazonSocial->viewAttributes() ?>>
<?= $Page->RazonSocial->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propietario->Visible) { // Propietario ?>
        <td data-name="Propietario" <?= $Page->Propietario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Propietario">
<span<?= $Page->Propietario->viewAttributes() ?>>
<?= $Page->Propietario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <td data-name="MotivoBaja" <?= $Page->MotivoBaja->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_MotivoBaja">
<span<?= $Page->MotivoBaja->viewAttributes() ?>>
<?= $Page->MotivoBaja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DiasVcto->Visible) { // DiasVcto ?>
        <td data-name="DiasVcto" <?= $Page->DiasVcto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_DiasVcto">
<span<?= $Page->DiasVcto->viewAttributes() ?>>
<?= $Page->DiasVcto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Observacion->Visible) { // Observacion ?>
        <td data-name="Observacion" <?= $Page->Observacion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Observacion">
<span<?= $Page->Observacion->viewAttributes() ?>>
<?= $Page->Observacion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Lugar->Visible) { // Lugar ?>
        <td data-name="Lugar" <?= $Page->Lugar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Lugar">
<span<?= $Page->Lugar->viewAttributes() ?>>
<?= $Page->Lugar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Fecha->Visible) { // Fecha ?>
        <td data-name="Fecha" <?= $Page->Fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Fecha">
<span<?= $Page->Fecha->viewAttributes() ?>>
<?= $Page->Fecha->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Cedula->Visible) { // Cedula ?>
        <td data-name="Cedula" <?= $Page->Cedula->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Cedula">
<span<?= $Page->Cedula->viewAttributes() ?>>
<?= $Page->Cedula->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIT->Visible) { // NIT ?>
        <td data-name="NIT" <?= $Page->NIT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_NIT">
<span<?= $Page->NIT->viewAttributes() ?>>
<?= $Page->NIT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Direccion->Visible) { // Direccion ?>
        <td data-name="Direccion" <?= $Page->Direccion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Direccion">
<span<?= $Page->Direccion->viewAttributes() ?>>
<?= $Page->Direccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Monto->Visible) { // Monto ?>
        <td data-name="Monto" <?= $Page->Monto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_impresiones2_Monto">
<span<?= $Page->Monto->viewAttributes() ?>>
<?= $Page->Monto->getViewValue() ?></span>
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
    ew.addEventHandlers("impresiones2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
