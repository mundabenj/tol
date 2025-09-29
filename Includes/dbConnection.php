<?php
/**
 * Class:        dbConnection (MySQLi, PDO)
 * Developer:    Mundabenj
 * Date:         2025-09-19
 * Description:  Multi-Database Connector supporting MySQLi and PDO.
 * Website:      https://elearning.strathmore.edu/
 */
/******************************************************************************************
 * Database Connections
 * Usage Example:
 * $db = new dbConnection('MySQLi', 'localhost', 'dbname', 'user', 'pass', 3306);
 * or
 * $db = new dbConnection('PDO', 'localhost', 'dbname', 'user', 'pass', 3306);
******************************************************************************************/
class dbConnection{
    //constructor creation
    
    private $connection;
    private $db_type;
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_port;
    private $posted_values;
    
    // * $db = new dbConnection('PDO', 'localhost', 'dbname', 'user', 'pass', 3306);
    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_PORT) {
        $this->db_type      = $DB_TYPE;
        $this->db_host      = $DB_HOST;
        $this->db_name      = $DB_NAME;
        $this->db_user      = $DB_USER;
        $this->db_pass      = $DB_PASS;
        $this->db_port      = $DB_PORT;
        $this->connection($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_PORT);
    }
    public function connection($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_PORT){
        switch ($DB_TYPE) {
            case 'MySQLi':
                if($DB_PORT<>Null){
                    $DB_HOST.=":".$DB_PORT;
                }
                $this->connection = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
                if ($this->connection->connect_error) { return "Connection failed: " . $this->connection->connect_error; }else{
                    // print "Connected successfully with ".$DB_TYPE;
                }
                break;
            case 'PDO':
                if($DB_PORT<>Null){
                    $DB_HOST.="";
                }
                try {
                    $this->connection = new PDO("mysql:host=$DB_HOST:$DB_PORT;dbname=$DB_NAME", $DB_USER, $DB_PASS);
                    // set the PDO error mode to exception
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // print "Connected successfully with ".$DB_TYPE;
                } catch(PDOException $e) {
                    die("Connection failed: " . $e->getMessage());
                }
                break;
        }
    }
    /******************************************************************************************
    Close Database Connection
     ******************************************************************************************/
    public function closeConnection() {
        switch ($this->db_type) {
            case 'MySQLi':
                if ($this->connection instanceof mysqli) {
                    $this->connection->close();
                }
                break;
            case 'PDO':
                $this->connection = null;
                break;
        }
    }
    /******************************************************************************************
    MySQLi Real Escape String (tested)
     ******************************************************************************************/
    public function escape_values($posted_values): string
    {
        switch ($this->db_type) {
            case 'MySQLi':
                $this->posted_values = $this->connection->real_escape_string($posted_values);
                break;
            case 'PDO':
                $this->posted_values = addslashes($posted_values);
                break;
        }
        return $this->posted_values;
    }
    /******************************************************************************************
    Count Returned Results (tested)
     ******************************************************************************************/
    public function count_results($sql){
        switch ($this->db_type) {
            case 'MySQLi':
                if(is_object($this->connection->query($sql))){
                    $result = $this->connection->query($sql);
                    return $result->num_rows;
                }else{
                    print "Error 5: " . $sql . "<br />" . $this->connection->error . "<br />";
                }
                break;
            case 'PDO':
                $res = $this->connection->prepare($sql);
                $res->execute();
                return $res->rowCount();
                break;
        }
    }
    /******************************************************************************************
    Insert Query (extracted) (tested)
     ******************************************************************************************/
    public function insert($table, $data){
        ksort($data);
        $fieldDetails = NULL;
        $fieldNames = implode('`, `',  array_keys($data));
        $fieldValues = implode("', '",  array_values($data));
        $sth = "INSERT INTO $table (`$fieldNames`) VALUES ('$fieldValues')";
        return $this->extracted($sth);
    }
    /******************************************************************************************
    Select Query From a DataBase
     ******************************************************************************************/
    public function select($sql){
        switch ($this->db_type) {
            case 'MySQLi':
                $result = $this->connection->query($sql);
                return $result->fetch_assoc();
                break;
            case 'PDO':
                $result = $this->connection->prepare($sql);
                $result->execute();
                return $result->fetchAll(PDO::FETCH_ASSOC)[0];
                break;
        }
    }
    /******************************************************************************************
    Select Query While Loop From a DataBase (tested)
     ******************************************************************************************/
    public function select_while($sql){
        switch ($this->db_type) {
            case 'MySQLi':
                $result = $this->connection->query($sql);
                for ($res = array (); $row = $result->fetch_assoc(); $res[] = $row);
                return $res;
                break;
            case 'PDO':
                $result = $this->connection->prepare($sql);
                $result->execute();
                return $result->fetchAll(PDO::FETCH_ASSOC);
                break;
        }
    }
    /******************************************************************************************
    Update Query (extracted) (tested)
     ******************************************************************************************/
    public function update($table, $data, $where){
        $wer = '';
        if(is_array($where)){
            foreach ($where as $clave=>$value){
                $wer.= $clave."='".$value."' AND ";
            }
            $wer   = substr($wer, 0, -4);
            $where = $wer;
        }
        ksort($data);
        $fieldDetails = NULL;
        foreach ($data as $key => $values){
            $fieldDetails .= "$key='$values',";
        }
        $fieldDetails = rtrim($fieldDetails,',');
        if($where==NULL or $where==''){
            $sth = "UPDATE $table SET $fieldDetails";
        }else {
            $sth = "UPDATE $table SET $fieldDetails WHERE $where";
        }
        return $this->extracted($sth);
    }
    /******************************************************************************************
    Delete Query (extracted) (tested)
     ******************************************************************************************/
    public function delete($table,$where){
        $wer = '';
        if(is_array($where)){
            foreach ($where as $clave=>$value){
                $wer.= $clave."='".$value."' and ";
            }
            $wer   = substr($wer, 0, -4);
            $where = $wer;
        }
        if($where==NULL or $where==''){
            $sth = "DELETE FROM $table";
        }else{
            $sth = "DELETE FROM $table WHERE $where";
        }
            return $this->extracted($sth);
    }
    /******************************************************************************************
    Truncate Query (extracted)
     ******************************************************************************************/
    public function truncate($table){
        $sth = "TRUNCATE $table";
        return $this->extracted($sth);
    }
	
	/******************************************************************************************
	Get ID of Last Inserted Record
	******************************************************************************************/
	public function last_id(){
		switch ($this->db_type) {
		case 'MySQLi':
			return $this->connection->insert_id;
		break;
		case 'PDO':
			return $this->connection->lastInsertId();
		break;
		}
	}
        // Method to drop a table (for testing purposes)
    public function dropTable($tableName) {
        $sql = "DROP TABLE IF EXISTS `$tableName`";
        return $this->extracted($sql);
    }

    // Method to create a table (for testing purposes)
    public function createTable($tableName, $columns) {
        $columnsSql = [];
        foreach ($columns as $columnName => $dataType) {
            $columnsSql[] = "`$columnName` $dataType";
        }
        $columnsSqlString = implode(", ", $columnsSql);
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` ($columnsSqlString)";
        return $this->extracted($sql);
    }

    // Alter table to add foreign key constraints
    public function addForeignKey($table, $column, $referencedTable, $referencedColumn) {
        $sql = "ALTER TABLE `$table`
                ADD CONSTRAINT fk_{$table}_{$column} FOREIGN KEY ($column) REFERENCES $referencedTable($referencedColumn) ON DELETE RESTRICT ON UPDATE CASCADE";
        return $this->extracted($sql);
    }

    /******************************************************************************************
    Extracted (tested)
     ******************************************************************************************/
    /**
     * @param string $sth
     * @return bool|string|void
     */
    public function extracted(string $sth)
    {
        switch ($this->db_type) {
            case 'MySQLi':
                if ($this->connection->query($sth) === TRUE) {
                    return TRUE;
                } else {
                    return "Error: " . $sth . "<br />" . $this->connection->error;
                }
                break;
            case 'PDO':
                try {
                    // Prepare statement
                    $stmt = $this->connection->prepare($sth);
                    // execute the query
                    $stmt->execute();
                    return TRUE;
                } catch (PDOException $e) {
                    return $sth . "<br />" . $e->getMessage();
                }
                break;
        }
    }
}