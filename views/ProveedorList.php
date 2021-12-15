<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ProveedorList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproveedorlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fproveedorlist = currentForm = new ew.Form("fproveedorlist", "list");
    fproveedorlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fproveedorlist");
});
var fproveedorlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fproveedorlistsrch = currentSearchForm = new ew.Form("fproveedorlistsrch");

    // Dynamic selection lists

    // Filters
    fproveedorlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fproveedorlistsrch");
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
<form name="fproveedorlistsrch" id="fproveedorlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fproveedorlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="proveedor">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> proveedor">
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
<form name="fproveedorlist" id="fproveedorlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<div id="gmp_proveedor" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_proveedorlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <th data-name="CodProveedor" class="<?= $Page->CodProveedor->headerCellClass() ?>"><div id="elh_proveedor_CodProveedor" class="proveedor_CodProveedor"><?= $Page->renderSort($Page->CodProveedor) ?></div></th>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <th data-name="RazonSocial" class="<?= $Page->RazonSocial->headerCellClass() ?>"><div id="elh_proveedor_RazonSocial" class="proveedor_RazonSocial"><?= $Page->renderSort($Page->RazonSocial) ?></div></th>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
        <th data-name="Propietario" class="<?= $Page->Propietario->headerCellClass() ?>"><div id="elh_proveedor_Propietario" class="proveedor_Propietario"><?= $Page->renderSort($Page->Propietario) ?></div></th>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
        <th data-name="NIT" class="<?= $Page->NIT->headerCellClass() ?>"><div id="elh_proveedor_NIT" class="proveedor_NIT"><?= $Page->renderSort($Page->NIT) ?></div></th>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
        <th data-name="Cedula" class="<?= $Page->Cedula->headerCellClass() ?>"><div id="elh_proveedor_Cedula" class="proveedor_Cedula"><?= $Page->renderSort($Page->Cedula) ?></div></th>
<?php } ?>
<?php if ($Page->Telefono->Visible) { // Telefono ?>
        <th data-name="Telefono" class="<?= $Page->Telefono->headerCellClass() ?>"><div id="elh_proveedor_Telefono" class="proveedor_Telefono"><?= $Page->renderSort($Page->Telefono) ?></div></th>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
        <th data-name="Direccion" class="<?= $Page->Direccion->headerCellClass() ?>"><div id="elh_proveedor_Direccion" class="proveedor_Direccion"><?= $Page->renderSort($Page->Direccion) ?></div></th>
<?php } ?>
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
        <th data-name="CodRegion" class="<?= $Page->CodRegion->headerCellClass() ?>"><div id="elh_proveedor_CodRegion" class="proveedor_CodRegion"><?= $Page->renderSort($Page->CodRegion) ?></div></th>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
        <th data-name="Vigente" class="<?= $Page->Vigente->headerCellClass() ?>"><div id="elh_proveedor_Vigente" class="proveedor_Vigente"><?= $Page->renderSort($Page->Vigente) ?></div></th>
<?php } ?>
<?php if ($Page->MinimoValidado->Visible) { // MinimoValidado ?>
        <th data-name="MinimoValidado" class="<?= $Page->MinimoValidado->headerCellClass() ?>"><div id="elh_proveedor_MinimoValidado" class="proveedor_MinimoValidado"><?= $Page->renderSort($Page->MinimoValidado) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_transferencia->Visible) { // tipo_transferencia ?>
        <th data-name="tipo_transferencia" class="<?= $Page->tipo_transferencia->headerCellClass() ?>"><div id="elh_proveedor_tipo_transferencia" class="proveedor_tipo_transferencia"><?= $Page->renderSort($Page->tipo_transferencia) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_proveedor", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
        <td data-name="CodProveedor" <?= $Page->CodProveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<?= $Page->CodProveedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
        <td data-name="RazonSocial" <?= $Page->RazonSocial->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_RazonSocial">
<span<?= $Page->RazonSocial->viewAttributes() ?>>
<?= $Page->RazonSocial->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propietario->Visible) { // Propietario ?>
        <td data-name="Propietario" <?= $Page->Propietario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Propietario">
<span<?= $Page->Propietario->viewAttributes() ?>>
<?= $Page->Propietario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIT->Visible) { // NIT ?>
        <td data-name="NIT" <?= $Page->NIT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_NIT">
<span<?= $Page->NIT->viewAttributes() ?>>
<?= $Page->NIT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Cedula->Visible) { // Cedula ?>
        <td data-name="Cedula" <?= $Page->Cedula->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Cedula">
<span<?= $Page->Cedula->viewAttributes() ?>>
<?= $Page->Cedula->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Telefono->Visible) { // Telefono ?>
        <td data-name="Telefono" <?= $Page->Telefono->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Telefono">
<span<?= $Page->Telefono->viewAttributes() ?>>
<?= $Page->Telefono->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Direccion->Visible) { // Direccion ?>
        <td data-name="Direccion" <?= $Page->Direccion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Direccion">
<span<?= $Page->Direccion->viewAttributes() ?>>
<?= $Page->Direccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodRegion->Visible) { // CodRegion ?>
        <td data-name="CodRegion" <?= $Page->CodRegion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<?= $Page->CodRegion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Vigente->Visible) { // Vigente ?>
        <td data-name="Vigente" <?= $Page->Vigente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MinimoValidado->Visible) { // MinimoValidado ?>
        <td data-name="MinimoValidado" <?= $Page->MinimoValidado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_MinimoValidado">
<span<?= $Page->MinimoValidado->viewAttributes() ?>>
<?= $Page->MinimoValidado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_transferencia->Visible) { // tipo_transferencia ?>
        <td data-name="tipo_transferencia" <?= $Page->tipo_transferencia->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_proveedor_tipo_transferencia">
<span<?= $Page->tipo_transferencia->viewAttributes() ?>>
<?= $Page->tipo_transferencia->getViewValue() ?></span>
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
    ew.addEventHandlers("proveedor");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
