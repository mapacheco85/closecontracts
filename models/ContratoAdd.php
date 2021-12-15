<?php

namespace PHPMaker2021\CloseContracts;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ContratoAdd extends Contrato
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'contrato';

    // Page object name
    public $PageObjName = "ContratoAdd";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (contrato)
        if (!isset($GLOBALS["contrato"]) || get_class($GLOBALS["contrato"]) == PROJECT_NAMESPACE . "contrato") {
            $GLOBALS["contrato"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'contrato');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("contrato"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "contratoview") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['CodContrato'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->CodContrato->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->CodContrato->Visible = false;
        $this->Fecha->setVisibility();
        $this->Lugar->setVisibility();
        $this->Vencimiento->setVisibility();
        $this->CodigoInterno->setVisibility();
        $this->MotivoBaja->setVisibility();
        $this->Vigente->setVisibility();
        $this->CodServicio->setVisibility();
        $this->CodProveedor->setVisibility();
        $this->Monto->setVisibility();
        $this->Archivo->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->CodServicio);
        $this->setupLookupOptions($this->CodProveedor);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("CodContrato") ?? Route("CodContrato")) !== null) {
                $this->CodContrato->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("contratolist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "contratolist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "contratoview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render view type
        } else {
            $this->RowType = ROWTYPE_ADD; // Render add type
        }

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->Archivo->Upload->Index = $CurrentForm->Index;
        $this->Archivo->Upload->uploadFile();
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->CodContrato->CurrentValue = null;
        $this->CodContrato->OldValue = $this->CodContrato->CurrentValue;
        $this->Fecha->CurrentValue = null;
        $this->Fecha->OldValue = $this->Fecha->CurrentValue;
        $this->Lugar->CurrentValue = null;
        $this->Lugar->OldValue = $this->Lugar->CurrentValue;
        $this->Vencimiento->CurrentValue = null;
        $this->Vencimiento->OldValue = $this->Vencimiento->CurrentValue;
        $this->CodigoInterno->CurrentValue = null;
        $this->CodigoInterno->OldValue = $this->CodigoInterno->CurrentValue;
        $this->MotivoBaja->CurrentValue = null;
        $this->MotivoBaja->OldValue = $this->MotivoBaja->CurrentValue;
        $this->Vigente->CurrentValue = null;
        $this->Vigente->OldValue = $this->Vigente->CurrentValue;
        $this->CodServicio->CurrentValue = null;
        $this->CodServicio->OldValue = $this->CodServicio->CurrentValue;
        $this->CodProveedor->CurrentValue = null;
        $this->CodProveedor->OldValue = $this->CodProveedor->CurrentValue;
        $this->Monto->CurrentValue = null;
        $this->Monto->OldValue = $this->Monto->CurrentValue;
        $this->Archivo->Upload->DbValue = null;
        $this->Archivo->OldValue = $this->Archivo->Upload->DbValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'Fecha' first before field var 'x_Fecha'
        $val = $CurrentForm->hasValue("Fecha") ? $CurrentForm->getValue("Fecha") : $CurrentForm->getValue("x_Fecha");
        if (!$this->Fecha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Fecha->Visible = false; // Disable update for API request
            } else {
                $this->Fecha->setFormValue($val);
            }
            $this->Fecha->CurrentValue = UnFormatDateTime($this->Fecha->CurrentValue, 0);
        }

        // Check field name 'Lugar' first before field var 'x_Lugar'
        $val = $CurrentForm->hasValue("Lugar") ? $CurrentForm->getValue("Lugar") : $CurrentForm->getValue("x_Lugar");
        if (!$this->Lugar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Lugar->Visible = false; // Disable update for API request
            } else {
                $this->Lugar->setFormValue($val);
            }
        }

        // Check field name 'Vencimiento' first before field var 'x_Vencimiento'
        $val = $CurrentForm->hasValue("Vencimiento") ? $CurrentForm->getValue("Vencimiento") : $CurrentForm->getValue("x_Vencimiento");
        if (!$this->Vencimiento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Vencimiento->Visible = false; // Disable update for API request
            } else {
                $this->Vencimiento->setFormValue($val);
            }
            $this->Vencimiento->CurrentValue = UnFormatDateTime($this->Vencimiento->CurrentValue, 0);
        }

        // Check field name 'CodigoInterno' first before field var 'x_CodigoInterno'
        $val = $CurrentForm->hasValue("CodigoInterno") ? $CurrentForm->getValue("CodigoInterno") : $CurrentForm->getValue("x_CodigoInterno");
        if (!$this->CodigoInterno->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CodigoInterno->Visible = false; // Disable update for API request
            } else {
                $this->CodigoInterno->setFormValue($val);
            }
        }

        // Check field name 'MotivoBaja' first before field var 'x_MotivoBaja'
        $val = $CurrentForm->hasValue("MotivoBaja") ? $CurrentForm->getValue("MotivoBaja") : $CurrentForm->getValue("x_MotivoBaja");
        if (!$this->MotivoBaja->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MotivoBaja->Visible = false; // Disable update for API request
            } else {
                $this->MotivoBaja->setFormValue($val);
            }
        }

        // Check field name 'Vigente' first before field var 'x_Vigente'
        $val = $CurrentForm->hasValue("Vigente") ? $CurrentForm->getValue("Vigente") : $CurrentForm->getValue("x_Vigente");
        if (!$this->Vigente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Vigente->Visible = false; // Disable update for API request
            } else {
                $this->Vigente->setFormValue($val);
            }
        }

        // Check field name 'CodServicio' first before field var 'x_CodServicio'
        $val = $CurrentForm->hasValue("CodServicio") ? $CurrentForm->getValue("CodServicio") : $CurrentForm->getValue("x_CodServicio");
        if (!$this->CodServicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CodServicio->Visible = false; // Disable update for API request
            } else {
                $this->CodServicio->setFormValue($val);
            }
        }

        // Check field name 'CodProveedor' first before field var 'x_CodProveedor'
        $val = $CurrentForm->hasValue("CodProveedor") ? $CurrentForm->getValue("CodProveedor") : $CurrentForm->getValue("x_CodProveedor");
        if (!$this->CodProveedor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CodProveedor->Visible = false; // Disable update for API request
            } else {
                $this->CodProveedor->setFormValue($val);
            }
        }

        // Check field name 'Monto' first before field var 'x_Monto'
        $val = $CurrentForm->hasValue("Monto") ? $CurrentForm->getValue("Monto") : $CurrentForm->getValue("x_Monto");
        if (!$this->Monto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Monto->Visible = false; // Disable update for API request
            } else {
                $this->Monto->setFormValue($val);
            }
        }

        // Check field name 'CodContrato' first before field var 'x_CodContrato'
        $val = $CurrentForm->hasValue("CodContrato") ? $CurrentForm->getValue("CodContrato") : $CurrentForm->getValue("x_CodContrato");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Fecha->CurrentValue = $this->Fecha->FormValue;
        $this->Fecha->CurrentValue = UnFormatDateTime($this->Fecha->CurrentValue, 0);
        $this->Lugar->CurrentValue = $this->Lugar->FormValue;
        $this->Vencimiento->CurrentValue = $this->Vencimiento->FormValue;
        $this->Vencimiento->CurrentValue = UnFormatDateTime($this->Vencimiento->CurrentValue, 0);
        $this->CodigoInterno->CurrentValue = $this->CodigoInterno->FormValue;
        $this->MotivoBaja->CurrentValue = $this->MotivoBaja->FormValue;
        $this->Vigente->CurrentValue = $this->Vigente->FormValue;
        $this->CodServicio->CurrentValue = $this->CodServicio->FormValue;
        $this->CodProveedor->CurrentValue = $this->CodProveedor->FormValue;
        $this->Monto->CurrentValue = $this->Monto->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->CodContrato->setDbValue($row['CodContrato']);
        $this->Fecha->setDbValue($row['Fecha']);
        $this->Lugar->setDbValue($row['Lugar']);
        $this->Vencimiento->setDbValue($row['Vencimiento']);
        $this->CodigoInterno->setDbValue($row['CodigoInterno']);
        $this->MotivoBaja->setDbValue($row['MotivoBaja']);
        $this->Vigente->setDbValue($row['Vigente']);
        $this->CodServicio->setDbValue($row['CodServicio']);
        $this->CodProveedor->setDbValue($row['CodProveedor']);
        $this->Monto->setDbValue($row['Monto']);
        $this->Archivo->Upload->DbValue = $row['Archivo'];
        if (is_resource($this->Archivo->Upload->DbValue) && get_resource_type($this->Archivo->Upload->DbValue) == "stream") { // Byte array
            $this->Archivo->Upload->DbValue = stream_get_contents($this->Archivo->Upload->DbValue);
        }
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['CodContrato'] = $this->CodContrato->CurrentValue;
        $row['Fecha'] = $this->Fecha->CurrentValue;
        $row['Lugar'] = $this->Lugar->CurrentValue;
        $row['Vencimiento'] = $this->Vencimiento->CurrentValue;
        $row['CodigoInterno'] = $this->CodigoInterno->CurrentValue;
        $row['MotivoBaja'] = $this->MotivoBaja->CurrentValue;
        $row['Vigente'] = $this->Vigente->CurrentValue;
        $row['CodServicio'] = $this->CodServicio->CurrentValue;
        $row['CodProveedor'] = $this->CodProveedor->CurrentValue;
        $row['Monto'] = $this->Monto->CurrentValue;
        $row['Archivo'] = $this->Archivo->Upload->DbValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Convert decimal values if posted back
        if ($this->Monto->FormValue == $this->Monto->CurrentValue && is_numeric(ConvertToFloatString($this->Monto->CurrentValue))) {
            $this->Monto->CurrentValue = ConvertToFloatString($this->Monto->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // CodContrato

        // Fecha

        // Lugar

        // Vencimiento

        // CodigoInterno

        // MotivoBaja

        // Vigente

        // CodServicio

        // CodProveedor

        // Monto

        // Archivo
        if ($this->RowType == ROWTYPE_VIEW) {
            // CodContrato
            $this->CodContrato->ViewValue = $this->CodContrato->CurrentValue;
            $this->CodContrato->ViewValue = FormatNumber($this->CodContrato->ViewValue, 0, -2, -2, -2);
            $this->CodContrato->ViewCustomAttributes = "";

            // Fecha
            $this->Fecha->ViewValue = $this->Fecha->CurrentValue;
            $this->Fecha->ViewValue = FormatDateTime($this->Fecha->ViewValue, 0);
            $this->Fecha->ViewCustomAttributes = "";

            // Lugar
            $this->Lugar->ViewValue = $this->Lugar->CurrentValue;
            $this->Lugar->ViewCustomAttributes = "";

            // Vencimiento
            $this->Vencimiento->ViewValue = $this->Vencimiento->CurrentValue;
            $this->Vencimiento->ViewValue = FormatDateTime($this->Vencimiento->ViewValue, 0);
            $this->Vencimiento->ViewCustomAttributes = "";

            // CodigoInterno
            $this->CodigoInterno->ViewValue = $this->CodigoInterno->CurrentValue;
            $this->CodigoInterno->ViewCustomAttributes = "";

            // MotivoBaja
            if (strval($this->MotivoBaja->CurrentValue) != "") {
                $this->MotivoBaja->ViewValue = $this->MotivoBaja->optionCaption($this->MotivoBaja->CurrentValue);
            } else {
                $this->MotivoBaja->ViewValue = null;
            }
            $this->MotivoBaja->ViewCustomAttributes = "";

            // Vigente
            if (ConvertToBool($this->Vigente->CurrentValue)) {
                $this->Vigente->ViewValue = $this->Vigente->tagCaption(1) != "" ? $this->Vigente->tagCaption(1) : "Yes";
            } else {
                $this->Vigente->ViewValue = $this->Vigente->tagCaption(2) != "" ? $this->Vigente->tagCaption(2) : "No";
            }
            $this->Vigente->ViewCustomAttributes = "";

            // CodServicio
            $curVal = trim(strval($this->CodServicio->CurrentValue));
            if ($curVal != "") {
                $this->CodServicio->ViewValue = $this->CodServicio->lookupCacheOption($curVal);
                if ($this->CodServicio->ViewValue === null) { // Lookup from database
                    $filterWrk = "`CodServicio`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CodServicio->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CodServicio->Lookup->renderViewRow($rswrk[0]);
                        $this->CodServicio->ViewValue = $this->CodServicio->displayValue($arwrk);
                    } else {
                        $this->CodServicio->ViewValue = $this->CodServicio->CurrentValue;
                    }
                }
            } else {
                $this->CodServicio->ViewValue = null;
            }
            $this->CodServicio->ViewCustomAttributes = "";

            // CodProveedor
            $curVal = trim(strval($this->CodProveedor->CurrentValue));
            if ($curVal != "") {
                $this->CodProveedor->ViewValue = $this->CodProveedor->lookupCacheOption($curVal);
                if ($this->CodProveedor->ViewValue === null) { // Lookup from database
                    $filterWrk = "`CodProveedor`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CodProveedor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CodProveedor->Lookup->renderViewRow($rswrk[0]);
                        $this->CodProveedor->ViewValue = $this->CodProveedor->displayValue($arwrk);
                    } else {
                        $this->CodProveedor->ViewValue = $this->CodProveedor->CurrentValue;
                    }
                }
            } else {
                $this->CodProveedor->ViewValue = null;
            }
            $this->CodProveedor->ViewCustomAttributes = "";

            // Monto
            $this->Monto->ViewValue = $this->Monto->CurrentValue;
            $this->Monto->ViewValue = FormatNumber($this->Monto->ViewValue, 2, -2, -2, -2);
            $this->Monto->ViewCustomAttributes = "";

            // Archivo
            if (!EmptyValue($this->Archivo->Upload->DbValue)) {
                $this->Archivo->ViewValue = $this->CodContrato->CurrentValue;
                $this->Archivo->IsBlobImage = IsImageFile(ContentExtension($this->Archivo->Upload->DbValue));
            } else {
                $this->Archivo->ViewValue = "";
            }
            $this->Archivo->ViewCustomAttributes = "";

            // Fecha
            $this->Fecha->LinkCustomAttributes = "";
            $this->Fecha->HrefValue = "";
            $this->Fecha->TooltipValue = "";

            // Lugar
            $this->Lugar->LinkCustomAttributes = "";
            $this->Lugar->HrefValue = "";
            $this->Lugar->TooltipValue = "";

            // Vencimiento
            $this->Vencimiento->LinkCustomAttributes = "";
            $this->Vencimiento->HrefValue = "";
            $this->Vencimiento->TooltipValue = "";

            // CodigoInterno
            $this->CodigoInterno->LinkCustomAttributes = "";
            $this->CodigoInterno->HrefValue = "";
            $this->CodigoInterno->TooltipValue = "";

            // MotivoBaja
            $this->MotivoBaja->LinkCustomAttributes = "";
            $this->MotivoBaja->HrefValue = "";
            $this->MotivoBaja->TooltipValue = "";

            // Vigente
            $this->Vigente->LinkCustomAttributes = "";
            $this->Vigente->HrefValue = "";
            $this->Vigente->TooltipValue = "";

            // CodServicio
            $this->CodServicio->LinkCustomAttributes = "";
            $this->CodServicio->HrefValue = "";
            $this->CodServicio->TooltipValue = "";

            // CodProveedor
            $this->CodProveedor->LinkCustomAttributes = "";
            $this->CodProveedor->HrefValue = "";
            $this->CodProveedor->TooltipValue = "";

            // Monto
            $this->Monto->LinkCustomAttributes = "";
            $this->Monto->HrefValue = "";
            $this->Monto->TooltipValue = "";

            // Archivo
            $this->Archivo->LinkCustomAttributes = "";
            if (!empty($this->Archivo->Upload->DbValue)) {
                $this->Archivo->HrefValue = GetFileUploadUrl($this->Archivo, $this->CodContrato->CurrentValue);
                $this->Archivo->LinkAttrs["target"] = "";
                if ($this->Archivo->IsBlobImage && empty($this->Archivo->LinkAttrs["target"])) {
                    $this->Archivo->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->Archivo->HrefValue = FullUrl($this->Archivo->HrefValue, "href");
                }
            } else {
                $this->Archivo->HrefValue = "";
            }
            $this->Archivo->ExportHrefValue = GetFileUploadUrl($this->Archivo, $this->CodContrato->CurrentValue);
            $this->Archivo->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Fecha
            $this->Fecha->EditAttrs["class"] = "form-control";
            $this->Fecha->EditCustomAttributes = "";
            $this->Fecha->EditValue = HtmlEncode(FormatDateTime($this->Fecha->CurrentValue, 8));
            $this->Fecha->PlaceHolder = RemoveHtml($this->Fecha->caption());

            // Lugar
            $this->Lugar->EditAttrs["class"] = "form-control";
            $this->Lugar->EditCustomAttributes = "";
            if (!$this->Lugar->Raw) {
                $this->Lugar->CurrentValue = HtmlDecode($this->Lugar->CurrentValue);
            }
            $this->Lugar->EditValue = HtmlEncode($this->Lugar->CurrentValue);
            $this->Lugar->PlaceHolder = RemoveHtml($this->Lugar->caption());

            // Vencimiento
            $this->Vencimiento->EditAttrs["class"] = "form-control";
            $this->Vencimiento->EditCustomAttributes = "";
            $this->Vencimiento->EditValue = HtmlEncode(FormatDateTime($this->Vencimiento->CurrentValue, 8));
            $this->Vencimiento->PlaceHolder = RemoveHtml($this->Vencimiento->caption());

            // CodigoInterno
            $this->CodigoInterno->EditAttrs["class"] = "form-control";
            $this->CodigoInterno->EditCustomAttributes = "";
            if (!$this->CodigoInterno->Raw) {
                $this->CodigoInterno->CurrentValue = HtmlDecode($this->CodigoInterno->CurrentValue);
            }
            $this->CodigoInterno->EditValue = HtmlEncode($this->CodigoInterno->CurrentValue);
            $this->CodigoInterno->PlaceHolder = RemoveHtml($this->CodigoInterno->caption());

            // MotivoBaja
            $this->MotivoBaja->EditAttrs["class"] = "form-control";
            $this->MotivoBaja->EditCustomAttributes = "";
            $this->MotivoBaja->EditValue = $this->MotivoBaja->options(true);
            $this->MotivoBaja->PlaceHolder = RemoveHtml($this->MotivoBaja->caption());

            // Vigente
            $this->Vigente->EditCustomAttributes = "";
            $this->Vigente->EditValue = $this->Vigente->options(false);
            $this->Vigente->PlaceHolder = RemoveHtml($this->Vigente->caption());

            // CodServicio
            $this->CodServicio->EditCustomAttributes = "";
            $curVal = trim(strval($this->CodServicio->CurrentValue));
            if ($curVal != "") {
                $this->CodServicio->ViewValue = $this->CodServicio->lookupCacheOption($curVal);
            } else {
                $this->CodServicio->ViewValue = $this->CodServicio->Lookup !== null && is_array($this->CodServicio->Lookup->Options) ? $curVal : null;
            }
            if ($this->CodServicio->ViewValue !== null) { // Load from cache
                $this->CodServicio->EditValue = array_values($this->CodServicio->Lookup->Options);
                if ($this->CodServicio->ViewValue == "") {
                    $this->CodServicio->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`CodServicio`" . SearchString("=", $this->CodServicio->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->CodServicio->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CodServicio->Lookup->renderViewRow($rswrk[0]);
                    $this->CodServicio->ViewValue = $this->CodServicio->displayValue($arwrk);
                } else {
                    $this->CodServicio->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->CodServicio->EditValue = $arwrk;
            }
            $this->CodServicio->PlaceHolder = RemoveHtml($this->CodServicio->caption());

            // CodProveedor
            $this->CodProveedor->EditCustomAttributes = "";
            $curVal = trim(strval($this->CodProveedor->CurrentValue));
            if ($curVal != "") {
                $this->CodProveedor->ViewValue = $this->CodProveedor->lookupCacheOption($curVal);
            } else {
                $this->CodProveedor->ViewValue = $this->CodProveedor->Lookup !== null && is_array($this->CodProveedor->Lookup->Options) ? $curVal : null;
            }
            if ($this->CodProveedor->ViewValue !== null) { // Load from cache
                $this->CodProveedor->EditValue = array_values($this->CodProveedor->Lookup->Options);
                if ($this->CodProveedor->ViewValue == "") {
                    $this->CodProveedor->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`CodProveedor`" . SearchString("=", $this->CodProveedor->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->CodProveedor->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CodProveedor->Lookup->renderViewRow($rswrk[0]);
                    $this->CodProveedor->ViewValue = $this->CodProveedor->displayValue($arwrk);
                } else {
                    $this->CodProveedor->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->CodProveedor->EditValue = $arwrk;
            }
            $this->CodProveedor->PlaceHolder = RemoveHtml($this->CodProveedor->caption());

            // Monto
            $this->Monto->EditAttrs["class"] = "form-control";
            $this->Monto->EditCustomAttributes = "";
            $this->Monto->EditValue = HtmlEncode($this->Monto->CurrentValue);
            $this->Monto->PlaceHolder = RemoveHtml($this->Monto->caption());
            if (strval($this->Monto->EditValue) != "" && is_numeric($this->Monto->EditValue)) {
                $this->Monto->EditValue = FormatNumber($this->Monto->EditValue, -2, -2, -2, -2);
            }

            // Archivo
            $this->Archivo->EditAttrs["class"] = "form-control";
            $this->Archivo->EditCustomAttributes = "";
            if (!EmptyValue($this->Archivo->Upload->DbValue)) {
                $this->Archivo->EditValue = $this->CodContrato->CurrentValue;
                $this->Archivo->IsBlobImage = IsImageFile(ContentExtension($this->Archivo->Upload->DbValue));
            } else {
                $this->Archivo->EditValue = "";
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->Archivo);
            }

            // Add refer script

            // Fecha
            $this->Fecha->LinkCustomAttributes = "";
            $this->Fecha->HrefValue = "";

            // Lugar
            $this->Lugar->LinkCustomAttributes = "";
            $this->Lugar->HrefValue = "";

            // Vencimiento
            $this->Vencimiento->LinkCustomAttributes = "";
            $this->Vencimiento->HrefValue = "";

            // CodigoInterno
            $this->CodigoInterno->LinkCustomAttributes = "";
            $this->CodigoInterno->HrefValue = "";

            // MotivoBaja
            $this->MotivoBaja->LinkCustomAttributes = "";
            $this->MotivoBaja->HrefValue = "";

            // Vigente
            $this->Vigente->LinkCustomAttributes = "";
            $this->Vigente->HrefValue = "";

            // CodServicio
            $this->CodServicio->LinkCustomAttributes = "";
            $this->CodServicio->HrefValue = "";

            // CodProveedor
            $this->CodProveedor->LinkCustomAttributes = "";
            $this->CodProveedor->HrefValue = "";

            // Monto
            $this->Monto->LinkCustomAttributes = "";
            $this->Monto->HrefValue = "";

            // Archivo
            $this->Archivo->LinkCustomAttributes = "";
            if (!empty($this->Archivo->Upload->DbValue)) {
                $this->Archivo->HrefValue = GetFileUploadUrl($this->Archivo, $this->CodContrato->CurrentValue);
                $this->Archivo->LinkAttrs["target"] = "";
                if ($this->Archivo->IsBlobImage && empty($this->Archivo->LinkAttrs["target"])) {
                    $this->Archivo->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->Archivo->HrefValue = FullUrl($this->Archivo->HrefValue, "href");
                }
            } else {
                $this->Archivo->HrefValue = "";
            }
            $this->Archivo->ExportHrefValue = GetFileUploadUrl($this->Archivo, $this->CodContrato->CurrentValue);
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->Fecha->Required) {
            if (!$this->Fecha->IsDetailKey && EmptyValue($this->Fecha->FormValue)) {
                $this->Fecha->addErrorMessage(str_replace("%s", $this->Fecha->caption(), $this->Fecha->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Fecha->FormValue)) {
            $this->Fecha->addErrorMessage($this->Fecha->getErrorMessage(false));
        }
        if ($this->Lugar->Required) {
            if (!$this->Lugar->IsDetailKey && EmptyValue($this->Lugar->FormValue)) {
                $this->Lugar->addErrorMessage(str_replace("%s", $this->Lugar->caption(), $this->Lugar->RequiredErrorMessage));
            }
        }
        if ($this->Vencimiento->Required) {
            if (!$this->Vencimiento->IsDetailKey && EmptyValue($this->Vencimiento->FormValue)) {
                $this->Vencimiento->addErrorMessage(str_replace("%s", $this->Vencimiento->caption(), $this->Vencimiento->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Vencimiento->FormValue)) {
            $this->Vencimiento->addErrorMessage($this->Vencimiento->getErrorMessage(false));
        }
        if ($this->CodigoInterno->Required) {
            if (!$this->CodigoInterno->IsDetailKey && EmptyValue($this->CodigoInterno->FormValue)) {
                $this->CodigoInterno->addErrorMessage(str_replace("%s", $this->CodigoInterno->caption(), $this->CodigoInterno->RequiredErrorMessage));
            }
        }
        if ($this->MotivoBaja->Required) {
            if (!$this->MotivoBaja->IsDetailKey && EmptyValue($this->MotivoBaja->FormValue)) {
                $this->MotivoBaja->addErrorMessage(str_replace("%s", $this->MotivoBaja->caption(), $this->MotivoBaja->RequiredErrorMessage));
            }
        }
        if ($this->Vigente->Required) {
            if ($this->Vigente->FormValue == "") {
                $this->Vigente->addErrorMessage(str_replace("%s", $this->Vigente->caption(), $this->Vigente->RequiredErrorMessage));
            }
        }
        if ($this->CodServicio->Required) {
            if (!$this->CodServicio->IsDetailKey && EmptyValue($this->CodServicio->FormValue)) {
                $this->CodServicio->addErrorMessage(str_replace("%s", $this->CodServicio->caption(), $this->CodServicio->RequiredErrorMessage));
            }
        }
        if ($this->CodProveedor->Required) {
            if (!$this->CodProveedor->IsDetailKey && EmptyValue($this->CodProveedor->FormValue)) {
                $this->CodProveedor->addErrorMessage(str_replace("%s", $this->CodProveedor->caption(), $this->CodProveedor->RequiredErrorMessage));
            }
        }
        if ($this->Monto->Required) {
            if (!$this->Monto->IsDetailKey && EmptyValue($this->Monto->FormValue)) {
                $this->Monto->addErrorMessage(str_replace("%s", $this->Monto->caption(), $this->Monto->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->Monto->FormValue)) {
            $this->Monto->addErrorMessage($this->Monto->getErrorMessage(false));
        }
        if ($this->Archivo->Required) {
            if ($this->Archivo->Upload->FileName == "" && !$this->Archivo->Upload->KeepFile) {
                $this->Archivo->addErrorMessage(str_replace("%s", $this->Archivo->caption(), $this->Archivo->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // Fecha
        $this->Fecha->setDbValueDef($rsnew, UnFormatDateTime($this->Fecha->CurrentValue, 0), CurrentDate(), false);

        // Lugar
        $this->Lugar->setDbValueDef($rsnew, $this->Lugar->CurrentValue, "", false);

        // Vencimiento
        $this->Vencimiento->setDbValueDef($rsnew, UnFormatDateTime($this->Vencimiento->CurrentValue, 0), CurrentDate(), false);

        // CodigoInterno
        $this->CodigoInterno->setDbValueDef($rsnew, $this->CodigoInterno->CurrentValue, "", false);

        // MotivoBaja
        $this->MotivoBaja->setDbValueDef($rsnew, $this->MotivoBaja->CurrentValue, null, false);

        // Vigente
        $tmpBool = $this->Vigente->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->Vigente->setDbValueDef($rsnew, $tmpBool, null, false);

        // CodServicio
        $this->CodServicio->setDbValueDef($rsnew, $this->CodServicio->CurrentValue, null, false);

        // CodProveedor
        $this->CodProveedor->setDbValueDef($rsnew, $this->CodProveedor->CurrentValue, null, false);

        // Monto
        $this->Monto->setDbValueDef($rsnew, $this->Monto->CurrentValue, 0, false);

        // Archivo
        if ($this->Archivo->Visible && !$this->Archivo->Upload->KeepFile) {
            if ($this->Archivo->Upload->Value === null) {
                $rsnew['Archivo'] = null;
            } else {
                $rsnew['Archivo'] = $this->Archivo->Upload->Value;
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // Archivo
            CleanUploadTempPath($this->Archivo, $this->Archivo->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("contratolist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_MotivoBaja":
                    break;
                case "x_Vigente":
                    break;
                case "x_CodServicio":
                    break;
                case "x_CodProveedor":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
