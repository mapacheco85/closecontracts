<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ServicioAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fservicioadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fservicioadd = currentForm = new ew.Form("fservicioadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "servicio")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.servicio)
        ew.vars.tables.servicio = currentTable;
    fservicioadd.addFields([
        ["Sigla", [fields.Sigla.visible && fields.Sigla.required ? ew.Validators.required(fields.Sigla.caption) : null], fields.Sigla.isInvalid],
        ["Nombre", [fields.Nombre.visible && fields.Nombre.required ? ew.Validators.required(fields.Nombre.caption) : null], fields.Nombre.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fservicioadd,
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
    fservicioadd.validate = function () {
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
    fservicioadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fservicioadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fservicioadd");
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
<form name="fservicioadd" id="fservicioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="servicio">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->Sigla->Visible) { // Sigla ?>
    <div id="r_Sigla" class="form-group row">
        <label id="elh_servicio_Sigla" for="x_Sigla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sigla->caption() ?><?= $Page->Sigla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Sigla->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_servicio_Sigla">
<input type="<?= $Page->Sigla->getInputTextType() ?>" data-table="servicio" data-field="x_Sigla" name="x_Sigla" id="x_Sigla" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Sigla->getPlaceHolder()) ?>" value="<?= $Page->Sigla->EditValue ?>"<?= $Page->Sigla->editAttributes() ?> aria-describedby="x_Sigla_help">
<?= $Page->Sigla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sigla->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_servicio_Sigla">
<span<?= $Page->Sigla->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Sigla->getDisplayValue($Page->Sigla->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="servicio" data-field="x_Sigla" data-hidden="1" name="x_Sigla" id="x_Sigla" value="<?= HtmlEncode($Page->Sigla->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
    <div id="r_Nombre" class="form-group row">
        <label id="elh_servicio_Nombre" for="x_Nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nombre->caption() ?><?= $Page->Nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Nombre->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_servicio_Nombre">
<input type="<?= $Page->Nombre->getInputTextType() ?>" data-table="servicio" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Nombre->getPlaceHolder()) ?>" value="<?= $Page->Nombre->EditValue ?>"<?= $Page->Nombre->editAttributes() ?> aria-describedby="x_Nombre_help">
<?= $Page->Nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nombre->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_servicio_Nombre">
<span<?= $Page->Nombre->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nombre->getDisplayValue($Page->Nombre->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="servicio" data-field="x_Nombre" data-hidden="1" name="x_Nombre" id="x_Nombre" value="<?= HtmlEncode($Page->Nombre->FormValue) ?>">
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
    ew.addEventHandlers("servicio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
