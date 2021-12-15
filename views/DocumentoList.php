<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$DocumentoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdocumentolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fdocumentolist = currentForm = new ew.Form("fdocumentolist", "list");
    fdocumentolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fdocumentolist");
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
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> documento">
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
<form name="fdocumentolist" id="fdocumentolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento">
<div id="gmp_documento" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_documentolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
        <th data-name="CodDocumento" class="<?= $Page->CodDocumento->headerCellClass() ?>"><div id="elh_documento_CodDocumento" class="documento_CodDocumento"><?= $Page->renderSort($Page->CodDocumento) ?></div></th>
<?php } ?>
<?php if ($Page->Gestion->Visible) { // Gestion ?>
        <th data-name="Gestion" class="<?= $Page->Gestion->headerCellClass() ?>"><div id="elh_documento_Gestion" class="documento_Gestion"><?= $Page->renderSort($Page->Gestion) ?></div></th>
<?php } ?>
<?php if ($Page->Codigo->Visible) { // Codigo ?>
        <th data-name="Codigo" class="<?= $Page->Codigo->headerCellClass() ?>"><div id="elh_documento_Codigo" class="documento_Codigo"><?= $Page->renderSort($Page->Codigo) ?></div></th>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <th data-name="CodServicio" class="<?= $Page->CodServicio->headerCellClass() ?>"><div id="elh_documento_CodServicio" class="documento_CodServicio"><?= $Page->renderSort($Page->CodServicio) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_documento", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
        <td data-name="CodDocumento" <?= $Page->CodDocumento->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_CodDocumento">
<span<?= $Page->CodDocumento->viewAttributes() ?>>
<?= $Page->CodDocumento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gestion->Visible) { // Gestion ?>
        <td data-name="Gestion" <?= $Page->Gestion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_Gestion">
<span<?= $Page->Gestion->viewAttributes() ?>>
<?= $Page->Gestion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Codigo->Visible) { // Codigo ?>
        <td data-name="Codigo" <?= $Page->Codigo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_Codigo">
<span<?= $Page->Codigo->viewAttributes() ?>>
<?= $Page->Codigo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CodServicio->Visible) { // CodServicio ?>
        <td data-name="CodServicio" <?= $Page->CodServicio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_documento_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<?= $Page->CodServicio->getViewValue() ?></span>
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
    ew.addEventHandlers("documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>