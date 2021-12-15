<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$DocumentoEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdocumentoedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fdocumentoedit = currentForm = new ew.Form("fdocumentoedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "documento")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.documento)
        ew.vars.tables.documento = currentTable;
    fdocumentoedit.addFields([
        ["CodDocumento", [fields.CodDocumento.visible && fields.CodDocumento.required ? ew.Validators.required(fields.CodDocumento.caption) : null], fields.CodDocumento.isInvalid],
        ["Gestion", [fields.Gestion.visible && fields.Gestion.required ? ew.Validators.required(fields.Gestion.caption) : null, ew.Validators.integer], fields.Gestion.isInvalid],
        ["Codigo", [fields.Codigo.visible && fields.Codigo.required ? ew.Validators.required(fields.Codigo.caption) : null, ew.Validators.integer], fields.Codigo.isInvalid],
        ["CodServicio", [fields.CodServicio.visible && fields.CodServicio.required ? ew.Validators.required(fields.CodServicio.caption) : null], fields.CodServicio.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fdocumentoedit,
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
    fdocumentoedit.validate = function () {
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
    fdocumentoedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdocumentoedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fdocumentoedit.lists.CodServicio = <?= $Page->CodServicio->toClientList($Page) ?>;
    loadjs.done("fdocumentoedit");
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
<form name="fdocumentoedit" id="fdocumentoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CodDocumento->Visible) { // CodDocumento ?>
    <div id="r_CodDocumento" class="form-group row">
        <label id="elh_documento_CodDocumento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodDocumento->caption() ?><?= $Page->CodDocumento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodDocumento->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_documento_CodDocumento">
<span<?= $Page->CodDocumento->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodDocumento->getDisplayValue($Page->CodDocumento->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="documento" data-field="x_CodDocumento" data-hidden="1" name="x_CodDocumento" id="x_CodDocumento" value="<?= HtmlEncode($Page->CodDocumento->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documento_CodDocumento">
<span<?= $Page->CodDocumento->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodDocumento->getDisplayValue($Page->CodDocumento->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="documento" data-field="x_CodDocumento" data-hidden="1" name="x_CodDocumento" id="x_CodDocumento" value="<?= HtmlEncode($Page->CodDocumento->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Gestion->Visible) { // Gestion ?>
    <div id="r_Gestion" class="form-group row">
        <label id="elh_documento_Gestion" for="x_Gestion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Gestion->caption() ?><?= $Page->Gestion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Gestion->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_documento_Gestion">
<input type="<?= $Page->Gestion->getInputTextType() ?>" data-table="documento" data-field="x_Gestion" name="x_Gestion" id="x_Gestion" size="30" placeholder="<?= HtmlEncode($Page->Gestion->getPlaceHolder()) ?>" value="<?= $Page->Gestion->EditValue ?>"<?= $Page->Gestion->editAttributes() ?> aria-describedby="x_Gestion_help">
<?= $Page->Gestion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Gestion->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_documento_Gestion">
<span<?= $Page->Gestion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Gestion->getDisplayValue($Page->Gestion->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="documento" data-field="x_Gestion" data-hidden="1" name="x_Gestion" id="x_Gestion" value="<?= HtmlEncode($Page->Gestion->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Codigo->Visible) { // Codigo ?>
    <div id="r_Codigo" class="form-group row">
        <label id="elh_documento_Codigo" for="x_Codigo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Codigo->caption() ?><?= $Page->Codigo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Codigo->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_documento_Codigo">
<input type="<?= $Page->Codigo->getInputTextType() ?>" data-table="documento" data-field="x_Codigo" name="x_Codigo" id="x_Codigo" size="30" placeholder="<?= HtmlEncode($Page->Codigo->getPlaceHolder()) ?>" value="<?= $Page->Codigo->EditValue ?>"<?= $Page->Codigo->editAttributes() ?> aria-describedby="x_Codigo_help">
<?= $Page->Codigo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Codigo->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_documento_Codigo">
<span<?= $Page->Codigo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Codigo->getDisplayValue($Page->Codigo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="documento" data-field="x_Codigo" data-hidden="1" name="x_Codigo" id="x_Codigo" value="<?= HtmlEncode($Page->Codigo->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CodServicio->Visible) { // CodServicio ?>
    <div id="r_CodServicio" class="form-group row">
        <label id="elh_documento_CodServicio" for="x_CodServicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodServicio->caption() ?><?= $Page->CodServicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodServicio->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_documento_CodServicio">
<div class="input-group ew-lookup-list" aria-describedby="x_CodServicio_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CodServicio"><?= EmptyValue(strval($Page->CodServicio->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CodServicio->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CodServicio->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CodServicio->ReadOnly || $Page->CodServicio->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CodServicio',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CodServicio->getErrorMessage() ?></div>
<?= $Page->CodServicio->getCustomMessage() ?>
<?= $Page->CodServicio->Lookup->getParamTag($Page, "p_x_CodServicio") ?>
<input type="hidden" is="selection-list" data-table="documento" data-field="x_CodServicio" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CodServicio->displayValueSeparatorAttribute() ?>" name="x_CodServicio" id="x_CodServicio" value="<?= $Page->CodServicio->CurrentValue ?>"<?= $Page->CodServicio->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_documento_CodServicio">
<span<?= $Page->CodServicio->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodServicio->getDisplayValue($Page->CodServicio->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="documento" data-field="x_CodServicio" data-hidden="1" name="x_CodServicio" id="x_CodServicio" value="<?= HtmlEncode($Page->CodServicio->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
