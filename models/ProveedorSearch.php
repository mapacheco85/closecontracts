<?php

namespace PHPMaker2021\CloseContracts;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ProveedorSearch extends Proveedor
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'proveedor';

    // Page object name
    public $PageObjName = "ProveedorSearch";

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
    public $FormClassName = "ew-horizontal ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "proveedorlist" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->CodProveedor); // CodProveedor
        $this->buildSearchUrl($srchUrl, $this->RazonSocial); // RazonSocial
        $this->buildSearchUrl($srchUrl, $this->Propietario); // Propietario
        $this->buildSearchUrl($srchUrl, $this->NIT); // NIT
        $this->buildSearchUrl($srchUrl, $this->Cedula); // Cedula
        $this->buildSearchUrl($srchUrl, $this->Telefono); // Telefono
        $this->buildSearchUrl($srchUrl, $this->Direccion); // Direccion
        $this->buildSearchUrl($srchUrl, $this->CodRegion); // CodRegion
        $this->buildSearchUrl($srchUrl, $this->Vigente, true); // Vigente
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;
        if ($this->CodProveedor->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->RazonSocial->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->Propietario->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->NIT->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->Cedula->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->Telefono->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->Direccion->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->CodRegion->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->Vigente->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if (is_array($this->Vigente->AdvancedSearch->SearchValue)) {
            $this->Vigente->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->Vigente->AdvancedSearch->SearchValue);
        }
        if (is_array($this->Vigente->AdvancedSearch->SearchValue2)) {
            $this->Vigente->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->Vigente->AdvancedSearch->SearchValue2);
        }
        return $hasValue;
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
            $curVal = strval($this->CodRegion->CurrentValue);
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
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // CodProveedor
            $this->CodProveedor->EditAttrs["class"] = "form-control";
            $this->CodProveedor->EditCustomAttributes = "";
            $this->CodProveedor->EditValue = HtmlEncode($this->CodProveedor->AdvancedSearch->SearchValue);
            $this->CodProveedor->PlaceHolder = RemoveHtml($this->CodProveedor->caption());

            // RazonSocial
            $this->RazonSocial->EditAttrs["class"] = "form-control";
            $this->RazonSocial->EditCustomAttributes = "";
            if (!$this->RazonSocial->Raw) {
                $this->RazonSocial->AdvancedSearch->SearchValue = HtmlDecode($this->RazonSocial->AdvancedSearch->SearchValue);
            }
            $this->RazonSocial->EditValue = HtmlEncode($this->RazonSocial->AdvancedSearch->SearchValue);
            $this->RazonSocial->PlaceHolder = RemoveHtml($this->RazonSocial->caption());

            // Propietario
            $this->Propietario->EditAttrs["class"] = "form-control";
            $this->Propietario->EditCustomAttributes = "";
            if (!$this->Propietario->Raw) {
                $this->Propietario->AdvancedSearch->SearchValue = HtmlDecode($this->Propietario->AdvancedSearch->SearchValue);
            }
            $this->Propietario->EditValue = HtmlEncode($this->Propietario->AdvancedSearch->SearchValue);
            $this->Propietario->PlaceHolder = RemoveHtml($this->Propietario->caption());

            // NIT
            $this->NIT->EditAttrs["class"] = "form-control";
            $this->NIT->EditCustomAttributes = "";
            if (!$this->NIT->Raw) {
                $this->NIT->AdvancedSearch->SearchValue = HtmlDecode($this->NIT->AdvancedSearch->SearchValue);
            }
            $this->NIT->EditValue = HtmlEncode($this->NIT->AdvancedSearch->SearchValue);
            $this->NIT->PlaceHolder = RemoveHtml($this->NIT->caption());

            // Cedula
            $this->Cedula->EditAttrs["class"] = "form-control";
            $this->Cedula->EditCustomAttributes = "";
            if (!$this->Cedula->Raw) {
                $this->Cedula->AdvancedSearch->SearchValue = HtmlDecode($this->Cedula->AdvancedSearch->SearchValue);
            }
            $this->Cedula->EditValue = HtmlEncode($this->Cedula->AdvancedSearch->SearchValue);
            $this->Cedula->PlaceHolder = RemoveHtml($this->Cedula->caption());

            // Telefono
            $this->Telefono->EditAttrs["class"] = "form-control";
            $this->Telefono->EditCustomAttributes = "";
            if (!$this->Telefono->Raw) {
                $this->Telefono->AdvancedSearch->SearchValue = HtmlDecode($this->Telefono->AdvancedSearch->SearchValue);
            }
            $this->Telefono->EditValue = HtmlEncode($this->Telefono->AdvancedSearch->SearchValue);
            $this->Telefono->PlaceHolder = RemoveHtml($this->Telefono->caption());

            // Direccion
            $this->Direccion->EditAttrs["class"] = "form-control";
            $this->Direccion->EditCustomAttributes = "";
            if (!$this->Direccion->Raw) {
                $this->Direccion->AdvancedSearch->SearchValue = HtmlDecode($this->Direccion->AdvancedSearch->SearchValue);
            }
            $this->Direccion->EditValue = HtmlEncode($this->Direccion->AdvancedSearch->SearchValue);
            $this->Direccion->PlaceHolder = RemoveHtml($this->Direccion->caption());

            // CodRegion
            $this->CodRegion->EditAttrs["class"] = "form-control";
            $this->CodRegion->EditCustomAttributes = "";
            $curVal = trim(strval($this->CodRegion->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->CodRegion->AdvancedSearch->ViewValue = $this->CodRegion->lookupCacheOption($curVal);
            } else {
                $this->CodRegion->AdvancedSearch->ViewValue = $this->CodRegion->Lookup !== null && is_array($this->CodRegion->Lookup->Options) ? $curVal : null;
            }
            if ($this->CodRegion->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->CodRegion->EditValue = array_values($this->CodRegion->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`CodRegion`" . SearchString("=", $this->CodRegion->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->CodRegion->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->CodRegion->EditValue = $arwrk;
            }
            $this->CodRegion->PlaceHolder = RemoveHtml($this->CodRegion->caption());

            // Vigente
            $this->Vigente->EditCustomAttributes = "";
            $this->Vigente->EditValue = $this->Vigente->options(false);
            $this->Vigente->PlaceHolder = RemoveHtml($this->Vigente->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->CodProveedor->AdvancedSearch->SearchValue)) {
            $this->CodProveedor->addErrorMessage($this->CodProveedor->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->CodProveedor->AdvancedSearch->load();
        $this->RazonSocial->AdvancedSearch->load();
        $this->Propietario->AdvancedSearch->load();
        $this->NIT->AdvancedSearch->load();
        $this->Cedula->AdvancedSearch->load();
        $this->Telefono->AdvancedSearch->load();
        $this->Direccion->AdvancedSearch->load();
        $this->CodRegion->AdvancedSearch->load();
        $this->Vigente->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("proveedorlist"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
