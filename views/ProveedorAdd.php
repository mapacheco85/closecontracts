<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ProveedorAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fproveedoradd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fproveedoradd = currentForm = new ew.Form("fproveedoradd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "proveedor")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.proveedor)
        ew.vars.tables.proveedor = currentTable;
    fproveedoradd.addFields([
        ["RazonSocial", [fields.RazonSocial.visible && fields.RazonSocial.required ? ew.Validators.required(fields.RazonSocial.caption) : null], fields.RazonSocial.isInvalid],
        ["Propietario", [fields.Propietario.visible && fields.Propietario.required ? ew.Validators.required(fields.Propietario.caption) : null], fields.Propietario.isInvalid],
        ["NIT", [fields.NIT.visible && fields.NIT.required ? ew.Validators.required(fields.NIT.caption) : null], fields.NIT.isInvalid],
        ["Cedula", [fields.Cedula.visible && fields.Cedula.required ? ew.Validators.required(fields.Cedula.caption) : null], fields.Cedula.isInvalid],
        ["Telefono", [fields.Telefono.visible && fields.Telefono.required ? ew.Validators.required(fields.Telefono.caption) : null], fields.Telefono.isInvalid],
        ["Direccion", [fields.Direccion.visible && fields.Direccion.required ? ew.Validators.required(fields.Direccion.caption) : null], fields.Direccion.isInvalid],
        ["CodRegion", [fields.CodRegion.visible && fields.CodRegion.required ? ew.Validators.required(fields.CodRegion.caption) : null], fields.CodRegion.isInvalid],
        ["Vigente", [fields.Vigente.visible && fields.Vigente.required ? ew.Validators.required(fields.Vigente.caption) : null], fields.Vigente.isInvalid],
        ["MinimoValidado", [fields.MinimoValidado.visible && fields.MinimoValidado.required ? ew.Validators.required(fields.MinimoValidado.caption) : null, ew.Validators.integer], fields.MinimoValidado.isInvalid],
        ["tipo_transferencia", [fields.tipo_transferencia.visible && fields.tipo_transferencia.required ? ew.Validators.required(fields.tipo_transferencia.caption) : null], fields.tipo_transferencia.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fproveedoradd,
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
    fproveedoradd.validate = function () {
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
    fproveedoradd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproveedoradd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fproveedoradd.lists.CodRegion = <?= $Page->CodRegion->toClientList($Page) ?>;
    fproveedoradd.lists.Vigente = <?= $Page->Vigente->toClientList($Page) ?>;
    fproveedoradd.lists.tipo_transferencia = <?= $Page->tipo_transferencia->toClientList($Page) ?>;
    loadjs.done("fproveedoradd");
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
<form name="fproveedoradd" id="fproveedoradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->RazonSocial->Visible) { // RazonSocial ?>
    <div id="r_RazonSocial" class="form-group row">
        <label id="elh_proveedor_RazonSocial" for="x_RazonSocial" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RazonSocial->caption() ?><?= $Page->RazonSocial->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RazonSocial->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_RazonSocial">
<input type="<?= $Page->RazonSocial->getInputTextType() ?>" data-table="proveedor" data-field="x_RazonSocial" name="x_RazonSocial" id="x_RazonSocial" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->RazonSocial->getPlaceHolder()) ?>" value="<?= $Page->RazonSocial->EditValue ?>"<?= $Page->RazonSocial->editAttributes() ?> aria-describedby="x_RazonSocial_help">
<?= $Page->RazonSocial->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RazonSocial->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_RazonSocial">
<span<?= $Page->RazonSocial->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->RazonSocial->getDisplayValue($Page->RazonSocial->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_RazonSocial" data-hidden="1" name="x_RazonSocial" id="x_RazonSocial" value="<?= HtmlEncode($Page->RazonSocial->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Propietario->Visible) { // Propietario ?>
    <div id="r_Propietario" class="form-group row">
        <label id="elh_proveedor_Propietario" for="x_Propietario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Propietario->caption() ?><?= $Page->Propietario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Propietario->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_Propietario">
<input type="<?= $Page->Propietario->getInputTextType() ?>" data-table="proveedor" data-field="x_Propietario" name="x_Propietario" id="x_Propietario" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Propietario->getPlaceHolder()) ?>" value="<?= $Page->Propietario->EditValue ?>"<?= $Page->Propietario->editAttributes() ?> aria-describedby="x_Propietario_help">
<?= $Page->Propietario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Propietario->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_Propietario">
<span<?= $Page->Propietario->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Propietario->getDisplayValue($Page->Propietario->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_Propietario" data-hidden="1" name="x_Propietario" id="x_Propietario" value="<?= HtmlEncode($Page->Propietario->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIT->Visible) { // NIT ?>
    <div id="r_NIT" class="form-group row">
        <label id="elh_proveedor_NIT" for="x_NIT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIT->caption() ?><?= $Page->NIT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NIT->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_NIT">
<input type="<?= $Page->NIT->getInputTextType() ?>" data-table="proveedor" data-field="x_NIT" name="x_NIT" id="x_NIT" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NIT->getPlaceHolder()) ?>" value="<?= $Page->NIT->EditValue ?>"<?= $Page->NIT->editAttributes() ?> aria-describedby="x_NIT_help">
<?= $Page->NIT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_NIT">
<span<?= $Page->NIT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NIT->getDisplayValue($Page->NIT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_NIT" data-hidden="1" name="x_NIT" id="x_NIT" value="<?= HtmlEncode($Page->NIT->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Cedula->Visible) { // Cedula ?>
    <div id="r_Cedula" class="form-group row">
        <label id="elh_proveedor_Cedula" for="x_Cedula" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Cedula->caption() ?><?= $Page->Cedula->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Cedula->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_Cedula">
<input type="<?= $Page->Cedula->getInputTextType() ?>" data-table="proveedor" data-field="x_Cedula" name="x_Cedula" id="x_Cedula" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Cedula->getPlaceHolder()) ?>" value="<?= $Page->Cedula->EditValue ?>"<?= $Page->Cedula->editAttributes() ?> aria-describedby="x_Cedula_help">
<?= $Page->Cedula->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Cedula->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_Cedula">
<span<?= $Page->Cedula->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Cedula->getDisplayValue($Page->Cedula->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_Cedula" data-hidden="1" name="x_Cedula" id="x_Cedula" value="<?= HtmlEncode($Page->Cedula->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Telefono->Visible) { // Telefono ?>
    <div id="r_Telefono" class="form-group row">
        <label id="elh_proveedor_Telefono" for="x_Telefono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Telefono->caption() ?><?= $Page->Telefono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Telefono->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_Telefono">
<input type="<?= $Page->Telefono->getInputTextType() ?>" data-table="proveedor" data-field="x_Telefono" name="x_Telefono" id="x_Telefono" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Telefono->getPlaceHolder()) ?>" value="<?= $Page->Telefono->EditValue ?>"<?= $Page->Telefono->editAttributes() ?> aria-describedby="x_Telefono_help">
<?= $Page->Telefono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Telefono->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_Telefono">
<span<?= $Page->Telefono->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Telefono->getDisplayValue($Page->Telefono->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_Telefono" data-hidden="1" name="x_Telefono" id="x_Telefono" value="<?= HtmlEncode($Page->Telefono->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Direccion->Visible) { // Direccion ?>
    <div id="r_Direccion" class="form-group row">
        <label id="elh_proveedor_Direccion" for="x_Direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Direccion->caption() ?><?= $Page->Direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Direccion->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_Direccion">
<input type="<?= $Page->Direccion->getInputTextType() ?>" data-table="proveedor" data-field="x_Direccion" name="x_Direccion" id="x_Direccion" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Direccion->getPlaceHolder()) ?>" value="<?= $Page->Direccion->EditValue ?>"<?= $Page->Direccion->editAttributes() ?> aria-describedby="x_Direccion_help">
<?= $Page->Direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Direccion->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_Direccion">
<span<?= $Page->Direccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Direccion->getDisplayValue($Page->Direccion->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_Direccion" data-hidden="1" name="x_Direccion" id="x_Direccion" value="<?= HtmlEncode($Page->Direccion->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
    <div id="r_CodRegion" class="form-group row">
        <label id="elh_proveedor_CodRegion" for="x_CodRegion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodRegion->caption() ?><?= $Page->CodRegion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodRegion->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_CodRegion">
<div class="input-group ew-lookup-list" aria-describedby="x_CodRegion_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CodRegion"><?= EmptyValue(strval($Page->CodRegion->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CodRegion->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CodRegion->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CodRegion->ReadOnly || $Page->CodRegion->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CodRegion',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CodRegion->getErrorMessage() ?></div>
<?= $Page->CodRegion->getCustomMessage() ?>
<?= $Page->CodRegion->Lookup->getParamTag($Page, "p_x_CodRegion") ?>
<input type="hidden" is="selection-list" data-table="proveedor" data-field="x_CodRegion" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CodRegion->displayValueSeparatorAttribute() ?>" name="x_CodRegion" id="x_CodRegion" value="<?= $Page->CodRegion->CurrentValue ?>"<?= $Page->CodRegion->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_proveedor_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodRegion->getDisplayValue($Page->CodRegion->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_CodRegion" data-hidden="1" name="x_CodRegion" id="x_CodRegion" value="<?= HtmlEncode($Page->CodRegion->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Vigente->Visible) { // Vigente ?>
    <div id="r_Vigente" class="form-group row">
        <label id="elh_proveedor_Vigente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Vigente->caption() ?><?= $Page->Vigente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Vigente->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_Vigente">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->Vigente->isInvalidClass() ?>" data-table="proveedor" data-field="x_Vigente" name="x_Vigente[]" id="x_Vigente_938936" value="1"<?= ConvertToBool($Page->Vigente->CurrentValue) ? " checked" : "" ?><?= $Page->Vigente->editAttributes() ?> aria-describedby="x_Vigente_help">
    <label class="custom-control-label" for="x_Vigente_938936"></label>
</div>
<?= $Page->Vigente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Vigente->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_Vigente">
<span<?= $Page->Vigente->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_Vigente_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->Vigente->ViewValue ?>" disabled<?php if (ConvertToBool($Page->Vigente->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_Vigente_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_Vigente" data-hidden="1" name="x_Vigente" id="x_Vigente" value="<?= HtmlEncode($Page->Vigente->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MinimoValidado->Visible) { // MinimoValidado ?>
    <div id="r_MinimoValidado" class="form-group row">
        <label id="elh_proveedor_MinimoValidado" for="x_MinimoValidado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MinimoValidado->caption() ?><?= $Page->MinimoValidado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MinimoValidado->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_MinimoValidado">
<input type="<?= $Page->MinimoValidado->getInputTextType() ?>" data-table="proveedor" data-field="x_MinimoValidado" name="x_MinimoValidado" id="x_MinimoValidado" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->MinimoValidado->getPlaceHolder()) ?>" value="<?= $Page->MinimoValidado->EditValue ?>"<?= $Page->MinimoValidado->editAttributes() ?> aria-describedby="x_MinimoValidado_help">
<?= $Page->MinimoValidado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MinimoValidado->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_proveedor_MinimoValidado">
<span<?= $Page->MinimoValidado->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->MinimoValidado->getDisplayValue($Page->MinimoValidado->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_MinimoValidado" data-hidden="1" name="x_MinimoValidado" id="x_MinimoValidado" value="<?= HtmlEncode($Page->MinimoValidado->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_transferencia->Visible) { // tipo_transferencia ?>
    <div id="r_tipo_transferencia" class="form-group row">
        <label id="elh_proveedor_tipo_transferencia" for="x_tipo_transferencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_transferencia->caption() ?><?= $Page->tipo_transferencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_transferencia->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_proveedor_tipo_transferencia">
    <select
        id="x_tipo_transferencia"
        name="x_tipo_transferencia"
        class="form-control ew-select<?= $Page->tipo_transferencia->isInvalidClass() ?>"
        data-select2-id="proveedor_x_tipo_transferencia"
        data-table="proveedor"
        data-field="x_tipo_transferencia"
        data-value-separator="<?= $Page->tipo_transferencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_transferencia->getPlaceHolder()) ?>"
        <?= $Page->tipo_transferencia->editAttributes() ?>>
        <?= $Page->tipo_transferencia->selectOptionListHtml("x_tipo_transferencia") ?>
    </select>
    <?= $Page->tipo_transferencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_transferencia->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='proveedor_x_tipo_transferencia']"),
        options = { name: "x_tipo_transferencia", selectId: "proveedor_x_tipo_transferencia", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.proveedor.fields.tipo_transferencia.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.proveedor.fields.tipo_transferencia.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_proveedor_tipo_transferencia">
<span<?= $Page->tipo_transferencia->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tipo_transferencia->getDisplayValue($Page->tipo_transferencia->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_tipo_transferencia" data-hidden="1" name="x_tipo_transferencia" id="x_tipo_transferencia" value="<?= HtmlEncode($Page->tipo_transferencia->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("proveedor");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
