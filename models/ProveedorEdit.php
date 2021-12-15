<?php

namespace PHPMaker2021\CloseContracts;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ProveedorEdit extends Proveedor
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'proveedor';

    // Page object name
    public $PageObjName = "ProveedorEdit";

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

        // Table object (proveedor)
        if (!isset($GLOBALS["proveedor"]) || get_class($GLOBALS["proveedor"]) == PROJECT_NAMESPACE . "proveedor") {
            $GLOBALS["proveedor"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'proveedor');
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
                $doc = new $class(Container("proveedor"));
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
                    if ($pageName == "proveedorview") {
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
            $key .= @$ar['CodProveedor'];
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
            $this->CodProveedor->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->CodProveedor->setVisibility();
        $this->RazonSocial->setVisibility();
        $this->Propietario->setVisibility();
        $this->NIT->setVisibility();
        $this->Cedula->setVisibility();
        $this->Telefono->setVisibility();
        $this->Direccion->setVisibility();
        $this->CodRegion->setVisibility();
        $this->Vigente->setVisibility();
        $this->MinimoValidado->setVisibility();
        $this->tipo_transferencia->setVisibility();
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
        $this->setupLookupOptions($this->CodRegion);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("CodProveedor") ?? Key(0) ?? Route(2)) !== null) {
                $this->CodProveedor->setQueryStringValue($keyValue);
                $this->CodProveedor->setOldValue($this->CodProveedor->QueryStringValue);
            } elseif (Post("CodProveedor") !== null) {
                $this->CodProveedor->setFormValue(Post("CodProveedor"));
                $this->CodProveedor->setOldValue($this->CodProveedor->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("CodProveedor") ?? Route("CodProveedor")) !== null) {
                    $this->CodProveedor->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->CodProveedor->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("proveedorlist"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "proveedorlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render as View
        } else {
            $this->RowType = ROWTYPE_EDIT; // Render as Edit
        }
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'CodProveedor' first before field var 'x_CodProveedor'
        $val = $CurrentForm->hasValue("CodProveedor") ? $CurrentForm->getValue("CodProveedor") : $CurrentForm->getValue("x_CodProveedor");
        if (!$this->CodProveedor->IsDetailKey) {
            $this->CodProveedor->setFormValue($val);
        }

        // Check field name 'RazonSocial' first before field var 'x_RazonSocial'
        $val = $CurrentForm->hasValue("RazonSocial") ? $CurrentForm->getValue("RazonSocial") : $CurrentForm->getValue("x_RazonSocial");
        if (!$this->RazonSocial->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RazonSocial->Visible = false; // Disable update for API request
            } else {
                $this->RazonSocial->setFormValue($val);
            }
        }

        // Check field name 'Propietario' first before field var 'x_Propietario'
        $val = $CurrentForm->hasValue("Propietario") ? $CurrentForm->getValue("Propietario") : $CurrentForm->getValue("x_Propietario");
        if (!$this->Propietario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Propietario->Visible = false; // Disable update for API request
            } else {
                $this->Propietario->setFormValue($val);
            }
        }

        // Check field name 'NIT' first before field var 'x_NIT'
        $val = $CurrentForm->hasValue("NIT") ? $CurrentForm->getValue("NIT") : $CurrentForm->getValue("x_NIT");
        if (!$this->NIT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIT->Visible = false; // Disable update for API request
            } else {
                $this->NIT->setFormValue($val);
            }
        }

        // Check field name 'Cedula' first before field var 'x_Cedula'
        $val = $CurrentForm->hasValue("Cedula") ? $CurrentForm->getValue("Cedula") : $CurrentForm->getValue("x_Cedula");
        if (!$this->Cedula->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Cedula->Visible = false; // Disable update for API request
            } else {
                $this->Cedula->setFormValue($val);
            }
        }

        // Check field name 'Telefono' first before field var 'x_Telefono'
        $val = $CurrentForm->hasValue("Telefono") ? $CurrentForm->getValue("Telefono") : $CurrentForm->getValue("x_Telefono");
        if (!$this->Telefono->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Telefono->Visible = false; // Disable update for API request
            } else {
                $this->Telefono->setFormValue($val);
            }
        }

        // Check field name 'Direccion' first before field var 'x_Direccion'
        $val = $CurrentForm->hasValue("Direccion") ? $CurrentForm->getValue("Direccion") : $CurrentForm->getValue("x_Direccion");
        if (!$this->Direccion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Direccion->Visible = false; // Disable update for API request
            } else {
                $this->Direccion->setFormValue($val);
            }
        }

        // Check field name 'CodRegion' first before field var 'x_CodRegion'
        $val = $CurrentForm->hasValue("CodRegion") ? $CurrentForm->getValue("CodRegion") : $CurrentForm->getValue("x_CodRegion");
        if (!$this->CodRegion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CodRegion->Visible = false; // Disable update for API request
            } else {
                $this->CodRegion->setFormValue($val);
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

        // Check field name 'MinimoValidado' first before field var 'x_MinimoValidado'
        $val = $CurrentForm->hasValue("MinimoValidado") ? $CurrentForm->getValue("MinimoValidado") : $CurrentForm->getValue("x_MinimoValidado");
        if (!$this->MinimoValidado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MinimoValidado->Visible = false; // Disable update for API request
            } else {
                $this->MinimoValidado->setFormValue($val);
            }
        }

        // Check field name 'tipo_transferencia' first before field var 'x_tipo_transferencia'
        $val = $CurrentForm->hasValue("tipo_transferencia") ? $CurrentForm->getValue("tipo_transferencia") : $CurrentForm->getValue("x_tipo_transferencia");
        if (!$this->tipo_transferencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_transferencia->Visible = false; // Disable update for API request
            } else {
                $this->tipo_transferencia->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->CodProveedor->CurrentValue = $this->CodProveedor->FormValue;
        $this->RazonSocial->CurrentValue = $this->RazonSocial->FormValue;
        $this->Propietario->CurrentValue = $this->Propietario->FormValue;
        $this->NIT->CurrentValue = $this->NIT->FormValue;
        $this->Cedula->CurrentValue = $this->Cedula->FormValue;
        $this->Telefono->CurrentValue = $this->Telefono->FormValue;
        $this->Direccion->CurrentValue = $this->Direccion->FormValue;
        $this->CodRegion->CurrentValue = $this->CodRegion->FormValue;
        $this->Vigente->CurrentValue = $this->Vigente->FormValue;
        $this->MinimoValidado->CurrentValue = $this->MinimoValidado->FormValue;
        $this->tipo_transferencia->CurrentValue = $this->tipo_transferencia->FormValue;
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
        $this->CodProveedor->setDbValue($row['CodProveedor']);
        $this->RazonSocial->setDbValue($row['RazonSocial']);
        $this->Propietario->setDbValue($row['Propietario']);
        $this->NIT->setDbValue($row['NIT']);
        $this->Cedula->setDbValue($row['Cedula']);
        $this->Telefono->setDbValue($row['Telefono']);
        $this->Direccion->setDbValue($row['Direccion']);
        $this->CodRegion->setDbValue($row['CodRegion']);
        $this->Vigente->setDbValue($row['Vigente']);
        $this->MinimoValidado->setDbValue($row['MinimoValidado']);
        $this->tipo_transferencia->setDbValue($row['tipo_transferencia']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['CodProveedor'] = null;
        $row['RazonSocial'] = null;
        $row['Propietario'] = null;
        $row['NIT'] = null;
        $row['Cedula'] = null;
        $row['Telefono'] = null;
        $row['Direccion'] = null;
        $row['CodRegion'] = null;
        $row['Vigente'] = null;
        $row['MinimoValidado'] = null;
        $row['tipo_transferencia'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // CodProveedor

        // RazonSocial

        // Propietario

        // NIT

        // Cedula

        // Telefono

        // Direccion

        // CodRegion

        // Vigente

        // MinimoValidado

        // tipo_transferencia
        if ($this->RowType == ROWTYPE_VIEW) {
            // CodProveedor
            $this->CodProveedor->ViewValue = $this->CodProveedor->CurrentValue;
            $this->CodProveedor->ViewValue = FormatNumber($this->CodProveedor->ViewValue, 0, -2, -2, -2);
            $this->CodProveedor->ViewCustomAttributes = "";

            // RazonSocial
            $this->RazonSocial->ViewValue = $this->RazonSocial->CurrentValue;
            $this->RazonSocial->ViewCustomAttributes = "";

            // Propietario
            $this->Propietario->ViewValue = $this->Propietario->CurrentValue;
            $this->Propietario->ViewCustomAttributes = "";

            // NIT
            $this->NIT->ViewValue = $this->NIT->CurrentValue;
            $this->NIT->ViewCustomAttributes = "";

            // Cedula
            $this->Cedula->ViewValue = $this->Cedula->CurrentValue;
            $this->Cedula->ViewCustomAttributes = "";

            // Telefono
            $this->Telefono->ViewValue = $this->Telefono->CurrentValue;
            $this->Telefono->ViewCustomAttributes = "";

            // Direccion
            $this->Direccion->ViewValue = $this->Direccion->CurrentValue;
            $this->Direccion->ViewCustomAttributes = "";

            // CodRegion
            $curVal = trim(strval($this->CodRegion->CurrentValue));
            if ($curVal != "") {
                $this->CodRegion->ViewValue = $this->CodRegion->lookupCacheOption($curVal);
                if ($this->CodRegion->ViewValue === null) { // Lookup from database
                    $filterWrk = "`CodRegion`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CodRegion->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CodRegion->Lookup->renderViewRow($rswrk[0]);
                        $this->CodRegion->ViewValue = $this->CodRegion->displayValue($arwrk);
                    } else {
                        $this->CodRegion->ViewValue = $this->CodRegion->CurrentValue;
                    }
                }
            } else {
                $this->CodRegion->ViewValue = null;
            }
            $this->CodRegion->ViewCustomAttributes = "";

            // Vigente
            if (ConvertToBool($this->Vigente->CurrentValue)) {
                $this->Vigente->ViewValue = $this->Vigente->tagCaption(1) != "" ? $this->Vigente->tagCaption(1) : "Yes";
            } else {
                $this->Vigente->ViewValue = $this->Vigente->tagCaption(2) != "" ? $this->Vigente->tagCaption(2) : "No";
            }
            $this->Vigente->ViewCustomAttributes = "";

            // MinimoValidado
            $this->MinimoValidado->ViewValue = $this->MinimoValidado->CurrentValue;
            $this->MinimoValidado->ViewValue = FormatNumber($this->MinimoValidado->ViewValue, 0, -2, -2, -2);
            $this->MinimoValidado->ViewCustomAttributes = "";

            // tipo_transferencia
            if (strval($this->tipo_transferencia->CurrentValue) != "") {
                $this->tipo_transferencia->ViewValue = $this->tipo_transferencia->optionCaption($this->tipo_transferencia->CurrentValue);
            } else {
                $this->tipo_transferencia->ViewValue = null;
            }
            $this->tipo_transferencia->ViewCustomAttributes = "";

            // CodProveedor
            $this->CodProveedor->LinkCustomAttributes = "";
            $this->CodProveedor->HrefValue = "";
            $this->CodProveedor->TooltipValue = "";

            // RazonSocial
            $this->RazonSocial->LinkCustomAttributes = "";
            $this->RazonSocial->HrefValue = "";
            $this->RazonSocial->TooltipValue = "";

            // Propietario
            $this->Propietario->LinkCustomAttributes = "";
            $this->Propietario->HrefValue = "";
            $this->Propietario->TooltipValue = "";

            // NIT
            $this->NIT->LinkCustomAttributes = "";
            $this->NIT->HrefValue = "";
            $this->NIT->TooltipValue = "";

            // Cedula
            $this->Cedula->LinkCustomAttributes = "";
            $this->Cedula->HrefValue = "";
            $this->Cedula->TooltipValue = "";

            // Telefono
            $this->Telefono->LinkCustomAttributes = "";
            $this->Telefono->HrefValue = "";
            $this->Telefono->TooltipValue = "";

            // Direccion
            $this->Direccion->LinkCustomAttributes = "";
            $this->Direccion->HrefValue = "";
            $this->Direccion->TooltipValue = "";

            // CodRegion
            $this->CodRegion->LinkCustomAttributes = "";
            $this->CodRegion->HrefValue = "";
            $this->CodRegion->TooltipValue = "";

            // Vigente
            $this->Vigente->LinkCustomAttributes = "";
            $this->Vigente->HrefValue = "";
            $this->Vigente->TooltipValue = "";

            // MinimoValidado
            $this->MinimoValidado->LinkCustomAttributes = "";
            $this->MinimoValidado->HrefValue = "";
            $this->MinimoValidado->TooltipValue = "";

            // tipo_transferencia
            $this->tipo_transferencia->LinkCustomAttributes = "";
            $this->tipo_transferencia->HrefValue = "";
            $this->tipo_transferencia->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // CodProveedor
            $this->CodProveedor->EditAttrs["class"] = "form-control";
            $this->CodProveedor->EditCustomAttributes = "";
            $this->CodProveedor->EditValue = $this->CodProveedor->CurrentValue;
            $this->CodProveedor->EditValue = FormatNumber($this->CodProveedor->EditValue, 0, -2, -2, -2);
            $this->CodProveedor->ViewCustomAttributes = "";

            // RazonSocial
            $this->RazonSocial->EditAttrs["class"] = "form-control";
            $this->RazonSocial->EditCustomAttributes = "";
            if (!$this->RazonSocial->Raw) {
                $this->RazonSocial->CurrentValue = HtmlDecode($this->RazonSocial->CurrentValue);
            }
            $this->RazonSocial->EditValue = HtmlEncode($this->RazonSocial->CurrentValue);
            $this->RazonSocial->PlaceHolder = RemoveHtml($this->RazonSocial->caption());

            // Propietario
            $this->Propietario->EditAttrs["class"] = "form-control";
            $this->Propietario->EditCustomAttributes = "";
            if (!$this->Propietario->Raw) {
                $this->Propietario->CurrentValue = HtmlDecode($this->Propietario->CurrentValue);
            }
            $this->Propietario->EditValue = HtmlEncode($this->Propietario->CurrentValue);
            $this->Propietario->PlaceHolder = RemoveHtml($this->Propietario->caption());

            // NIT
            $this->NIT->EditAttrs["class"] = "form-control";
            $this->NIT->EditCustomAttributes = "";
            if (!$this->NIT->Raw) {
                $this->NIT->CurrentValue = HtmlDecode($this->NIT->CurrentValue);
            }
            $this->NIT->EditValue = HtmlEncode($this->NIT->CurrentValue);
            $this->NIT->PlaceHolder = RemoveHtml($this->NIT->caption());

            // Cedula
            $this->Cedula->EditAttrs["class"] = "form-control";
            $this->Cedula->EditCustomAttributes = "";
            if (!$this->Cedula->Raw) {
                $this->Cedula->CurrentValue = HtmlDecode($this->Cedula->CurrentValue);
            }
            $this->Cedula->EditValue = HtmlEncode($this->Cedula->CurrentValue);
            $this->Cedula->PlaceHolder = RemoveHtml($this->Cedula->caption());

            // Telefono
            $this->Telefono->EditAttrs["class"] = "form-control";
            $this->Telefono->EditCustomAttributes = "";
            if (!$this->Telefono->Raw) {
                $this->Telefono->CurrentValue = HtmlDecode($this->Telefono->CurrentValue);
            }
            $this->Telefono->EditValue = HtmlEncode($this->Telefono->CurrentValue);
            $this->Telefono->PlaceHolder = RemoveHtml($this->Telefono->caption());

            // Direccion
            $this->Direccion->EditAttrs["class"] = "form-control";
            $this->Direccion->EditCustomAttributes = "";
            if (!$this->Direccion->Raw) {
                $this->Direccion->CurrentValue = HtmlDecode($this->Direccion->CurrentValue);
            }
            $this->Direccion->EditValue = HtmlEncode($this->Direccion->CurrentValue);
            $this->Direccion->PlaceHolder = RemoveHtml($this->Direccion->caption());

            // CodRegion
            $this->CodRegion->EditCustomAttributes = "";
            $curVal = trim(strval($this->CodRegion->CurrentValue));
            if ($curVal != "") {
                $this->CodRegion->ViewValue = $this->CodRegion->lookupCacheOption($curVal);
            } else {
                $this->CodRegion->ViewValue = $this->CodRegion->Lookup !== null && is_array($this->CodRegion->Lookup->Options) ? $curVal : null;
            }
            if ($this->CodRegion->ViewValue !== null) { // Load from cache
                $this->CodRegion->EditValue = array_values($this->CodRegion->Lookup->Options);
                if ($this->CodRegion->ViewValue == "") {
                    $this->CodRegion->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`CodRegion`" . SearchString("=", $this->CodRegion->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->CodRegion->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CodRegion->Lookup->renderViewRow($rswrk[0]);
                    $this->CodRegion->ViewValue = $this->CodRegion->displayValue($arwrk);
                } else {
                    $this->CodRegion->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->CodRegion->EditValue = $arwrk;
            }
            $this->CodRegion->PlaceHolder = RemoveHtml($this->CodRegion->caption());

            // Vigente
            $this->Vigente->EditCustomAttributes = "";
            $this->Vigente->EditValue = $this->Vigente->options(false);
            $this->Vigente->PlaceHolder = RemoveHtml($this->Vigente->caption());

            // MinimoValidado
            $this->MinimoValidado->EditAttrs["class"] = "form-control";
            $this->MinimoValidado->EditCustomAttributes = "";
            $this->MinimoValidado->EditValue = HtmlEncode($this->MinimoValidado->CurrentValue);
            $this->MinimoValidado->PlaceHolder = RemoveHtml($this->MinimoValidado->caption());

            // tipo_transferencia
            $this->tipo_transferencia->EditAttrs["class"] = "form-control";
            $this->tipo_transferencia->EditCustomAttributes = "";
            $this->tipo_transferencia->EditValue = $this->tipo_transferencia->options(true);
            $this->tipo_transferencia->PlaceHolder = RemoveHtml($this->tipo_transferencia->caption());

            // Edit refer script

            // CodProveedor
            $this->CodProveedor->LinkCustomAttributes = "";
            $this->CodProveedor->HrefValue = "";

            // RazonSocial
            $this->RazonSocial->LinkCustomAttributes = "";
            $this->RazonSocial->HrefValue = "";

            // Propietario
            $this->Propietario->LinkCustomAttributes = "";
            $this->Propietario->HrefValue = "";

            // NIT
            $this->NIT->LinkCustomAttributes = "";
            $this->NIT->HrefValue = "";

            // Cedula
            $this->Cedula->LinkCustomAttributes = "";
            $this->Cedula->HrefValue = "";

            // Telefono
            $this->Telefono->LinkCustomAttributes = "";
            $this->Telefono->HrefValue = "";

            // Direccion
            $this->Direccion->LinkCustomAttributes = "";
            $this->Direccion->HrefValue = "";

            // CodRegion
            $this->CodRegion->LinkCustomAttributes = "";
            $this->CodRegion->HrefValue = "";

            // Vigente
            $this->Vigente->LinkCustomAttributes = "";
            $this->Vigente->HrefValue = "";

            // MinimoValidado
            $this->MinimoValidado->LinkCustomAttributes = "";
            $this->MinimoValidado->HrefValue = "";

            // tipo_transferencia
            $this->tipo_transferencia->LinkCustomAttributes = "";
            $this->tipo_transferencia->HrefValue = "";
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
        if ($this->CodProveedor->Required) {
            if (!$this->CodProveedor->IsDetailKey && EmptyValue($this->CodProveedor->FormValue)) {
                $this->CodProveedor->addErrorMessage(str_replace("%s", $this->CodProveedor->caption(), $this->CodProveedor->RequiredErrorMessage));
            }
        }
        if ($this->RazonSocial->Required) {
            if (!$this->RazonSocial->IsDetailKey && EmptyValue($this->RazonSocial->FormValue)) {
                $this->RazonSocial->addErrorMessage(str_replace("%s", $this->RazonSocial->caption(), $this->RazonSocial->RequiredErrorMessage));
            }
        }
        if ($this->Propietario->Required) {
            if (!$this->Propietario->IsDetailKey && EmptyValue($this->Propietario->FormValue)) {
                $this->Propietario->addErrorMessage(str_replace("%s", $this->Propietario->caption(), $this->Propietario->RequiredErrorMessage));
            }
        }
        if ($this->NIT->Required) {
            if (!$this->NIT->IsDetailKey && EmptyValue($this->NIT->FormValue)) {
                $this->NIT->addErrorMessage(str_replace("%s", $this->NIT->caption(), $this->NIT->RequiredErrorMessage));
            }
        }
        if ($this->Cedula->Required) {
            if (!$this->Cedula->IsDetailKey && EmptyValue($this->Cedula->FormValue)) {
                $this->Cedula->addErrorMessage(str_replace("%s", $this->Cedula->caption(), $this->Cedula->RequiredErrorMessage));
            }
        }
        if ($this->Telefono->Required) {
            if (!$this->Telefono->IsDetailKey && EmptyValue($this->Telefono->FormValue)) {
                $this->Telefono->addErrorMessage(str_replace("%s", $this->Telefono->caption(), $this->Telefono->RequiredErrorMessage));
            }
        }
        if ($this->Direccion->Required) {
            if (!$this->Direccion->IsDetailKey && EmptyValue($this->Direccion->FormValue)) {
                $this->Direccion->addErrorMessage(str_replace("%s", $this->Direccion->caption(), $this->Direccion->RequiredErrorMessage));
            }
        }
        if ($this->CodRegion->Required) {
            if (!$this->CodRegion->IsDetailKey && EmptyValue($this->CodRegion->FormValue)) {
                $this->CodRegion->addErrorMessage(str_replace("%s", $this->CodRegion->caption(), $this->CodRegion->RequiredErrorMessage));
            }
        }
        if ($this->Vigente->Required) {
            if ($this->Vigente->FormValue == "") {
                $this->Vigente->addErrorMessage(str_replace("%s", $this->Vigente->caption(), $this->Vigente->RequiredErrorMessage));
            }
        }
        if ($this->MinimoValidado->Required) {
            if (!$this->MinimoValidado->IsDetailKey && EmptyValue($this->MinimoValidado->FormValue)) {
                $this->MinimoValidado->addErrorMessage(str_replace("%s", $this->MinimoValidado->caption(), $this->MinimoValidado->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MinimoValidado->FormValue)) {
            $this->MinimoValidado->addErrorMessage($this->MinimoValidado->getErrorMessage(false));
        }
        if ($this->tipo_transferencia->Required) {
            if (!$this->tipo_transferencia->IsDetailKey && EmptyValue($this->tipo_transferencia->FormValue)) {
                $this->tipo_transferencia->addErrorMessage(str_replace("%s", $this->tipo_transferencia->caption(), $this->tipo_transferencia->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // RazonSocial
            $this->RazonSocial->setDbValueDef($rsnew, $this->RazonSocial->CurrentValue, "", $this->RazonSocial->ReadOnly);

            // Propietario
            $this->Propietario->setDbValueDef($rsnew, $this->Propietario->CurrentValue, "", $this->Propietario->ReadOnly);

            // NIT
            $this->NIT->setDbValueDef($rsnew, $this->NIT->CurrentValue, "", $this->NIT->ReadOnly);

            // Cedula
            $this->Cedula->setDbValueDef($rsnew, $this->Cedula->CurrentValue, "", $this->Cedula->ReadOnly);

            // Telefono
            $this->Telefono->setDbValueDef($rsnew, $this->Telefono->CurrentValue, "", $this->Telefono->ReadOnly);

            // Direccion
            $this->Direccion->setDbValueDef($rsnew, $this->Direccion->CurrentValue, "", $this->Direccion->ReadOnly);

            // CodRegion
            $this->CodRegion->setDbValueDef($rsnew, $this->CodRegion->CurrentValue, 0, $this->CodRegion->ReadOnly);

            // Vigente
            $tmpBool = $this->Vigente->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->Vigente->setDbValueDef($rsnew, $tmpBool, 0, $this->Vigente->ReadOnly);

            // MinimoValidado
            $this->MinimoValidado->setDbValueDef($rsnew, $this->MinimoValidado->CurrentValue, null, $this->MinimoValidado->ReadOnly);

            // tipo_transferencia
            $this->tipo_transferencia->setDbValueDef($rsnew, $this->tipo_transferencia->CurrentValue, null, $this->tipo_transferencia->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("proveedorlist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_CodRegion":
                    break;
                case "x_Vigente":
                    break;
                case "x_tipo_transferencia":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
