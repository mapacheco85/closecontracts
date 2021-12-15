<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ContratoEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcontratoedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fcontratoedit = currentForm = new ew.Form("fcontratoedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "contrato")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.contrato)
        ew.vars.tables.contrato = currentTable;
    fcontratoedit.addFields([
        ["CodContrato", [fields.CodContrato.visible && fields.CodContrato.required ? ew.Validators.required(fields.CodContrato.caption) : null], fields.CodContrato.isInvalid],
        ["Fecha", [fields.Fecha.visible && fields.Fecha.required ? ew.Validators.required(fields.Fecha.caption) : null, ew.Validators.datetime(0)], fields.Fecha.isInvalid],
        ["Lugar", [fields.Lugar.visible && fields.Lugar.required ? ew.Validators.required(fields.Lugar.caption) : null], fields.Lugar.isInvalid],
        ["Vencimiento", [fields.Vencimiento.visible && fields.Vencimiento.required ? ew.Validators.required(fields.Vencimiento.caption) : null, ew.Validators.datetime(0)], fields.Vencimiento.isInvalid],
        ["CodigoInterno", [fields.CodigoInterno.visible && fields.CodigoInterno.required ? ew.Validators.required(fields.CodigoInterno.caption) : null], fields.CodigoInterno.isInvalid],
        ["MotivoBaja", [fields.MotivoBaja.visible && fields.MotivoBaja.required ? ew.Validators.required(fields.MotivoBaja.caption) : null], fields.MotivoBaja.isInvalid],
        ["Vigente", [fields.Vigente.visible && fields.Vigente.required ? ew.Validators.required(fields.Vigente.caption) : null], fields.Vigente.isInvalid],
        ["CodServicio", [fields.CodServicio.visible && fields.CodServicio.required ? ew.Validators.required(fields.CodServicio.caption) : null], fields.CodServicio.isInvalid],
        ["CodProveedor", [fields.CodProveedor.visible && fields.CodProveedor.required ? ew.Validators.required(fields.CodProveedor.caption) : null], fields.CodProveedor.isInvalid],
        ["Monto", [fields.Monto.visible && fields.Monto.required ? ew.Validators.required(fields.Monto.caption) : null, ew.Validators.float], fields.Monto.isInvalid],
        ["Archivo", [fields.Archivo.visible && fields.Archivo.required ? ew.Validators.fileRequired(fields.Archivo.caption) : null], fields.Archivo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcontratoedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fcontratoedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fcontratoedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcontratoedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fcontratoedit.lists.MotivoBaja = <?= $Page->MotivoBaja->toClientList($Page) ?>;
    fcontratoedit.lists.Vigente = <?= $Page->Vigente->toClientList($Page) ?>;
    fcontratoedit.lists.CodServicio = <?= $Page->CodServicio->toClientList($Page) ?>;
    fcontratoedit.lists.CodProveedor = <?= $Page->CodProveedor->toClientList($Page) ?>;
    loadjs.done("fcontratoedit");
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
<form name="fcontratoedit" id="fcontratoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contrato">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CodContrato->Visible) { // CodContrato ?>
    <div id="r_CodContrato" class="form-group row">
        <label id="elh_contrato_CodContrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodContrato->caption() ?><?= $Page->CodContrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodContrato->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodContrato->getDisplayValue($Page->CodContrato->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_CodContrato" data-hidden="1" name="x_CodContrato" id="x_CodContrato" value="<?= HtmlEncode($Page->CodContrato->CurrentValue) ?>">
<?php } else { ?>
<span id="el_contrato_CodContrato">
<span<?= $Page->CodContrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodContrato->getDisplayValue($Page->CodContrato->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_CodContrato" data-hidden="1" name="x_CodContrato" id="x_CodContrato" value="<?= HtmlEncode($Page->CodContrato->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Fecha->Visible) { // Fecha ?>
    <div id="r_Fecha" class="form-group row">
        <label id="elh_contrato_Fecha" for="x_Fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Fecha->caption() ?><?= $Page->Fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Fecha->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_Fecha">
<input type="<?= $Page->Fecha->getInputTextType() ?>" data-table="contrato" data-field="x_Fecha" name="x_Fecha" id="x_Fecha" placeholder="<?= HtmlEncode($Page->Fecha->getPlaceHolder()) ?>" value="<?= $Page->Fecha->EditValue ?>"<?= $Page->Fecha->editAttributes() ?> aria-describedby="x_Fecha_help">
<?= $Page->Fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Fecha->getErrorMessage() ?></div>
<?php if (!$Page->Fecha->ReadOnly && !$Page->Fecha->Disabled && !isset($Page->Fecha->EditAttrs["readonly"]) && !isset($Page->Fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontratoedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontratoedit", "x_Fecha", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_contrato_Fecha">
<span<?= $Page->Fecha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Fecha->getDisplayValue($Page->Fecha->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_Fecha" data-hidden="1" name="x_Fecha" id="x_Fecha" value="<?= HtmlEncode($Page->Fecha->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Lugar->Visible) { // Lugar ?>
    <div id="r_Lugar" class="form-group row">
        <label id="elh_contrato_Lugar" for="x_Lugar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Lugar->caption() ?><?= $Page->Lugar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Lugar->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_Lugar">
<input type="<?= $Page->Lugar->getInputTextType() ?>" data-table="contrato" data-field="x_Lugar" name="x_Lugar" id="x_Lugar" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Lugar->getPlaceHolder()) ?>" value="<?= $Page->Lugar->EditValue ?>"<?= $Page->Lugar->editAttributes() ?> aria-describedby="x_Lugar_help">
<?= $Page->Lugar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Lugar->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_contrato_Lugar">
<span<?= $Page->Lugar->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Lugar->getDisplayValue($Page->Lugar->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_Lugar" data-hidden="1" name="x_Lugar" id="x_Lugar" value="<?= HtmlEncode($Page->Lugar->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Vencimiento->Visible) { // Vencimiento ?>
    <div id="r_Vencimiento" class="form-group row">
        <label id="elh_contrato_Vencimiento" for="x_Vencimiento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Vencimiento->caption() ?><?= $Page->Vencimiento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Vencimiento->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_Vencimiento">
<input type="<?= $Page->Vencimiento->getInputTextType() ?>" data-table="contrato" data-field="x_Vencimiento" name="x_Vencimiento" id="x_Vencimiento" placeholder="<?= HtmlEncode($Page->Vencimiento->getPlaceHolder()) ?>" value="<?= $Page->Vencimiento->EditValue ?>"<?= $Page->Vencimiento->editAttributes() ?> aria-describedby="x_Vencimiento_help">
<?= $Page->Vencimiento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Vencimiento->getErrorMessage() ?></div>
<?php if (!$Page->Vencimiento->ReadOnly && !$Page->Vencimiento->Disabled && !isset($Page->Vencimiento->EditAttrs["readonly"]) && !isset($Page->Vencimiento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontratoedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fcontratoedit", "x_Vencimiento", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_contrato_Vencimiento">
<span<?= $Page->Vencimiento->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Vencimiento->getDisplayValue($Page->Vencimiento->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_Vencimiento" data-hidden="1" name="x_Vencimiento" id="x_Vencimiento" value="<?= HtmlEncode($Page->Vencimiento->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MotivoBaja->Visible) { // MotivoBaja ?>
    <div id="r_MotivoBaja" class="form-group row">
        <label id="elh_contrato_MotivoBaja" for="x_MotivoBaja" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MotivoBaja->caption() ?><?= $Page->MotivoBaja->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MotivoBaja->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_MotivoBaja">
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
    <?= $Page->MotivoBaja->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->MotivoBaja->getErrorMessage() ?></div>
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
<?php } else { ?>
<span id="el_contrato_MotivoBaja">
<span<?= $Page->MotivoBaja->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->MotivoBaja->getDisplayValue($Page->MotivoBaja->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_MotivoBaja" data-hidden="1" name="x_MotivoBaja" id="x_MotivoBaja" value="<?= HtmlEncode($Page->MotivoBaja->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
    <div id="r_Vigente" class="form-group row">
        <label id="elh_contrato_Vigente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Vigente->caption() ?><?= $Page->Vigente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Vigente->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_Vigente">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->Vigente->isInvalidClass() ?>" data-table="contrato" data-field="x_Vigente" name="x_Vigente[]" id="x_Vigente_658961" value="1"<?= ConvertToBool($Page->Vigente->CurrentValue) ? " checked" : "" ?><?= $Page->Vigente->editAttributes() ?> aria-describedby="x_Vigente_help">
    <label class="custom-control-label" for="x_Vigente_658961"></label>
</div>
<?= $Page->Vigente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Vigente->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_contrato_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->ViewValue ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_Vigente" data-hidden="1" name="x_Vigente" id="x_Vigente" value="<?= HtmlEncode($Page->Vigente->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <div id="r_CodServicio" class="form-group row">
        <label id="elh_contrato_CodServicio" for="x_CodServicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodServicio->caption() ?><?= $Page->CodServicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodServicio->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_CodServicio">
<div class="input-group ew-lookup-list" aria-describedby="x_CodServicio_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CodServicio"><?= EmptyValue(strval($Page->CodServicio->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CodServicio->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CodServicio->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CodServicio->ReadOnly || $Page->CodServicio->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CodServicio',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CodServicio->getErrorMessage() ?></div>
<?= $Page->CodServicio->getCustomMessage() ?>
<?= $Page->CodServicio->Lookup->getParamTag($Page, "p_x_CodServicio") ?>
<input type="hidden" is="selection-list" data-table="contrato" data-field="x_CodServicio" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CodServicio->displayValueSeparatorAttribute() ?>" name="x_CodServicio" id="x_CodServicio" value="<?= $Page->CodServicio->CurrentValue ?>"<?= $Page->CodServicio->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_contrato_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodServicio->getDisplayValue($Page->CodServicio->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_CodServicio" data-hidden="1" name="x_CodServicio" id="x_CodServicio" value="<?= HtmlEncode($Page->CodServicio->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CodProveedor->Visible) { // CodProveedor ?>
    <div id="r_CodProveedor" class="form-group row">
        <label id="elh_contrato_CodProveedor" for="x_CodProveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodProveedor->caption() ?><?= $Page->CodProveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodProveedor->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_CodProveedor">
<div class="input-group ew-lookup-list" aria-describedby="x_CodProveedor_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CodProveedor"><?= EmptyValue(strval($Page->CodProveedor->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CodProveedor->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CodProveedor->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CodProveedor->ReadOnly || $Page->CodProveedor->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CodProveedor',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CodProveedor->getErrorMessage() ?></div>
<?= $Page->CodProveedor->getCustomMessage() ?>
<?= $Page->CodProveedor->Lookup->getParamTag($Page, "p_x_CodProveedor") ?>
<input type="hidden" is="selection-list" data-table="contrato" data-field="x_CodProveedor" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CodProveedor->displayValueSeparatorAttribute() ?>" name="x_CodProveedor" id="x_CodProveedor" value="<?= $Page->CodProveedor->CurrentValue ?>"<?= $Page->CodProveedor->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_contrato_CodProveedor">
<span<?= $Page->CodProveedor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodProveedor->getDisplayValue($Page->CodProveedor->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_CodProveedor" data-hidden="1" name="x_CodProveedor" id="x_CodProveedor" value="<?= HtmlEncode($Page->CodProveedor->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Monto->Visible) { // Monto ?>
    <div id="r_Monto" class="form-group row">
        <label id="elh_contrato_Monto" for="x_Monto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Monto->caption() ?><?= $Page->Monto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Monto->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_Monto">
<input type="<?= $Page->Monto->getInputTextType() ?>" data-table="contrato" data-field="x_Monto" name="x_Monto" id="x_Monto" size="30" maxlength="7" placeholder="<?= HtmlEncode($Page->Monto->getPlaceHolder()) ?>" value="<?= $Page->Monto->EditValue ?>"<?= $Page->Monto->editAttributes() ?> aria-describedby="x_Monto_help">
<?= $Page->Monto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Monto->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_contrato_Monto">
<span<?= $Page->Monto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Monto->getDisplayValue($Page->Monto->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="contrato" data-field="x_Monto" data-hidden="1" name="x_Monto" id="x_Monto" value="<?= HtmlEncode($Page->Monto->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Archivo->Visible) { // Archivo ?>
    <div id="r_Archivo" class="form-group row">
        <label id="elh_contrato_Archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Archivo->caption() ?><?= $Page->Archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Archivo->cellAttributes() ?>>
<span id="el_contrato_Archivo">
<div id="fd_x_Archivo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->Archivo->title() ?>" data-table="contrato" data-field="x_Archivo" name="x_Archivo" id="x_Archivo" lang="<?= CurrentLanguageID() ?>"<?= $Page->Archivo->editAttributes() ?><?= ($Page->Archivo->ReadOnly || $Page->Archivo->Disabled) ? " disabled" : "" ?> aria-describedby="x_Archivo_help">
        <label class="custom-file-label ew-file-label" for="x_Archivo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->Archivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Archivo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Archivo" id= "fn_x_Archivo" value="<?= $Page->Archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x_Archivo" id= "fa_x_Archivo" value="<?= (Post("fa_x_Archivo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Archivo" id= "fs_x_Archivo" value="0">
<input type="hidden" name="fx_x_Archivo" id= "fx_x_Archivo" value="<?= $Page->Archivo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Archivo" id= "fm_x_Archivo" value="<?= $Page->Archivo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Archivo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->isConfirm()) { ?>
<span id="el_contrato_CodigoInterno">
<input type="hidden" data-table="contrato" data-field="x_CodigoInterno" data-hidden="1" name="x_CodigoInterno" id="x_CodigoInterno" value="<?= HtmlEncode($Page->CodigoInterno->CurrentValue) ?>">
</span>
<?php } else { ?>
<input type="hidden" data-table="contrato" data-field="x_CodigoInterno" data-hidden="1" name="x_CodigoInterno" id="x_CodigoInterno" value="<?= HtmlEncode($Page->CodigoInterno->FormValue) ?>">
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
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
