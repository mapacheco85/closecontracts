<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$RegionSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregionsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fregionsearch = currentAdvancedSearchForm = new ew.Form("fregionsearch", "search");
    <?php } else { ?>
    fregionsearch = currentForm = new ew.Form("fregionsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "region")) ?>,
        fields = currentTable.fields;
    fregionsearch.addFields([
        ["CodRegion", [ew.Validators.integer], fields.CodRegion.isInvalid],
        ["Sigla", [], fields.Sigla.isInvalid],
        ["Descripcion", [], fields.Descripcion.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fregionsearch.setInvalid();
    });

    // Validate form
    fregionsearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fregionsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregionsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fregionsearch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregionsearch" id="fregionsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="region">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
    <div id="r_CodRegion" class="form-group row">
        <label for="x_CodRegion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_region_CodRegion"><?= $Page->CodRegion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodRegion" id="z_CodRegion" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodRegion->cellAttributes() ?>>
            <span id="el_region_CodRegion" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CodRegion->getInputTextType() ?>" data-table="region" data-field="x_CodRegion" data-page="1" name="x_CodRegion" id="x_CodRegion" size="30" placeholder="<?= HtmlEncode($Page->CodRegion->getPlaceHolder()) ?>" value="<?= $Page->CodRegion->EditValue ?>"<?= $Page->CodRegion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CodRegion->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
    <div id="r_Sigla" class="form-group row">
        <label for="x_Sigla" class="<?= $Page->LeftColumnClass ?>"><span id="elh_region_Sigla"><?= $Page->Sigla->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Sigla" id="z_Sigla" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Sigla->cellAttributes() ?>>
            <span id="el_region_Sigla" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Sigla->getInputTextType() ?>" data-table="region" data-field="x_Sigla" data-page="1" name="x_Sigla" id="x_Sigla" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Sigla->getPlaceHolder()) ?>" value="<?= $Page->Sigla->EditValue ?>"<?= $Page->Sigla->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Sigla->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Descripcion->Visible) { // Descripcion ?>
    <div id="r_Descripcion" class="form-group row">
        <label for="x_Descripcion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_region_Descripcion"><?= $Page->Descripcion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Descripcion" id="z_Descripcion" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Descripcion->cellAttributes() ?>>
            <span id="el_region_Descripcion" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Descripcion->getInputTextType() ?>" data-table="region" data-field="x_Descripcion" data-page="1" name="x_Descripcion" id="x_Descripcion" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Descripcion->getPlaceHolder()) ?>" value="<?= $Page->Descripcion->EditValue ?>"<?= $Page->Descripcion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Descripcion->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="location.reload();"><?= $Language->phrase("Reset") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("region");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
