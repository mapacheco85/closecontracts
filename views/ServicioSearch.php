<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ServicioSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fserviciosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fserviciosearch = currentAdvancedSearchForm = new ew.Form("fserviciosearch", "search");
    <?php } else { ?>
    fserviciosearch = currentForm = new ew.Form("fserviciosearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "servicio")) ?>,
        fields = currentTable.fields;
    fserviciosearch.addFields([
        ["CodServicio", [ew.Validators.integer], fields.CodServicio.isInvalid],
        ["Sigla", [], fields.Sigla.isInvalid],
        ["Nombre", [], fields.Nombre.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fserviciosearch.setInvalid();
    });

    // Validate form
    fserviciosearch.validate = function () {
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
    fserviciosearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fserviciosearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fserviciosearch");
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
<form name="fserviciosearch" id="fserviciosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="servicio">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <div id="r_CodServicio" class="form-group row">
        <label for="x_CodServicio" class="<?= $Page->LeftColumnClass ?>"><span id="elh_servicio_CodServicio"><?= $Page->CodServicio->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodServicio" id="z_CodServicio" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodServicio->cellAttributes() ?>>
            <span id="el_servicio_CodServicio" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CodServicio->getInputTextType() ?>" data-table="servicio" data-field="x_CodServicio" name="x_CodServicio" id="x_CodServicio" size="30" placeholder="<?= HtmlEncode($Page->CodServicio->getPlaceHolder()) ?>" value="<?= $Page->CodServicio->EditValue ?>"<?= $Page->CodServicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CodServicio->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
    <div id="r_Sigla" class="form-group row">
        <label for="x_Sigla" class="<?= $Page->LeftColumnClass ?>"><span id="elh_servicio_Sigla"><?= $Page->Sigla->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Sigla" id="z_Sigla" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Sigla->cellAttributes() ?>>
            <span id="el_servicio_Sigla" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Sigla->getInputTextType() ?>" data-table="servicio" data-field="x_Sigla" name="x_Sigla" id="x_Sigla" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Sigla->getPlaceHolder()) ?>" value="<?= $Page->Sigla->EditValue ?>"<?= $Page->Sigla->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Sigla->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
    <div id="r_Nombre" class="form-group row">
        <label for="x_Nombre" class="<?= $Page->LeftColumnClass ?>"><span id="elh_servicio_Nombre"><?= $Page->Nombre->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Nombre" id="z_Nombre" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Nombre->cellAttributes() ?>>
            <span id="el_servicio_Nombre" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Nombre->getInputTextType() ?>" data-table="servicio" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Nombre->getPlaceHolder()) ?>" value="<?= $Page->Nombre->EditValue ?>"<?= $Page->Nombre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nombre->getErrorMessage(false) ?></div>
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
    ew.addEventHandlers("servicio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
