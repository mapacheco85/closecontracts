<?php

namespace PHPMaker2021\CloseContracts;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for proveedor
 */
class Proveedor extends DbTable
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
    public $CodProveedor;
    public $RazonSocial;
    public $Propietario;
    public $NIT;
    public $Cedula;
    public $Telefono;
    public $Direccion;
    public $CodRegion;
    public $Vigente;
    public $MinimoValidado;
    public $tipo_transferencia;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'proveedor';
        $this->TableName = 'proveedor';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`proveedor`";
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

        // CodProveedor
        $this->CodProveedor = new DbField('proveedor', 'proveedor', 'x_CodProveedor', 'CodProveedor', '`CodProveedor`', '`CodProveedor`', 3, 11, -1, false, '`CodProveedor`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->CodProveedor->IsAutoIncrement = true; // Autoincrement field
        $this->CodProveedor->IsPrimaryKey = true; // Primary key field
        $this->CodProveedor->Sortable = true; // Allow sort
        $this->CodProveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CodProveedor->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CodProveedor->Param, "CustomMsg");
        $this->Fields['CodProveedor'] = &$this->CodProveedor;

        // RazonSocial
        $this->RazonSocial = new DbField('proveedor', 'proveedor', 'x_RazonSocial', 'RazonSocial', '`RazonSocial`', '`RazonSocial`', 200, 255, -1, false, '`RazonSocial`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RazonSocial->Nullable = false; // NOT NULL field
        $this->RazonSocial->Required = true; // Required field
        $this->RazonSocial->Sortable = true; // Allow sort
        $this->RazonSocial->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RazonSocial->Param, "CustomMsg");
        $this->Fields['RazonSocial'] = &$this->RazonSocial;

        // Propietario
        $this->Propietario = new DbField('proveedor', 'proveedor', 'x_Propietario', 'Propietario', '`Propietario`', '`Propietario`', 200, 255, -1, false, '`Propietario`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Propietario->Nullable = false; // NOT NULL field
        $this->Propietario->Required = true; // Required field
        $this->Propietario->Sortable = true; // Allow sort
        $this->Propietario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Propietario->Param, "CustomMsg");
        $this->Fields['Propietario'] = &$this->Propietario;

        // NIT
        $this->NIT = new DbField('proveedor', 'proveedor', 'x_NIT', 'NIT', '`NIT`', '`NIT`', 200, 30, -1, false, '`NIT`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NIT->Nullable = false; // NOT NULL field
        $this->NIT->Required = true; // Required field
        $this->NIT->Sortable = true; // Allow sort
        $this->NIT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NIT->Param, "CustomMsg");
        $this->Fields['NIT'] = &$this->NIT;

        // Cedula
        $this->Cedula = new DbField('proveedor', 'proveedor', 'x_Cedula', 'Cedula', '`Cedula`', '`Cedula`', 200, 30, -1, false, '`Cedula`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Cedula->Nullable = false; // NOT NULL field
        $this->Cedula->Required = true; // Required field
        $this->Cedula->Sortable = true; // Allow sort
        $this->Cedula->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Cedula->Param, "CustomMsg");
        $this->Fields['Cedula'] = &$this->Cedula;

        // Telefono
        $this->Telefono = new DbField('proveedor', 'proveedor', 'x_Telefono', 'Telefono', '`Telefono`', '`Telefono`', 200, 30, -1, false, '`Telefono`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Telefono->Nullable = false; // NOT NULL field
        $this->Telefono->Required = true; // Required field
        $this->Telefono->Sortable = true; // Allow sort
        $this->Telefono->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Telefono->Param, "CustomMsg");
        $this->Fields['Telefono'] = &$this->Telefono;

        // Direccion
        $this->Direccion = new DbField('proveedor', 'proveedor', 'x_Direccion', 'Direccion', '`Direccion`', '`Direccion`', 200, 255, -1, false, '`Direccion`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Direccion->Nullable = false; // NOT NULL field
        $this->Direccion->Required = true; // Required field
        $this->Direccion->Sortable = true; // Allow sort
        $this->Direccion->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Direccion->Param, "CustomMsg");
        $this->Fields['Direccion'] = &$this->Direccion;

        // CodRegion
        $this->CodRegion = new DbField('proveedor', 'proveedor', 'x_CodRegion', 'CodRegion', '`CodRegion`', '`CodRegion`', 3, 11, -1, false, '`CodRegion`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CodRegion->Nullable = false; // NOT NULL field
        $this->CodRegion->Required = true; // Required field
        $this->CodRegion->Sortable = true; // Allow sort
        $this->CodRegion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CodRegion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CodRegion->Lookup = new Lookup('CodRegion', 'region', true, 'CodRegion', ["Descripcion","","",""], [], [], [], [], [], [], '`Descripcion` ASC', '');
                break;
            default:
                $this->CodRegion->Lookup = new Lookup('CodRegion', 'region', true, 'CodRegion', ["Descripcion","","",""], [], [], [], [], [], [], '`Descripcion` ASC', '');
                break;
        }
        $this->CodRegion->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CodRegion->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CodRegion->Param, "CustomMsg");
        $this->Fields['CodRegion'] = &$this->CodRegion;

        // Vigente
        $this->Vigente = new DbField('proveedor', 'proveedor', 'x_Vigente', 'Vigente', '`Vigente`', '`Vigente`', 3, 1, -1, false, '`Vigente`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->Vigente->Nullable = false; // NOT NULL field
        $this->Vigente->Required = true; // Required field
        $this->Vigente->Sortable = true; // Allow sort
        $this->Vigente->DataType = DATATYPE_BIT;
        switch ($CurrentLanguage) {
            case "en":
                $this->Vigente->Lookup = new Lookup('Vigente', 'proveedor', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->Vigente->Lookup = new Lookup('Vigente', 'proveedor', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->Vigente->OptionCount = 2;
        $this->Vigente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Vigente->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Vigente->Param, "CustomMsg");
        $this->Fields['Vigente'] = &$this->Vigente;

        // MinimoValidado
        $this->MinimoValidado = new DbField('proveedor', 'proveedor', 'x_MinimoValidado', 'MinimoValidado', '`MinimoValidado`', '`MinimoValidado`', 3, 11, -1, false, '`MinimoValidado`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MinimoValidado->Sortable = true; // Allow sort
        $this->MinimoValidado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MinimoValidado->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MinimoValidado->Param, "CustomMsg");
        $this->Fields['MinimoValidado'] = &$this->MinimoValidado;

        // tipo_transferencia
        $this->tipo_transferencia = new DbField('proveedor', 'proveedor', 'x_tipo_transferencia', 'tipo_transferencia', '`tipo_transferencia`', '`tipo_transferencia`', 202, 22, -1, false, '`tipo_transferencia`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->tipo_transferencia->Sortable = true; // Allow sort
        $this->tipo_transferencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_transferencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->tipo_transferencia->Lookup = new Lookup('tipo_transferencia', 'proveedor', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->tipo_transferencia->Lookup = new Lookup('tipo_transferencia', 'proveedor', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->tipo_transferencia->OptionCount = 2;
        $this->tipo_transferencia->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tipo_transferencia->Param, "CustomMsg");
        $this->Fields['tipo_transferencia'] = &$this->tipo_transferencia;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`proveedor`";
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
            $this->CodProveedor->setDbValue($conn->lastInsertId());
            $rs['CodProveedor'] = $this->CodProveedor->DbValue;
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
            if (array_key_exists('CodProveedor', $rs)) {
                AddFilter($where, QuotedName('CodProveedor', $this->Dbid) . '=' . QuotedValue($rs['CodProveedor'], $this->CodProveedor->DataType, $this->Dbid));
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
        $this->CodProveedor->DbValue = $row['CodProveedor'];
        $this->RazonSocial->DbValue = $row['RazonSocial'];
        $this->Propietario->DbValue = $row['Propietario'];
        $this->NIT->DbValue = $row['NIT'];
        $this->Cedula->DbValue = $row['Cedula'];
        $this->Telefono->DbValue = $row['Telefono'];
        $this->Direccion->DbValue = $row['Direccion'];
        $this->CodRegion->DbValue = $row['CodRegion'];
        $this->Vigente->DbValue = $row['Vigente'];
        $this->MinimoValidado->DbValue = $row['MinimoValidado'];
        $this->tipo_transferencia->DbValue = $row['tipo_transferencia'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`CodProveedor` = @CodProveedor@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->CodProveedor->CurrentValue : $this->CodProveedor->OldValue;
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
                $this->CodProveedor->CurrentValue = $keys[0];
            } else {
                $this->CodProveedor->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('CodProveedor', $row) ? $row['CodProveedor'] : null;
        } else {
            $val = $this->CodProveedor->OldValue !== null ? $this->CodProveedor->OldValue : $this->CodProveedor->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@CodProveedor@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("proveedorlist");
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
        if ($pageName == "proveedorview") {
            return $Language->phrase("View");
        } elseif ($pageName == "proveedoredit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "proveedoradd") {
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
                return "ProveedorView";
            case Config("API_ADD_ACTION"):
                return "ProveedorAdd";
            case Config("API_EDIT_ACTION"):
                return "ProveedorEdit";
            case Config("API_DELETE_ACTION"):
                return "ProveedorDelete";
            case Config("API_LIST_ACTION"):
                return "ProveedorList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "proveedorlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("proveedorview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("proveedorview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "proveedoradd?" . $this->getUrlParm($parm);
        } else {
            $url = "proveedoradd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("proveedoredit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("proveedoradd", $this->getUrlParm($parm));
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
        return $this->keyUrl("proveedordelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "CodProveedor:" . JsonEncode($this->CodProveedor->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->CodProveedor->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->CodProveedor->CurrentValue);
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
            if (($keyValue = Param("CodProveedor") ?? Route("CodProveedor")) !== null) {
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
                $this->CodProveedor->CurrentValue = $key;
            } else {
                $this->CodProveedor->OldValue = $key;
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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
        $this->RazonSocial->EditValue = $this->RazonSocial->CurrentValue;
        $this->RazonSocial->PlaceHolder = RemoveHtml($this->RazonSocial->caption());

        // Propietario
        $this->Propietario->EditAttrs["class"] = "form-control";
        $this->Propietario->EditCustomAttributes = "";
        if (!$this->Propietario->Raw) {
            $this->Propietario->CurrentValue = HtmlDecode($this->Propietario->CurrentValue);
        }
        $this->Propietario->EditValue = $this->Propietario->CurrentValue;
        $this->Propietario->PlaceHolder = RemoveHtml($this->Propietario->caption());

        // NIT
        $this->NIT->EditAttrs["class"] = "form-control";
        $this->NIT->EditCustomAttributes = "";
        if (!$this->NIT->Raw) {
            $this->NIT->CurrentValue = HtmlDecode($this->NIT->CurrentValue);
        }
        $this->NIT->EditValue = $this->NIT->CurrentValue;
        $this->NIT->PlaceHolder = RemoveHtml($this->NIT->caption());

        // Cedula
        $this->Cedula->EditAttrs["class"] = "form-control";
        $this->Cedula->EditCustomAttributes = "";
        if (!$this->Cedula->Raw) {
            $this->Cedula->CurrentValue = HtmlDecode($this->Cedula->CurrentValue);
        }
        $this->Cedula->EditValue = $this->Cedula->CurrentValue;
        $this->Cedula->PlaceHolder = RemoveHtml($this->Cedula->caption());

        // Telefono
        $this->Telefono->EditAttrs["class"] = "form-control";
        $this->Telefono->EditCustomAttributes = "";
        if (!$this->Telefono->Raw) {
            $this->Telefono->CurrentValue = HtmlDecode($this->Telefono->CurrentValue);
        }
        $this->Telefono->EditValue = $this->Telefono->CurrentValue;
        $this->Telefono->PlaceHolder = RemoveHtml($this->Telefono->caption());

        // Direccion
        $this->Direccion->EditAttrs["class"] = "form-control";
        $this->Direccion->EditCustomAttributes = "";
        if (!$this->Direccion->Raw) {
            $this->Direccion->CurrentValue = HtmlDecode($this->Direccion->CurrentValue);
        }
        $this->Direccion->EditValue = $this->Direccion->CurrentValue;
        $this->Direccion->PlaceHolder = RemoveHtml($this->Direccion->caption());

        // CodRegion
        $this->CodRegion->EditAttrs["class"] = "form-control";
        $this->CodRegion->EditCustomAttributes = "";
        $this->CodRegion->PlaceHolder = RemoveHtml($this->CodRegion->caption());

        // Vigente
        $this->Vigente->EditCustomAttributes = "";
        $this->Vigente->EditValue = $this->Vigente->options(false);
        $this->Vigente->PlaceHolder = RemoveHtml($this->Vigente->caption());

        // MinimoValidado
        $this->MinimoValidado->EditAttrs["class"] = "form-control";
        $this->MinimoValidado->EditCustomAttributes = "";
        $this->MinimoValidado->EditValue = $this->MinimoValidado->CurrentValue;
        $this->MinimoValidado->PlaceHolder = RemoveHtml($this->MinimoValidado->caption());

        // tipo_transferencia
        $this->tipo_transferencia->EditAttrs["class"] = "form-control";
        $this->tipo_transferencia->EditCustomAttributes = "";
        $this->tipo_transferencia->EditValue = $this->tipo_transferencia->options(true);
        $this->tipo_transferencia->PlaceHolder = RemoveHtml($this->tipo_transferencia->caption());

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
                    $doc->exportCaption($this->CodProveedor);
                    $doc->exportCaption($this->RazonSocial);
                    $doc->exportCaption($this->Propietario);
                    $doc->exportCaption($this->NIT);
                    $doc->exportCaption($this->Cedula);
                    $doc->exportCaption($this->Telefono);
                    $doc->exportCaption($this->Direccion);
                    $doc->exportCaption($this->CodRegion);
                    $doc->exportCaption($this->Vigente);
                    $doc->exportCaption($this->MinimoValidado);
                    $doc->exportCaption($this->tipo_transferencia);
                } else {
                    $doc->exportCaption($this->CodProveedor);
                    $doc->exportCaption($this->RazonSocial);
                    $doc->exportCaption($this->Propietario);
                    $doc->exportCaption($this->NIT);
                    $doc->exportCaption($this->Cedula);
                    $doc->exportCaption($this->Telefono);
                    $doc->exportCaption($this->Direccion);
                    $doc->exportCaption($this->CodRegion);
                    $doc->exportCaption($this->Vigente);
                    $doc->exportCaption($this->MinimoValidado);
                    $doc->exportCaption($this->tipo_transferencia);
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
                        $doc->exportField($this->CodProveedor);
                        $doc->exportField($this->RazonSocial);
                        $doc->exportField($this->Propietario);
                        $doc->exportField($this->NIT);
                        $doc->exportField($this->Cedula);
                        $doc->exportField($this->Telefono);
                        $doc->exportField($this->Direccion);
                        $doc->exportField($this->CodRegion);
                        $doc->exportField($this->Vigente);
                        $doc->exportField($this->MinimoValidado);
                        $doc->exportField($this->tipo_transferencia);
                    } else {
                        $doc->exportField($this->CodProveedor);
                        $doc->exportField($this->RazonSocial);
                        $doc->exportField($this->Propietario);
                        $doc->exportField($this->NIT);
                        $doc->exportField($this->Cedula);
                        $doc->exportField($this->Telefono);
                        $doc->exportField($this->Direccion);
                        $doc->exportField($this->CodRegion);
                        $doc->exportField($this->Vigente);
                        $doc->exportField($this->MinimoValidado);
                        $doc->exportField($this->tipo_transferencia);
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
        // No binary fields
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
