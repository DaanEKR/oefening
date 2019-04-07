<?php

class clsHeader
{
    private $columns;

    public function __construct()
    {
        $this->columns = array();
    }

    public function addColumn($column)
    {
        $this->columns[] = $column;
    }

    public function getColumns()
    {
        return $this->columns;
    }

}

class clsColumn
{
    private $fieldName;
    private $fieldCaption;
    private $edittype; /* Bootstrap input types: Text, Search, Email, URL, Telephone
                                                  Password, Number, Date and time,
                                                  Date, Month, Week, Time*/
    private $lookupsql;
    private $readonly;

    public function __construct()
    {
        $this->edittype = "Text";
        $this->readonly = false;
        $this->lookupsql = false;
    }

    public function getCaption()
    {
        return $this->fieldCaption;
    }

    public function setCaption($caption)
    {
        $this->fieldCaption = $caption;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }
    public function setFieldName($fieldname)
    {
        $this->fieldName = $fieldname;
    }

    public function getEditType()
    {
        return $this->edittype;
    }

    public function setEditType($edittype)
    {
        $this->edittype = $edittype;
    }

    public function getLookUpSql()
    {
        return $this->lookupsql;
    }

    public function setLookUpSql($lusql)
    {
        $this->lookupsql = $lusql;
    }

    public function getReadOnly()
    {
        return $this->readonly;
    }

    public function setReadOnly()
    {
        $this->readonly = true;
    }

}

class clsTableDef
{
    protected $connection;
    protected $header;
    protected $body;
    protected $tablename;
    protected $selectsql;
    protected $key;
    protected $keyvalue;
    protected $soort;

