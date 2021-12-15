<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$DocumentoSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdocumentosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fdocumentosearch = currentAdvancedSearchForm = new ew.Form("fdocumentosearch", "search");
    <?php } else { ?>
    fdocumentosearch = currentForm = new ew.Form("fdocumentosearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "documento")) ?>,
        fields = currentTable.fields;
    fdocumentosearch.addFields([
        ["CodDocumento", [ew.Validators.integer], fields.CodDocumento.isInvalid],
        ["Gestion", [ew.Validators.integer], fields.Gestion.isInvalid],
        ["Codigo", [ew.Validators.integer], fields.Codigo.isInvalid],
        ["CodServicio", [], fields.CodServicio.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fdocumentosearch.setInvalid();
    });

    // Validate form
    fdocumentosearch.validate = function () {
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
    fdocumentosearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdocumentosearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fdocumentosearch.lists.CodServicio = <?= $Page->CodServicio->toClientList($Page) ?>;
    loadjs.done("fdocumentosearch");
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
<form name="fdocumentosearch" id="fdocumentosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
    <div id="r_CodDocumento" class="form-group row">
        <label for="x_CodDocumento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_CodDocumento"><?= $Page->CodDocumento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodDocumento" id="z_CodDocumento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodDocumento->cellAttributes() ?>>
            <span id="el_documento_CodDocumento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CodDocumento->getInputTextType() ?>" data-table="documento" data-field="x_CodDocumento" name="x_CodDocumento" id="x_CodDocumento" size="30" placeholder="<?= HtmlEncode($Page->CodDocumento->getPlaceHolder()) ?>" value="<?= $Page->CodDocumento->EditValue ?>"<?= $Page->CodDocumento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CodDocumento->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Gestion->Visible) { // Gestion ?>
    <div id="r_Gestion" class="form-group row">
        <label for="x_Gestion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_Gestion"><?= $Page->Gestion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Gestion" id="z_Gestion" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Gestion->cellAttributes() ?>>
            <span id="el_documento_Gestion" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Gestion->getInputTextType() ?>" data-table="documento" data-field="x_Gestion" name="x_Gestion" id="x_Gestion" size="30" placeholder="<?= HtmlEncode($Page->Gestion->getPlaceHolder()) ?>" value="<?= $Page->Gestion->EditValue ?>"<?= $Page->Gestion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Gestion->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Codigo->Visible) { // Codigo ?>
    <div id="r_Codigo" class="form-group row">
        <label for="x_Codigo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_Codigo"><?= $Page->Codigo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Codigo" id="z_Codigo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Codigo->cellAttributes() ?>>
            <span id="el_documento_Codigo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Codigo->getInputTextType() ?>" data-table="documento" data-field="x_Codigo" name="x_Codigo" id="x_Codigo" size="30" placeholder="<?= HtmlEncode($Page->Codigo->getPlaceHolder()) ?>" value="<?= $Page->Codigo->EditValue ?>"<?= $Page->Codigo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Codigo->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <div id="r_CodServicio" class="form-group row">
        <label for="x_CodServicio" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_CodServicio"><?= $Page->CodServicio->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodServicio" id="z_CodServicio" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodServicio->cellAttributes() ?>>
            <span id="el_documento_CodServicio" class="ew-search-field ew-search-field-single">
    <select
        id="x_CodServicio"
        name="x_CodServicio"
        class="form-control ew-select<?= $Page->CodServicio->isInvalidClass() ?>"
        data-select2-id="documento_x_CodServicio"
        data-table="documento"
        data-field="x_CodServicio"
        data-value-separator="<?= $Page->CodServicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CodServicio->getPlaceHolder()) ?>"
        <?= $Page->CodServicio->editAttributes() ?>>
        <?= $Page->CodServicio->selectOptionListHtml("x_CodServicio") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CodServicio->getErrorMessage(false) ?></div>
<?= $Page->CodServicio->Lookup->getParamTag($Page, "p_x_CodServicio") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='documento_x_CodServicio']"),
        options = { name: "x_CodServicio", selectId: "documento_x_CodServicio", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.documento.fields.CodServicio.selectOptions);
    ew.createSelect(options);
});
</script>
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
    ew.addEventHandlers("documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
