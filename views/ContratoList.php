<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ContratoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcontratolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fcontratolist = currentForm = new ew.Form("fcontratolist", "list");
    fcontratolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fcontratolist");
});
var fcontratolistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fcontratolistsrch = currentSearchForm = new ew.Form("fcontratolistsrch");

    // Dynamic selection lists

    // Filters
    fcontratolistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fcontratolistsrch");
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
<form name="fcontratolistsrch" id="fcontratolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fcontratolistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="contrato">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> contrato">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fcontratolist" id="fcontratolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
<div id="gmp_contrato" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_contratolist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="CodContrato" class="<?= $Page->CodContrato->headerCellClass() ?>"><div id="elh_contrato_CodContrato" class="contrato_CodContrato"><?= $Page->renderSort($Page->CodContrato) ?></div></th>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
        <th data-name="Fecha" class="<?= $Page->Fecha->headerCellClass() ?>"><div id="elh_contrato_Fecha" class="contrato_Fecha"><?= $Page->renderSort($Page->Fecha) ?></div></th>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
        <th data-name="Lugar" class="<?= $Page->Lugar->headerCellClass() ?>"><div id="elh_contrato_Lugar" class="contrato_Lugar"><?= $Page->renderSort($Page->Lugar) ?></div></th>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <th data-name="Vencimiento" class="<?= $Page->Vencimiento->headerCellClass() ?>"><div id="elh_contrato_Vencimiento" class="contrato_Vencimiento"><?= $Page->renderSort($Page->Vencimiento) ?></div></th>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <th data-name="CodigoInterno" class="<?= $Page->CodigoInterno->headerCellClass() ?>"><div id="elh_contrato_CodigoInterno" class="contrato_CodigoInterno"><?= $Page->renderSort($Page->CodigoInterno) ?></div></th>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <th data-name="MotivoBaja" class="<?= $Page->MotivoBaja->headerCellClass() ?>"><div id="elh_contrato_MotivoBaja" class="contrato_MotivoBaja"><?= $Page->renderSort($Page->MotivoBaja) ?></div></th>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
        <th data-name="Vigente" class="<?= $Page->Vigente->headerCellClass() ?>"><div id="elh_contrato_Vigente" class="contrato_Vigente"><?= $Page->renderSort($Page->Vigente) ?></div></th>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <th data-name="CodServicio" class="<?= $Page->CodServicio->headerCellClass() ?>"><div id="elh_contrato_CodServicio" class="contrato_CodServicio"><?= $Page->renderSort($Page->CodServicio) ?></div></th>
<?php } ?>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <th data-name="CodProveedor" class="<?= $Page->CodProveedor->headerCellClass() ?>"><div id="elh_contrato_CodProveedor" class="contrato_CodProveedor"><?= $Page->renderSort($Page->CodProveedor) ?></div></th>
<?php } ?>
<?php if ($Page->Monto->Visible) { // Monto ?>
        <th data-name="Monto" class="<?= $Page->Monto->headerCellClass() ?>"><div id="elh_contrato_Monto" class="contrato_Monto"><?= $Page->renderSort($Page->Monto) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_contrato", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_contrato_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<?= $Page->CodContrato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Fecha->Visible) { // Fecha ?>
        <td data-name="Fecha" <?= $Page->Fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Fecha">
<span<?= $Page->Fecha->viewAttributes() ?>>
<?= $Page->Fecha->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Lugar->Visible) { // Lugar ?>
        <td data-name="Lugar" <?= $Page->Lugar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Lugar">
<span<?= $Page->Lugar->viewAttributes() ?>>
<?= $Page->Lugar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
        <td data-name="Vencimiento" <?= $Page->Vencimiento->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Vencimiento">
<span<?= $Page->Vencimiento->viewAttributes() ?>>
<?= $Page->Vencimiento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
        <td data-name="CodigoInterno" <?= $Page->CodigoInterno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodigoInterno">
<span<?= $Page->CodigoInterno->viewAttributes() ?>>
<?= $Page->CodigoInterno->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
        <td data-name="MotivoBaja" <?= $Page->MotivoBaja->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_MotivoBaja">
<span<?= $Page->MotivoBaja->viewAttributes() ?>>
<?= $Page->MotivoBaja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Vigente->Visible) { // Vigente ?>
        <td data-name="Vigente" <?= $Page->Vigente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <td data-name="CodServicio" <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <td data-name="CodProveedor" <?= $Page->CodProveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<?= $Page->CodProveedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Monto->Visible) { // Monto ?>
        <td data-name="Monto" <?= $Page->Monto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_contrato_Monto">
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
    ew.addEventHandlers("contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
