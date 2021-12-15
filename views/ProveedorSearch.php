<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ProveedorSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fproveedorsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fproveedorsearch = currentAdvancedSearchForm = new ew.Form("fproveedorsearch", "search");
    <?php } else { ?>
    fproveedorsearch = currentForm = new ew.Form("fproveedorsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "proveedor")) ?>,
        fields = currentTable.fields;
    fproveedorsearch.addFields([
        ["CodProveedor", [ew.Validators.integer], fields.CodProveedor.isInvalid],
        ["RazonSocial", [], fields.RazonSocial.isInvalid],
        ["Propietario", [], fields.Propietario.isInvalid],
        ["NIT", [], fields.NIT.isInvalid],
        ["Cedula", [], fields.Cedula.isInvalid],
        ["Telefono", [], fields.Telefono.isInvalid],
        ["Direccion", [], fields.Direccion.isInvalid],
        ["CodRegion", [], fields.CodRegion.isInvalid],
        ["Vigente", [], fields.Vigente.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fproveedorsearch.setInvalid();
    });

    // Validate form
    fproveedorsearch.validate = function () {
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
    fproveedorsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproveedorsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fproveedorsearch.lists.CodRegion = <?= $Page->CodRegion->toClientList($Page) ?>;
    fproveedorsearch.lists.Vigente = <?= $Page->Vigente->toClientList($Page) ?>;
    loadjs.done("fproveedorsearch");
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
<form name="fproveedorsearch" id="fproveedorsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
    <div id="r_CodProveedor" class="form-group row">
        <label for="x_CodProveedor" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_CodProveedor"><?= $Page->CodProveedor->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodProveedor" id="z_CodProveedor" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodProveedor->cellAttributes() ?>>
            <span id="el_proveedor_CodProveedor" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CodProveedor->getInputTextType() ?>" data-table="proveedor" data-field="x_CodProveedor" name="x_CodProveedor" id="x_CodProveedor" size="30" placeholder="<?= HtmlEncode($Page->CodProveedor->getPlaceHolder()) ?>" value="<?= $Page->CodProveedor->EditValue ?>"<?= $Page->CodProveedor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CodProveedor->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
    <div id="r_RazonSocial" class="form-group row">
        <label for="x_RazonSocial" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_RazonSocial"><?= $Page->RazonSocial->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_RazonSocial" id="z_RazonSocial" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RazonSocial->cellAttributes() ?>>
            <span id="el_proveedor_RazonSocial" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->RazonSocial->getInputTextType() ?>" data-table="proveedor" data-field="x_RazonSocial" name="x_RazonSocial" id="x_RazonSocial" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->RazonSocial->getPlaceHolder()) ?>" value="<?= $Page->RazonSocial->EditValue ?>"<?= $Page->RazonSocial->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->RazonSocial->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
    <div id="r_Propietario" class="form-group row">
        <label for="x_Propietario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_Propietario"><?= $Page->Propietario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Propietario" id="z_Propietario" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Propietario->cellAttributes() ?>>
            <span id="el_proveedor_Propietario" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Propietario->getInputTextType() ?>" data-table="proveedor" data-field="x_Propietario" name="x_Propietario" id="x_Propietario" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Propietario->getPlaceHolder()) ?>" value="<?= $Page->Propietario->EditValue ?>"<?= $Page->Propietario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Propietario->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
    <div id="r_NIT" class="form-group row">
        <label for="x_NIT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_NIT"><?= $Page->NIT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_NIT" id="z_NIT" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NIT->cellAttributes() ?>>
            <span id="el_proveedor_NIT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->NIT->getInputTextType() ?>" data-table="proveedor" data-field="x_NIT" name="x_NIT" id="x_NIT" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIT->getPlaceHolder()) ?>" value="<?= $Page->NIT->EditValue ?>"<?= $Page->NIT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIT->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
    <div id="r_Cedula" class="form-group row">
        <label for="x_Cedula" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_Cedula"><?= $Page->Cedula->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Cedula" id="z_Cedula" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Cedula->cellAttributes() ?>>
            <span id="el_proveedor_Cedula" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Cedula->getInputTextType() ?>" data-table="proveedor" data-field="x_Cedula" name="x_Cedula" id="x_Cedula" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Cedula->getPlaceHolder()) ?>" value="<?= $Page->Cedula->EditValue ?>"<?= $Page->Cedula->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Cedula->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Telefono->Visible) { // Telefono ?>
    <div id="r_Telefono" class="form-group row">
        <label for="x_Telefono" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_Telefono"><?= $Page->Telefono->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Telefono" id="z_Telefono" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Telefono->cellAttributes() ?>>
            <span id="el_proveedor_Telefono" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Telefono->getInputTextType() ?>" data-table="proveedor" data-field="x_Telefono" name="x_Telefono" id="x_Telefono" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Telefono->getPlaceHolder()) ?>" value="<?= $Page->Telefono->EditValue ?>"<?= $Page->Telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Telefono->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
    <div id="r_Direccion" class="form-group row">
        <label for="x_Direccion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_Direccion"><?= $Page->Direccion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Direccion" id="z_Direccion" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Direccion->cellAttributes() ?>>
            <span id="el_proveedor_Direccion" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Direccion->getInputTextType() ?>" data-table="proveedor" data-field="x_Direccion" name="x_Direccion" id="x_Direccion" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Direccion->getPlaceHolder()) ?>" value="<?= $Page->Direccion->EditValue ?>"<?= $Page->Direccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Direccion->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
    <div id="r_CodRegion" class="form-group row">
        <label for="x_CodRegion" class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_CodRegion"><?= $Page->CodRegion->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodRegion" id="z_CodRegion" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodRegion->cellAttributes() ?>>
            <span id="el_proveedor_CodRegion" class="ew-search-field ew-search-field-single">
    <select
        id="x_CodRegion"
        name="x_CodRegion"
        class="form-control ew-select<?= $Page->CodRegion->isInvalidClass() ?>"
        data-select2-id="proveedor_x_CodRegion"
        data-table="proveedor"
        data-field="x_CodRegion"
        data-value-separator="<?= $Page->CodRegion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CodRegion->getPlaceHolder()) ?>"
        <?= $Page->CodRegion->editAttributes() ?>>
        <?= $Page->CodRegion->selectOptionListHtml("x_CodRegion") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->CodRegion->getErrorMessage(false) ?></div>
<?= $Page->CodRegion->Lookup->getParamTag($Page, "p_x_CodRegion") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='proveedor_x_CodRegion']"),
        options = { name: "x_CodRegion", selectId: "proveedor_x_CodRegion", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.proveedor.fields.CodRegion.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
    <div id="r_Vigente" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_proveedor_Vigente"><?= $Page->Vigente->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Vigente" id="z_Vigente" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Vigente->cellAttributes() ?>>
            <span id="el_proveedor_Vigente" class="ew-search-field ew-search-field-single">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->Vigente->isInvalidClass() ?>" data-table="proveedor" data-field="x_Vigente" name="x_Vigente[]" id="x_Vigente_265595" value="1"<?= ConvertToBool($Page->Vigente->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->Vigente->editAttributes() ?>>
    <label class="custom-control-label" for="x_Vigente_265595"></label>
</div>
<div class="invalid-feedback"><?= $Page->Vigente->getErrorMessage(false) ?></div>
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
    ew.addEventHandlers("proveedor");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