    public function __construct()
    {
        $this->connection = database::connect();
        $this->header = new clsHeader();
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getSelectSql()
    {
        return $this->selectsql;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getKeyValue()
    {
        return $this->keyvalue;
    }

    public function setKeyValue($value)
    {
        $this->keyvalue = $value;
    }

    public function getTableName()
    {
        return $this->tablename;
    }

    public function setSoort($soort)
    {
        $this->soort = $soort;
    }

    private function makeSelect($value, $name, $column)
    {
        $output =
            "<select class='selectpicker form-control' 
                        id='" . $name . "'  
                        name='" . $name . "'>";

        foreach($this->connection->query($column->getLookUpSql()) as $row)
        {    $output .= "
                     <option value = '" . $row['lookup_id'] . "' ";
            if ($row['lookup_id'] == $value)
            {    $output .= "
                             selected='selected' ";
            }
            $output .= "
                     <option>" . $row['lookupresult'] . "</option>";
        }
        $output .=
            "</select>";
        return $output;
    }

    private function makeInput($value, $name, $column)
    {    $readonly = false;
        $readonlyclass = " form-control-plaintext";
        if (!$column->getReadOnly())
        {    $readonly = "";
            $readonlyclass = "";
        }

        return "<input type='" . $column->getEditType() . "' 
                         class='form-control$readonlyclass'
                         $readonly 
                         value='" . $value . "'  
                         id='" . $name . "'  
                         name='" . $name . "'>";
    }

    private function makeFormControlSet($column, $row = false)
    {    $fieldname = $column->getFieldName();
        if (!$row)
        {    $value = "";
        }
        else
        {    $value = $row[$fieldname];
        }
        $name = $fieldname . "_id";
        $fieldcaption = $column->getCaption();

        $output =
            "<div class='form-group'>
                    <label for='" . $name . "'>" . $fieldcaption . "
                    </label>";

        $edittype = $column->getedittype();
        switch($edittype)
        {
            case "Text":
            case "Search":
            case "Email":
            case "URL":
            case "Telephone":
            case "Password":
            case "Number":
            case "Date and time":
            case "Date":
            case "Month":
            case "Week":
            case "Time":
                $output .= $this->makeInput($value, $name, $column);
                break;
            case "Select":
                $output .= $this->makeSelect($value, $name, $column);
                break;
        }
        $output .=
            "</div>";

        return $output;
    }

    private function makeSaveDialog()
    {  return  "
          <div class='row'>
               <div class='help-block'>
               </div>
               <div class='centered'>
                    <button type='submit' class='btn btn-primary'>Bewaren
                    </button>
                    <a href='?soort=$this->soort' class='btn btn-default'>Annuleren
                    </a>
               </div>
          </div>";
    }

    private function makeOkDialog($tekst)
    {  return "
          <div class='row'>
               <div class='help-block'>
               </div>
               <div class='centered'>
                    <label for='okdialog_id'>" . $tekst . "
                    </label>                   
                    <div class='help-block'>
                    </div>
                    <a href='?soort=$this->soort' 
                       id='okdialog_id' 
                       class='btn btn-primary'>Ok
                    </a>
               </div>
          </div>";
    }

    private function getLookUpValues()
    {
        $result = array();
        foreach ($this->getHeader()->getColumns() as $column)
        {
            if (!$column->getLookUpSql())
            {
            }
            else
            {
                $values = array();
                foreach($this->connection->query($column->getLookUpSql()) as $row)
                {
                    $values[$row['lookup_id']] = $row['lookupresult'];
                }
                $result[$column->getFieldName()] = $values;
            }
        }
        return $result;
    }

    public function getEditHtml()
    {
        $output = "Onbekende gegevens";
        $key = false;
        if (isset($_GET['key']))
        {    $key = $_GET['key'];
        }

        if (!$key)
        {
            return $output;
        }

        $keyrow = false;
        foreach($this->connection->query($this->getSelectSql()) as $row)
        {
            if ($row[$this->getKey()] == $key)
            {
                $keyrow = $row;
                break;
            }
        }
        if (!$keyrow)
        {    return $output;
        }

        $output = "
               <form action='?action=save&soort=$this->soort&key=" . $key . "' 
                     method='POST' 
                     role='form' 
                     class='form-horizontal'>";
        foreach ($this->getHeader()->getColumns() as $column)
        {    $output .= $this->makeFormControlSet($column, $keyrow);
        }

        $output .= $this->makeSaveDialog();

        $output .= "
               </form>";

        return $output;
    }

    public function getNewHtml()
    {
        $output = "
               <form action='?action=insert&soort=$this->soort'  
                     method='POST' 
                     role='form' 
                     class='form-horizontal'>";

        foreach ($this->getHeader()->getColumns() as $column)
        {    $output .= $this->makeFormControlSet($column);
        }

        $output .= $this->makeSaveDialog();

        $output .= "
               </form>";

        return $output;
    }

    public function getUpdateHtml()
    {
        if (isset($_GET['key']))
        {    $key = $_GET['key'];
        }
        if (!$key)
        {
            return $this->makeOkDialog("Onbekende gegevens.");
        }
        $sql = "UPDATE " . $this->getTableName() . " SET ";
        // Submitted key-value pairs
        $fvpairs = array();
        foreach ($this->getHeader()->getColumns() as $column)
        {
            $fvpairs[] = $column->getFieldName() . " = '" .
                $_POST[$column->getFieldName() . "_id"] . "'";
        }

        $sql .= join(', ', $fvpairs) . // Convert key-value pairs to comma separated string
            "   WHERE " . $this->getKey() . " = '" . $this->getKeyValue() . "'";

        if ($this->connection->query($sql) == true)
        {    return $this->makeOkDialog("De gegevens zijn opgeslagen.");
        }
        else
        {    return $this->makeOkDialog($sql . " is mislukt. De gegevens zijn NIET opgeslagen");
            die;
        }
    }

    public function getInsertHtml()
    {
        // Submitted fields and values
        $fields = array();
        $values = array();
        foreach ($this->getHeader()->getColumns() as $column)
        {
            $fields[] = $column->getFieldName();
            $values[] = $_POST[$column->getFieldName() . "_id"];
        }
        $sql =
            "INSERT INTO " . $this->getTableName() .
            " (" . join(', ', $fields) . ") 
                     VALUES ('" . join("', '", $values) . "')";
        if ($this->connection->query($sql) == true)
        {    return $this->makeOkDialog("De gegevens zijn opgeslagen.");
        }
        else
        {    return $this->makeOkDialog($sql . " is mislukt. De gegevens zijn NIET opgeslagen");
            die;
        }
    }

    public function getDeleteHtml()
    {
        $keyvalue = $this->keyvalue;
        if (isset($_GET['key']))
        {    $key = $_GET['key'];
        }
        if (!$key)
        {
            return $this->makeOkDialog("Onbekende gegevens.");
        }
        $sql =  "DELETE FROM " . $this->getTableName();
        $sql .= " WHERE " . $this->getKey() . " = '" . $this->getKeyValue() . "'";

        if ($this->connection->query($sql) == true)
        {    return $this->makeOkDialog("De gegevens zijn verwijderd.");
        }
        else
        {    return $this->makeOkDialog($sql . " is mislukt. De gegevens zijn NIET verwijderd");
            die;
        }
    }

    public function getTableHtml()
    {
        $output =
            "<table>
                    <thead>
                         <tr>";
        foreach ($this->getHeader()->getColumns() as $column)
        {
            $output .=    "<th>" . $column->getCaption() . "</th>";
        }
        $output .=         "<th colspan='2' class='text-center'>
                                   <a href='?action=new&soort=$this->soort'>
                                        <i class='fa fa-plus'></i>
                                   </a> 
                              </th>";
        $output .= "   </tr>
                    </thead>
                    <tbody>";


        $lookupvalues = $this->getLookupValues();

        foreach ($this->connection->query($this->getSelectSql()) as $row)
        {
            $output .=
                "<tr>";
            foreach ($this->getHeader()->getColumns() as $column)
            {
                $output .=
                    "<td>";
                $fldname = $column->getFieldName();
                if (!$column->getLookUpSql())
                {    $output .=
                    $row[$fldname];
                }
                else
                {    // Lookup field
                    $output .=
                        $lookupvalues[$fldname][$row[$fldname]];
                }
                $output .=
                    "</td>";
            }
            $output .=    "<td>
                                   <a href='?action=edit&soort=$this->soort&key=" . $row[$this->getKey()]."'>
                                        <i class='fa fa-pencil'></i>
                                   </a>
                              </td>
                              <td>
                                   <a href='?action=delete&soort=$this->soort&key=" . $row[$this->getKey()]."'>
                                        <i class='fa fa-trash-o'></i>
                                   </a>
                              </td>";

            $output .=
                "</tr>";
        }
        $output .= "
                    </body>
               </table>";
        return $output;
    }
}

class clsDrinkenEnEten extends clsTableDef
{
    public function __construct()
    {
        parent::__construct();

        $this->selectsql = ""; // is set in derived class
        $this->tablename = "menuitem";
        $this->key = "menuitemcode";

        $column = new clsColumn();
        $column->setFieldName("menuitemcode");
        $column->setCaption("Code");
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("menuitemnaam");
        $column->setCaption("Omschrijving");
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("prijs");
        $column->setCaption("Prijs");
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("subgerechtcode");
        $column->setCaption("Valt onder");
        $column->setEditType("Select");
        $column->setLookUpSql("SELECT CONCAT(s.subgerechtcode, ' - ', s.subgerechtnaam, '->', g.gerechtnaam) as lookupresult,
                                        s.subgerechtcode as lookup_id
                                   FROM subgerecht s 
                                   LEFT JOIN gerecht g 
                                          ON s.gerechtcode = g.gerechtcode");
        $this->header->addColumn($column);
    }
}

class clsDrinken extends clsDrinkenEnEten
{
    public function __construct()
    {
        parent::__construct();

        $this->selectsql = "SELECT m.menuitemnaam, m.menuitemcode, m.prijs, m.subgerechtcode    
                                FROM menuitem m 
                                LEFT JOIN subgerecht s 
                                       ON m.subgerechtcode = s.subgerechtcode
                              WHERE s.gerechtcode = 'drk'";
    }
}

class clsEten extends clsDrinkenEnEten
{
    public function __construct()
    {
        parent::__construct();

        $this->selectsql = "SELECT m.menuitemnaam, m.menuitemcode, m.prijs, m.subgerechtcode  
                                FROM menuitem m 
                                LEFT JOIN subgerecht s 
                                       ON m.subgerechtcode = s.subgerechtcode
                              WHERE s.gerechtcode <> 'drk'";
    }
}

class clsKlanten extends clsTableDef
{
    public function __construct()
    {
        parent::__construct();

        $column = new clsColumn();
        $column->setFieldName("klantnaam");
        $column->setCaption("Naam");
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("telefoon");
        $column->setCaption("Telefoon");
        $column->setEditType("Telephone");
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("email");
        $column->setCaption("Email");
        $column->setEditType("Email");
        $this->header->addColumn($column);

        $this->selectsql = "SELECT * FROM klant ORDER BY klantnaam";
        $this->tablename = "klant";
        $this->key = "klant_id";
    }
}

class clsSubGerechten extends clsTableDef
{
    public function __construct()
    {
        parent::__construct();

        $this->selectsql = "SELECT subgerechtcode, subgerechtnaam, gerechtcode
                                FROM subgerecht
                              ORDER BY subgerechtnaam";
        $this->tablename = "subgerecht";
        $this->key = "subgerechtcode";

        $column = new clsColumn();
        $column->setFieldName("subgerechtcode");
        $column->setCaption("Code");
        $column->setReadOnly();
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("subgerechtnaam");
        $column->setCaption("Omschrijving");
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("gerechtcode");
        $column->setCaption("Valt onder");
        $column->setEditType("Select");
        $column->setLookUpSql("SELECT gerechtnaam as lookupresult, gerechtcode as lookup_id
                                   FROM gerecht 
                                 ORDER BY gerechtnaam");
        $this->header->addColumn($column);
    }
}

class clsGerechten extends clsTableDef
{
    public function __construct()
    {
        parent::__construct();

        $this->selectsql = "SELECT gerechtcode, gerechtnaam 
                                FROM gerecht
                              ORDER BY gerechtnaam";
        $this->tablename = "gerecht";
        $this->key = "gerechtcode";

        $column = new clsColumn();
        $column->setFieldName("gerechtcode");
        $column->setCaption("Code");
        $column->setReadOnly();
        $this->header->addColumn($column);

        $column = new clsColumn();
        $column->setFieldName("gerechtnaam");
        $column->setCaption("Omschrijving");
        $this->header->addColumn($column);
    }
}

class page
{
    public function getHtml()
    {	$datalist = null;
        $soort = "";
        if (isset($_GET['soort']))
        {    $soort = $_GET['soort'];
            $keyvalue = false;
            if (isset($_GET['key']))
            {    $keyvalue = $_GET['key'];
            }
            $datalist = $this->getTableDef($soort, $keyvalue);
        }
        else
        {    return "Onbekend gegeven.";
        }

        $action = "";
        if (isset($_GET['action']))
        {    $action = $_GET['action'];
        }

        switch($action)
        {
            case "edit":
                return $datalist->getEditHtml(); break;
            case "new":
                return $datalist->getNewHtml(); break;
            case "save":
                return $datalist->getUpdateHtml(); break;
            case "insert":
                return $datalist->getInsertHtml(); break;
            case "delete":
                return $datalist->getDeleteHtml(); break;
            default:
                return $datalist->getTableHtml(); break;
        }

    }

    protected function getTableDef($soort, $keyvalue)
    {
        $datalist = false;
        switch($soort)
        {
            case "drinken"     : $datalist = new clsDrinken(); break;
            case "eten"        : $datalist = new clsEten(); break;
            case "klanten"     : $datalist = new clsKlanten(); break;
            case "gerechten"   : $datalist = new clsGerechten(); break;
            case "subgerechten": $datalist = new clsSubgerechten(); break;
        }
        if (!$datalist)
        {
            print "Onbekend gegeven.";
            die;
        }
        $datalist->setSoort($soort);
        $datalist->setKeyValue($keyvalue);

        return $datalist;
    }
}

