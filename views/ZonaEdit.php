<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$ZonaEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fzonaedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fzonaedit = currentForm = new ew.Form("fzonaedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "zona")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.zona)
        ew.vars.tables.zona = currentTable;
    fzonaedit.addFields([
        ["CodZona", [fields.CodZona.visible && fields.CodZona.required ? ew.Validators.required(fields.CodZona.caption) : null], fields.CodZona.isInvalid],
        ["Nombre", [fields.Nombre.visible && fields.Nombre.required ? ew.Validators.required(fields.Nombre.caption) : null], fields.Nombre.isInvalid],
        ["Color", [fields.Color.visible && fields.Color.required ? ew.Validators.required(fields.Color.caption) : null], fields.Color.isInvalid],
        ["Coordenada", [fields.Coordenada.visible && fields.Coordenada.required ? ew.Validators.required(fields.Coordenada.caption) : null], fields.Coordenada.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fzonaedit,
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
    fzonaedit.validate = function () {
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
    fzonaedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fzonaedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fzonaedit");
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
<form name="fzonaedit" id="fzonaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="zona">
<input type="hidden" name="k_hash" id="k_hash" value="<?= $Page->HashValue ?>">
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CodZona->Visible) { // CodZona ?>
    <div id="r_CodZona" class="form-group row">
        <label id="elh_zona_CodZona" for="x_CodZona" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodZona->caption() ?><?= $Page->CodZona->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodZona->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<input type="<?= $Page->CodZona->getInputTextType() ?>" data-table="zona" data-field="x_CodZona" name="x_CodZona" id="x_CodZona" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->CodZona->getPlaceHolder()) ?>" value="<?= $Page->CodZona->EditValue ?>"<?= $Page->CodZona->editAttributes() ?> aria-describedby="x_CodZona_help">
<?= $Page->CodZona->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CodZona->getErrorMessage() ?></div>
<input type="hidden" data-table="zona" data-field="x_CodZona" data-hidden="1" name="o_CodZona" id="o_CodZona" value="<?= HtmlEncode($Page->CodZona->OldValue ?? $Page->CodZona->CurrentValue) ?>">
<?php } else { ?>
<span id="el_zona_CodZona">
<span<?= $Page->CodZona->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodZona->getDisplayValue($Page->CodZona->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="zona" data-field="x_CodZona" data-hidden="1" name="x_CodZona" id="x_CodZona" value="<?= HtmlEncode($Page->CodZona->FormValue) ?>">
<input type="hidden" data-table="zona" data-field="x_CodZona" data-hidden="1" name="o_CodZona" id="o_CodZona" value="<?= HtmlEncode($Page->CodZona->OldValue ?? $Page->CodZona->CurrentValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nombre->Visible) { // Nombre ?>
    <div id="r_Nombre" class="form-group row">
        <label id="elh_zona_Nombre" for="x_Nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nombre->caption() ?><?= $Page->Nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Nombre->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_zona_Nombre">
<input type="<?= $Page->Nombre->getInputTextType() ?>" data-table="zona" data-field="x_Nombre" name="x_Nombre" id="x_Nombre" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->Nombre->getPlaceHolder()) ?>" value="<?= $Page->Nombre->EditValue ?>"<?= $Page->Nombre->editAttributes() ?> aria-describedby="x_Nombre_help">
<?= $Page->Nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nombre->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_zona_Nombre">
<span<?= $Page->Nombre->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nombre->getDisplayValue($Page->Nombre->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="zona" data-field="x_Nombre" data-hidden="1" name="x_Nombre" id="x_Nombre" value="<?= HtmlEncode($Page->Nombre->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Color->Visible) { // Color ?>
    <div id="r_Color" class="form-group row">
        <label id="elh_zona_Color" for="x_Color" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Color->caption() ?><?= $Page->Color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Color->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_zona_Color">
<input type="<?= $Page->Color->getInputTextType() ?>" data-table="zona" data-field="x_Color" name="x_Color" id="x_Color" size="30" maxlength="7" placeholder="<?= HtmlEncode($Page->Color->getPlaceHolder()) ?>" value="<?= $Page->Color->EditValue ?>"<?= $Page->Color->editAttributes() ?> aria-describedby="x_Color_help">
<?= $Page->Color->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Color->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_zona_Color">
<span<?= $Page->Color->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Color->getDisplayValue($Page->Color->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="zona" data-field="x_Color" data-hidden="1" name="x_Color" id="x_Color" value="<?= HtmlEncode($Page->Color->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Coordenada->Visible) { // Coordenada ?>
    <div id="r_Coordenada" class="form-group row">
        <label id="elh_zona_Coordenada" for="x_Coordenada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Coordenada->caption() ?><?= $Page->Coordenada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Coordenada->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_zona_Coordenada">
<textarea data-table="zona" data-field="x_Coordenada" name="x_Coordenada" id="x_Coordenada" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Coordenada->getPlaceHolder()) ?>"<?= $Page->Coordenada->editAttributes() ?> aria-describedby="x_Coordenada_help"><?= $Page->Coordenada->EditValue ?></textarea>
<?= $Page->Coordenada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Coordenada->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_zona_Coordenada">
<span<?= $Page->Coordenada->viewAttributes() ?>>
<?= $Page->Coordenada->ViewValue ?></span>
</span>
<input type="hidden" data-table="zona" data-field="x_Coordenada" data-hidden="1" name="x_Coordenada" id="x_Coordenada" value="<?= HtmlEncode($Page->Coordenada->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
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
    ew.addEventHandlers("zona");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
