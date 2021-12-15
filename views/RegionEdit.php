<?php

namespace PHPMaker2021\CloseContracts;

// Page object
$RegionEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregionedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fregionedit = currentForm = new ew.Form("fregionedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "region")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.region)
        ew.vars.tables.region = currentTable;
    fregionedit.addFields([
        ["CodRegion", [fields.CodRegion.visible && fields.CodRegion.required ? ew.Validators.required(fields.CodRegion.caption) : null], fields.CodRegion.isInvalid],
        ["Sigla", [fields.Sigla.visible && fields.Sigla.required ? ew.Validators.required(fields.Sigla.caption) : null], fields.Sigla.isInvalid],
        ["Descripcion", [fields.Descripcion.visible && fields.Descripcion.required ? ew.Validators.required(fields.Descripcion.caption) : null], fields.Descripcion.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fregionedit,
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
    fregionedit.validate = function () {
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
    fregionedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregionedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fregionedit");
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
<form name="fregionedit" id="fregionedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="region">
<input type="hidden" name="k_hash" id="k_hash" value="<?= $Page->HashValue ?>">
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CodRegion->Visible) { // CodRegion ?>
    <div id="r_CodRegion" class="form-group row">
        <label id="elh_region_CodRegion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CodRegion->caption() ?><?= $Page->CodRegion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CodRegion->cellAttributes() ?>>
<span id="el_region_CodRegion">
<span<?= $Page->CodRegion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CodRegion->getDisplayValue($Page->CodRegion->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="region" data-field="x_CodRegion" data-hidden="1" name="x_CodRegion" id="x_CodRegion" value="<?= HtmlEncode($Page->CodRegion->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Sigla->Visible) { // Sigla ?>
    <div id="r_Sigla" class="form-group row">
        <label id="elh_region_Sigla" for="x_Sigla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sigla->caption() ?><?= $Page->Sigla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Sigla->cellAttributes() ?>>
<span id="el_region_Sigla">
<input type="<?= $Page->Sigla->getInputTextType() ?>" data-table="region" data-field="x_Sigla" name="x_Sigla" id="x_Sigla" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Sigla->getPlaceHolder()) ?>" value="<?= $Page->Sigla->EditValue ?>"<?= $Page->Sigla->editAttributes() ?> aria-describedby="x_Sigla_help">
<?= $Page->Sigla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sigla->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Descripcion->Visible) { // Descripcion ?>
    <div id="r_Descripcion" class="form-group row">
        <label id="elh_region_Descripcion" for="x_Descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Descripcion->caption() ?><?= $Page->Descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Descripcion->cellAttributes() ?>>
<span id="el_region_Descripcion">
<input type="<?= $Page->Descripcion->getInputTextType() ?>" data-table="region" data-field="x_Descripcion" name="x_Descripcion" id="x_Descripcion" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Descripcion->getPlaceHolder()) ?>" value="<?= $Page->Descripcion->EditValue ?>"<?= $Page->Descripcion->editAttributes() ?> aria-describedby="x_Descripcion_help">
<?= $Page->Descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Descripcion->getErrorMessage() ?></div>
</span>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("region");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
