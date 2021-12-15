<?php

namespace PHPMaker2021\CloseContracts;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for contrato
 */
class Contrato extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $CodContrato;
    public $Fecha;
    public $Lugar;
    public $Vencimiento;
    public $CodigoInterno;
    public $MotivoBaja;
    public $Vigente;
    public $CodServicio;
    public $CodProveedor;
    public $Monto;
    public $Archivo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'contrato';
        $this->TableName = 'contrato';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`contrato`";
        $this->Dbid = 'DB';
        $this->ExportAll = false;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // CodContrato
        $this->CodContrato = new DbField('contrato', 'contrato', 'x_CodContrato', 'CodContrato', '`CodContrato`', '`CodContrato`', 3, 11, -1, false, '`CodContrato`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->CodContrato->IsAutoIncrement = true; // Autoincrement field
        $this->CodContrato->IsPrimaryKey = true; // Primary key field
        $this->CodContrato->Sortable = true; // Allow sort
        $this->CodContrato->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CodContrato->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CodContrato->Param, "CustomMsg");
        $this->Fields['CodContrato'] = &$this->CodContrato;

        // Fecha
        $this->Fecha = new DbField('contrato', 'contrato', 'x_Fecha', 'Fecha', '`Fecha`', CastDateFieldForLike("`Fecha`", 0, "DB"), 133, 10, 0, false, '`Fecha`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Fecha->Nullable = false; // NOT NULL field
        $this->Fecha->Required = true; // Required field
        $this->Fecha->Sortable = true; // Allow sort
        $this->Fecha->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fecha->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Fecha->Param, "CustomMsg");
        $this->Fields['Fecha'] = &$this->Fecha;

        // Lugar
        $this->Lugar = new DbField('contrato', 'contrato', 'x_Lugar', 'Lugar', '`Lugar`', '`Lugar`', 200, 20, -1, false, '`Lugar`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Lugar->Nullable = false; // NOT NULL field
        $this->Lugar->Required = true; // Required field
        $this->Lugar->Sortable = true; // Allow sort
        $this->Lugar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Lugar->Param, "CustomMsg");
        $this->Fields['Lugar'] = &$this->Lugar;

        // Vencimiento
        $this->Vencimiento = new DbField('contrato', 'contrato', 'x_Vencimiento', 'Vencimiento', '`Vencimiento`', CastDateFieldForLike("`Vencimiento`", 0, "DB"), 133, 10, 0, false, '`Vencimiento`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Vencimiento->Nullable = false; // NOT NULL field
        $this->Vencimiento->Required = true; // Required field
        $this->Vencimiento->Sortable = true; // Allow sort
        $this->Vencimiento->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Vencimiento->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Vencimiento->Param, "CustomMsg");
        $this->Fields['Vencimiento'] = &$this->Vencimiento;

        // CodigoInterno
        $this->CodigoInterno = new DbField('contrato', 'contrato', 'x_CodigoInterno', 'CodigoInterno', '`CodigoInterno`', '`CodigoInterno`', 200, 20, -1, false, '`CodigoInterno`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->CodigoInterno->Nullable = false; // NOT NULL field
        $this->CodigoInterno->Sortable = true; // Allow sort
        $this->CodigoInterno->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CodigoInterno->Param, "CustomMsg");
        $this->Fields['CodigoInterno'] = &$this->CodigoInterno;

        // MotivoBaja
        $this->MotivoBaja = new DbField('contrato', 'contrato', 'x_MotivoBaja', 'MotivoBaja', '`MotivoBaja`', '`MotivoBaja`', 200, 20, -1, false, '`MotivoBaja`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->MotivoBaja->Sortable = true; // Allow sort
        $this->MotivoBaja->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->MotivoBaja->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->MotivoBaja->Lookup = new Lookup('MotivoBaja', 'contrato', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->MotivoBaja->Lookup = new Lookup('MotivoBaja', 'contrato', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->MotivoBaja->OptionCount = 3;
        $this->MotivoBaja->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MotivoBaja->Param, "CustomMsg");
        $this->Fields['MotivoBaja'] = &$this->MotivoBaja;

        // Vigente
        $this->Vigente = new DbField('contrato', 'contrato', 'x_Vigente', 'Vigente', '`Vigente`', '`Vigente`', 3, 1, -1, false, '`Vigente`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->Vigente->Sortable = true; // Allow sort
        $this->Vigente->DataType = DATATYPE_BIT;
        switch ($CurrentLanguage) {
            case "en":
                $this->Vigente->Lookup = new Lookup('Vigente', 'contrato', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->Vigente->Lookup = new Lookup('Vigente', 'contrato', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->Vigente->OptionCount = 2;
        $this->Vigente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Vigente->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Vigente->Param, "CustomMsg");
        $this->Fields['Vigente'] = &$this->Vigente;

        // CodServicio
        $this->CodServicio = new DbField('contrato', 'contrato', 'x_CodServicio', 'CodServicio', '`CodServicio`', '`CodServicio`', 3, 11, -1, false, '`CodServicio`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CodServicio->Required = true; // Required field
        $this->CodServicio->Sortable = true; // Allow sort
        $this->CodServicio->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CodServicio->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CodServicio->Lookup = new Lookup('CodServicio', 'servicio', false, 'CodServicio', ["Sigla","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CodServicio->Lookup = new Lookup('CodServicio', 'servicio', false, 'CodServicio', ["Sigla","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CodServicio->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CodServicio->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CodServicio->Param, "CustomMsg");
        $this->Fields['CodServicio'] = &$this->CodServicio;

        // CodProveedor
        $this->CodProveedor = new DbField('contrato', 'contrato', 'x_CodProveedor', 'CodProveedor', '`CodProveedor`', '`CodProveedor`', 3, 11, -1, false, '`CodProveedor`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CodProveedor->Sortable = true; // Allow sort
        $this->CodProveedor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CodProveedor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CodProveedor->Lookup = new Lookup('CodProveedor', 'proveedor', false, 'CodProveedor', ["Propietario","","",""], [], [], [], [], [], [], '`Propietario` ASC', '');
                break;
            default:
                $this->CodProveedor->Lookup = new Lookup('CodProveedor', 'proveedor', false, 'CodProveedor', ["Propietario","","",""], [], [], [], [], [], [], '`Propietario` ASC', '');
                break;
        }
        $this->CodProveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CodProveedor->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CodProveedor->Param, "CustomMsg");
        $this->Fields['CodProveedor'] = &$this->CodProveedor;

        // Monto
        $this->Monto = new DbField('contrato', 'contrato', 'x_Monto', 'Monto', '`Monto`', '`Monto`', 131, 7, -1, false, '`Monto`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Monto->Nullable = false; // NOT NULL field
        $this->Monto->Required = true; // Required field
        $this->Monto->Sortable = true; // Allow sort
        $this->Monto->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->Monto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Monto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Monto->Param, "CustomMsg");
        $this->Fields['Monto'] = &$this->Monto;

        // Archivo
        $this->Archivo = new DbField('contrato', 'contrato', 'x_Archivo', 'Archivo', '`Archivo`', '`Archivo`', 205, 0, -1, true, '`Archivo`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->Archivo->Sortable = true; // Allow sort
        $this->Archivo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Archivo->Param, "CustomMsg");
        $this->Fields['Archivo'] = &$this->Archivo;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`contrato`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->CodContrato->setDbValue($conn->lastInsertId());
            $rs['CodContrato'] = $this->CodContrato->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('CodContrato', $rs)) {
                AddFilter($where, QuotedName('CodContrato', $this->Dbid) . '=' . QuotedValue($rs['CodContrato'], $this->CodContrato->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->CodContrato->DbValue = $row['CodContrato'];
        $this->Fecha->DbValue = $row['Fecha'];
        $this->Lugar->DbValue = $row['Lugar'];
        $this->Vencimiento->DbValue = $row['Vencimiento'];
        $this->CodigoInterno->DbValue = $row['CodigoInterno'];
        $this->MotivoBaja->DbValue = $row['MotivoBaja'];
        $this->Vigente->DbValue = $row['Vigente'];
        $this->CodServicio->DbValue = $row['CodServicio'];
        $this->CodProveedor->DbValue = $row['CodProveedor'];
        $this->Monto->DbValue = $row['Monto'];
        $this->Archivo->Upload->DbValue = $row['Archivo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`CodContrato` = @CodContrato@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->CodContrato->CurrentValue : $this->CodContrato->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->CodContrato->CurrentValue = $keys[0];
            } else {
                $this->CodContrato->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('CodContrato', $row) ? $row['CodContrato'] : null;
        } else {
            $val = $this->CodContrato->OldValue !== null ? $this->CodContrato->OldValue : $this->CodContrato->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@CodContrato@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("contratolist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "contratoview") {
            return $Language->phrase("View");
        } elseif ($pageName == "contratoedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "contratoadd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "ContratoView";
            case Config("API_ADD_ACTION"):
                return "ContratoAdd";
            case Config("API_EDIT_ACTION"):
                return "ContratoEdit";
            case Config("API_DELETE_ACTION"):
                return "ContratoDelete";
            case Config("API_LIST_ACTION"):
                return "ContratoList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "contratolist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("contratoview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("contratoview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "contratoadd?" . $this->getUrlParm($parm);
        } else {
            $url = "contratoadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("contratoedit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("contratoadd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("contratodelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "CodContrato:" . JsonEncode($this->CodContrato->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->CodContrato->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->CodContrato->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("CodContrato") ?? Route("CodContrato")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->CodContrato->CurrentValue = $key;
            } else {
                $this->CodContrato->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // CodContrato
        $this->CodContrato->LinkCustomAttributes = "";
        $this->CodContrato->HrefValue = "";
        $this->CodContrato->TooltipValue = "";

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

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // CodContrato
        $this->CodContrato->EditAttrs["class"] = "form-control";
        $this->CodContrato->EditCustomAttributes = "";
        $this->CodContrato->EditValue = $this->CodContrato->CurrentValue;
        $this->CodContrato->EditValue = FormatNumber($this->CodContrato->EditValue, 0, -2, -2, -2);
        $this->CodContrato->ViewCustomAttributes = "";

        // Fecha
        $this->Fecha->EditAttrs["class"] = "form-control";
        $this->Fecha->EditCustomAttributes = "";
        $this->Fecha->EditValue = FormatDateTime($this->Fecha->CurrentValue, 8);
        $this->Fecha->PlaceHolder = RemoveHtml($this->Fecha->caption());

        // Lugar
        $this->Lugar->EditAttrs["class"] = "form-control";
        $this->Lugar->EditCustomAttributes = "";
        if (!$this->Lugar->Raw) {
            $this->Lugar->CurrentValue = HtmlDecode($this->Lugar->CurrentValue);
        }
        $this->Lugar->EditValue = $this->Lugar->CurrentValue;
        $this->Lugar->PlaceHolder = RemoveHtml($this->Lugar->caption());

        // Vencimiento
        $this->Vencimiento->EditAttrs["class"] = "form-control";
        $this->Vencimiento->EditCustomAttributes = "";
        $this->Vencimiento->EditValue = FormatDateTime($this->Vencimiento->CurrentValue, 8);
        $this->Vencimiento->PlaceHolder = RemoveHtml($this->Vencimiento->caption());

        // CodigoInterno
        $this->CodigoInterno->EditAttrs["class"] = "form-control";
        $this->CodigoInterno->EditCustomAttributes = "";
        $this->CodigoInterno->CurrentValue = 0;

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
        $this->CodServicio->EditAttrs["class"] = "form-control";
        $this->CodServicio->EditCustomAttributes = "";
        $this->CodServicio->PlaceHolder = RemoveHtml($this->CodServicio->caption());

        // CodProveedor
        $this->CodProveedor->EditAttrs["class"] = "form-control";
        $this->CodProveedor->EditCustomAttributes = "";
        $this->CodProveedor->PlaceHolder = RemoveHtml($this->CodProveedor->caption());

        // Monto
        $this->Monto->EditAttrs["class"] = "form-control";
        $this->Monto->EditCustomAttributes = "";
        $this->Monto->EditValue = $this->Monto->CurrentValue;
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

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->CodContrato);
                    $doc->exportCaption($this->Fecha);
                    $doc->exportCaption($this->Lugar);
                    $doc->exportCaption($this->Vencimiento);
                    $doc->exportCaption($this->CodigoInterno);
                    $doc->exportCaption($this->MotivoBaja);
                    $doc->exportCaption($this->Vigente);
                    $doc->exportCaption($this->CodServicio);
                    $doc->exportCaption($this->CodProveedor);
                    $doc->exportCaption($this->Monto);
                    $doc->exportCaption($this->Archivo);
                } else {
                    $doc->exportCaption($this->CodContrato);
                    $doc->exportCaption($this->Fecha);
                    $doc->exportCaption($this->Lugar);
                    $doc->exportCaption($this->Vencimiento);
                    $doc->exportCaption($this->CodigoInterno);
                    $doc->exportCaption($this->MotivoBaja);
                    $doc->exportCaption($this->Vigente);
                    $doc->exportCaption($this->CodServicio);
                    $doc->exportCaption($this->CodProveedor);
                    $doc->exportCaption($this->Monto);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->CodContrato);
                        $doc->exportField($this->Fecha);
                        $doc->exportField($this->Lugar);
                        $doc->exportField($this->Vencimiento);
                        $doc->exportField($this->CodigoInterno);
                        $doc->exportField($this->MotivoBaja);
                        $doc->exportField($this->Vigente);
                        $doc->exportField($this->CodServicio);
                        $doc->exportField($this->CodProveedor);
                        $doc->exportField($this->Monto);
                        $doc->exportField($this->Archivo);
                    } else {
                        $doc->exportField($this->CodContrato);
                        $doc->exportField($this->Fecha);
                        $doc->exportField($this->Lugar);
                        $doc->exportField($this->Vencimiento);
                        $doc->exportField($this->CodigoInterno);
                        $doc->exportField($this->MotivoBaja);
                        $doc->exportField($this->Vigente);
                        $doc->exportField($this->CodServicio);
                        $doc->exportField($this->CodProveedor);
                        $doc->exportField($this->Monto);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'Archivo') {
            $fldName = "Archivo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->CodContrato->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
