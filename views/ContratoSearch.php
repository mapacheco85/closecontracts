<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ContratoSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcontratosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fcontratosearch = currentAdvancedSearchForm = new ew.Form("fcontratosearch", "search");
    <?php } else { ?>
    fcontratosearch = currentForm = new ew.Form("fcontratosearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "contrato")) ?>,
        fields = currentTable.fields;
    fcontratosearch.addFields([
        ["CodContrato", [ew.Validators.integer], fields.CodContrato.isInvalid],
        ["Fecha", [ew.Validators.datetime(0)], fields.Fecha.isInvalid],
        ["Lugar", [], fields.Lugar.isInvalid],
        ["Vencimiento", [ew.Validators.datetime(0)], fields.Vencimiento.isInvalid],
        ["CodigoInterno", [], fields.CodigoInterno.isInvalid],
        ["MotivoBaja", [], fields.MotivoBaja.isInvalid],
        ["Vigente", [], fields.Vigente.isInvalid],
        ["CodServicio", [], fields.CodServicio.isInvalid],
        ["CodProveedor", [], fields.CodProveedor.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fcontratosearch.setInvalid();
    });

    // Validate form
    fcontratosearch.validate = function () {
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
    fcontratosearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcontratosearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fcontratosearch.lists.MotivoBaja = <?= $Page->MotivoBaja->toClientList($Page) ?>;
    fcontratosearch.lists.Vigente = <?= $Page->Vigente->toClientList($Page) ?>;
    fcontratosearch.lists.CodServicio = <?= $Page->CodServicio->toClientList($Page) ?>;
    fcontratosearch.lists.CodProveedor = <?= $Page->CodProveedor->toClientList($Page) ?>;
    loadjs.done("fcontratosearch");
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
<form name="fcontratosearch" id="fcontratosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->CodContrato->Visible) { // CodContrato ?>
    <div id="r_CodContrato" class="form-group row">
        <label for="x_CodContrato" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_CodContrato"><?= $Page->CodContrato->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodContrato" id="z_CodContrato" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodContrato->cellAttributes() ?>>
            <span id="el_contrato_CodContrato" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CodContrato->getInputTextType() ?>" data-table="contrato" data-field="x_CodContrato" name="x_CodContrato" id="x_CodContrato" size="30" placeholder="<?= HtmlEncode($Page->CodContrato->getPlaceHolder()) ?>" value="<?= $Page->CodContrato->EditValue ?>"<?= $Page->CodContrato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CodContrato->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
    <div id="r_Fecha" class="form-group row">
        <label for="x_Fecha" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_Fecha"><?= $Page->Fecha->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Fecha" id="z_Fecha" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Fecha->cellAttributes() ?>>
            <span id="el_contrato_Fecha" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Fecha->getInputTextType() ?>" data-table="contrato" data-field="x_Fecha" name="x_Fecha" id="x_Fecha" placeholder="<?= HtmlEncode($Page->Fecha->getPlaceHolder()) ?>" value="<?= $Page->Fecha->EditValue ?>"<?= $Page->Fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Fecha->getErrorMessage(false) ?></div>
<?php if (!$Page->Fecha->ReadOnly && !$Page->Fecha->Disabled && !isset($Page->Fecha->EditAttrs["readonly"]) && !isset($Page->Fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontratosearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontratosearch", "x_Fecha", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
    <div id="r_Lugar" class="form-group row">
        <label for="x_Lugar" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_Lugar"><?= $Page->Lugar->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Lugar" id="z_Lugar" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Lugar->cellAttributes() ?>>
            <span id="el_contrato_Lugar" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Lugar->getInputTextType() ?>" data-table="contrato" data-field="x_Lugar" name="x_Lugar" id="x_Lugar" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Lugar->getPlaceHolder()) ?>" value="<?= $Page->Lugar->EditValue ?>"<?= $Page->Lugar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Lugar->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
    <div id="r_Vencimiento" class="form-group row">
        <label for="x_Vencimiento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_Vencimiento"><?= $Page->Vencimiento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Vencimiento" id="z_Vencimiento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Vencimiento->cellAttributes() ?>>
            <span id="el_contrato_Vencimiento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Vencimiento->getInputTextType() ?>" data-table="contrato" data-field="x_Vencimiento" name="x_Vencimiento" id="x_Vencimiento" placeholder="<?= HtmlEncode($Page->Vencimiento->getPlaceHolder()) ?>" value="<?= $Page->Vencimiento->EditValue ?>"<?= $Page->Vencimiento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Vencimiento->getErrorMessage(false) ?></div>
<?php if (!$Page->Vencimiento->ReadOnly && !$Page->Vencimiento->Disabled && !isset($Page->Vencimiento->EditAttrs["readonly"]) && !isset($Page->Vencimiento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontratosearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontratosearch", "x_Vencimiento", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CodigoInterno->Visible) { // CodigoInterno ?>
    <div id="r_CodigoInterno" class="form-group row">
        <label for="x_CodigoInterno" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_CodigoInterno"><?= $Page->CodigoInterno->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CodigoInterno" id="z_CodigoInterno" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodigoInterno->cellAttributes() ?>>
            <span id="el_contrato_CodigoInterno" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->CodigoInterno->getInputTextType() ?>" data-table="contrato" data-field="x_CodigoInterno" name="x_CodigoInterno" id="x_CodigoInterno" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->CodigoInterno->getPlaceHolder()) ?>" value="<?= $Page->CodigoInterno->EditValue ?>"<?= $Page->CodigoInterno->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CodigoInterno->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
    <div id="r_MotivoBaja" class="form-group row">
        <label for="x_MotivoBaja" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_MotivoBaja"><?= $Page->MotivoBaja->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_MotivoBaja" id="z_MotivoBaja" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MotivoBaja->cellAttributes() ?>>
            <span id="el_contrato_MotivoBaja" class="ew-search-field ew-search-field-single">
    <select
        id="x_MotivoBaja"
        name="x_MotivoBaja"
        class="form-control ew-select<?= $Page->MotivoBaja->isInvalidClass() ?>"
        data-select2-id="contrato_x_MotivoBaja"
        data-table="contrato"
        data-field="x_MotivoBaja"
        data-value-separator="<?= $Page->MotivoBaja->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->MotivoBaja->getPlaceHolder()) ?>"
        <?= $Page->MotivoBaja->editAttributes() ?>>
        <?= $Page->MotivoBaja->selectOptionListHtml("x_MotivoBaja") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->MotivoBaja->getErrorMessage(false) ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='contrato_x_MotivoBaja']"),
        options = { name: "x_MotivoBaja", selectId: "contrato_x_MotivoBaja", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.contrato.fields.MotivoBaja.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.contrato.fields.MotivoBaja.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
    <div id="r_Vigente" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_Vigente"><?= $Page->Vigente->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Vigente" id="z_Vigente" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Vigente->cellAttributes() ?>>
            <span id="el_contrato_Vigente" class="ew-search-field ew-search-field-single">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->Vigente->isInvalidClass() ?>" data-table="contrato" data-field="x_Vigente" name="x_Vigente[]" id="x_Vigente_241176" value="1"<?= ConvertToBool($Page->Vigente->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->Vigente->editAttributes() ?>>
    <label class="custom-control-label" for="x_Vigente_241176"></label>
</div>
<div class="invalid-feedback"><?= $Page->Vigente->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <div id="r_CodServicio" class="form-group row">
        <label for="x_CodServicio" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_CodServicio"><?= $Page->CodServicio->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodServicio" id="z_CodServicio" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodServicio->cellAttributes() ?>>
            <span id="el_contrato_CodServicio" class="ew-search-field ew-search-field-single">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CodServicio"><?= EmptyValue(strval($Page->CodServicio->AdvancedSearch->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CodServicio->AdvancedSearch->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CodServicio->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CodServicio->ReadOnly || $Page->CodServicio->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CodServicio',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CodServicio->getErrorMessage(false) ?></div>
<?= $Page->CodServicio->Lookup->getParamTag($Page, "p_x_CodServicio") ?>
<input type="hidden" is="selection-list" data-table="contrato" data-field="x_CodServicio" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CodServicio->displayValueSeparatorAttribute() ?>" name="x_CodServicio" id="x_CodServicio" value="<?= $Page->CodServicio->AdvancedSearch->SearchValue ?>"<?= $Page->CodServicio->editAttributes() ?>>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
    <div id="r_CodProveedor" class="form-group row">
        <label for="x_CodProveedor" class="<?= $Page->LeftColumnClass ?>"><span id="elh_contrato_CodProveedor"><?= $Page->CodProveedor->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_CodProveedor" id="z_CodProveedor" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodProveedor->cellAttributes() ?>>
            <span id="el_contrato_CodProveedor" class="ew-search-field ew-search-field-single">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CodProveedor"><?= EmptyValue(strval($Page->CodProveedor->AdvancedSearch->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CodProveedor->AdvancedSearch->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CodProveedor->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CodProveedor->ReadOnly || $Page->CodProveedor->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CodProveedor',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CodProveedor->getErrorMessage(false) ?></div>
<?= $Page->CodProveedor->Lookup->getParamTag($Page, "p_x_CodProveedor") ?>
<input type="hidden" is="selection-list" data-table="contrato" data-field="x_CodProveedor" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CodProveedor->displayValueSeparatorAttribute() ?>" name="x_CodProveedor" id="x_CodProveedor" value="<?= $Page->CodProveedor->AdvancedSearch->SearchValue ?>"<?= $Page->CodProveedor->editAttributes() ?>>
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
    ew.addEventHandlers("contrato");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
