<?php namespace Libs\Container; 

use Libs\Exception\DBException;

class DBFactory {

    /** 
     * Mysql connection resource instance. 
     * 
     * @var resource
     */
    protected $link = null;

    private static $instances = array(); // database connections

    private static $key;

    const CONNECT_TIMEOUT = 4;

    protected $DBName;
    protected $DBConfig = []; 

    public function __construct($DBName = '', $DBConfig = []) {
        $this->DBName = $DBName;
        $this->DBConfig = $DBConfig;         
    } 

    /**
     * Database connection function. 
     *
     * @param string $DBType
     * @return void  
     */
    public function connect($DBType = 'slave')
    {
        
        empty($this->DBName) && $this->DBName = 'default';
    
        $host    = isset($this->DBConfig[$DBType]['host'])    ? $this->DBConfig[$DBType]['host']    :  \Config::$mysqlConfig[$this->DBName][$DBType]['host'];
        $port    = isset($this->DBConfig[$DBType]['port'])    ? $this->DBConfig[$DBType]['port']    :  \Config::$mysqlConfig[$this->DBName][$DBType]['port']; 
        $uname   = isset($this->DBConfig[$DBType]['uname'])   ? $this->DBConfig[$DBType]['uname']   :  \Config::$mysqlConfig[$this->DBName][$DBType]['uname']; 
        $passwd  = isset($this->DBConfig[$DBType]['passwd'])  ? $this->DBConfig[$DBType]['passwd']  :  \Config::$mysqlConfig[$this->DBName][$DBType]['passwd'];
        $dbname  = isset($this->DBConfig[$DBType]['dbname'])  ? $this->DBConfig[$DBType]['dbname']  :  \Config::$mysqlConfig[$this->DBName][$DBType]['dbname']; 
        $charset = isset($this->DBConfig[$DBType]['charset']) ? $this->DBConfig[$DBType]['charset'] :  \Config::$mysqlConfig[$this->DBName][$DBType]['charset']; 
        
        self::$key = md5(implode('#', array($host, $port, $uname, $dbname, $charset)));

        $mysqli = mysqli_init();
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, self::CONNECT_TIMEOUT);
        
        if ($mysqli->real_connect($host, $uname, $passwd, $dbname, $port))
        {
            $mysqli->set_charset($charset);
            self::$instances[self::$key] = $mysqli;    
            return self::$instances[self::$key];
        }
        else 
        {
            return false;
        }
    } 


    /**
     * Check Database connection status.
     *
     * @param string $DBType 
     * @return void
     */
    public function checkLink($DBType = 'slave') {
        $this->link = $this->connect($DBType);
        if (!$this->link) {
            throw new DBException('message', '1030');
        }
    }

    /**
     * Select function
     *
     * Note : Return a array of mysql record list by conds and appends.
     *
     * @param string $table
     * @param array  $fields 
     * @param array  $conds
     * @param string $appends
     * @return array $ret 
     */
    public function select($table, $fields, $conds = NULL, $appends = NULL, $DBType = 'slave')
    {
        $this->checkLink($DBType);
    
        $sql = "SELECT ";
        
        $fields = implode(',', $fields);

        $sql .= " {$fields} FROM {$table}";

        $sql = empty($conds) ? $sql : $this->getStringByConds($sql, $conds);        
        
        if($appends !== NULL) 
        {
            $sql .= " {$appends}";
        }
        
        $query = $this->query($sql);
        
        $ret = array();
        while ($row = $query->fetch_assoc()) {
            empty($row) || $ret[] = $row;
        }
        
        return $ret;
    }

    /**
     * Select Count function
     *
     * Note : Return a record list count by conds and appends.
     *
     * @param string $table
     * @param array  $conds
     * @param string $appends
     * @return int $ret 
     */
    public function selectCount($table, $conds = NULL, $appends = NULL, $DBType = 'slave') {
        
        $this->checkLink($DBType);       
 
        $sql = "SELECT count(*) FROM {$table}";
        
        $sql = empty($conds) ? $sql : $this->getStringByConds($sql, $conds);
         
        if($appends !== NULL) 
        {
            $sql .= " {$appends}";
        }
        
        $query = $this->query($sql);
        
        $row = $query->fetch_row();
        
        return $row[0];   
    }

    /**
     * Insert function 
     *
     * @param string $table
     * @param array $conds
     * @param string $append
     * @return int
     */
    public function insert($table, $row, $onDup = NULL, $DBType = 'master') {
 
        $this->checkLink($DBType);

        $inKeyArr = $inValArr = array();
        foreach ($row as $key => $value) {
            $inKeyArr[] = ' `' . $key . '` ';
            $inValArr[] = "'" . $this->link->real_escape_string($value)."'";
        } 
    
        $sql = "INSERT INTO `{$table}` (" . implode(',', $inKeyArr) . ") VALUE (" . implode(',', $inValArr) . ")";
        $ret = $this->link->query($sql); 
        if ($ret !== true) {
            throw new BaseException('Insert failed.', '1028'); 
        }
        return $this->link->insert_id;
    }

    /**
     * Update record  
     *
     * @param array $update
     * @param array $where
     */
    public function update($table, $update, $where, $DBType = 'master'){
        $this->checkLink($DBType);

        $sql = "UPDATE {$table}";
        if(!empty($update)) {
            foreach($update as $key=>$value){
                $value = "'" . $this->link->real_escape_string($value) . "'";
                $updateArr = " {$key}={$value}";
            }
            $sql .= " SET " . implode(',', $updateArr);
        } 
        if (!empty($where)) {
            foreach($where as $key=>$value){
                $value = $this->link->real_escape_string($value);
                $whereArr[] = " {$key}{$value}";        
            }
            $string = implode(' AND ', $whereArr);
            $sql .= " WHERE {$string}";
        }
        $ret = $this->link->query($sql);
        return $ret;
    }

    /**
     * Delete record by unique id.
     *
     * @param array $where 
     * @return bool
     */
    public function delete($table, $where, $DBType = 'master'){
        
        $this->checkLink($DBType);

        $sql = "DELETE FROM {$table}";
            
        if (!empty($where)) {
            foreach($where as $key=>$value){
                $value = $this->link->real_escape_string($value);
                $arr[] = " {$key}{$value}";        
            }
            $string = implode(' AND ', $arr);
            $sql .= " WHERE {$string}";
        }
        $ret = $this->link->query($sql);
        return $ret;  
    }

    /**
     * Get sql string by sql prefix and conds array.
     *
     * @param string $sql
     * @param array $conds
     * return string 
     */
    public function getStringByConds($sql, $conds) {
        foreach($conds as $key => $value) 
        {
            $value = $this->link->real_escape_string($value);
            $arr[] = " {$key}{$value}";
        }
        if(!empty($arr)) {
            $string = implode(' AND ', $arr);
            $sql .= " WHERE {$string}";
        }
        return $sql;
    }

    /**
     * Execute sql statement
     * 
     * @param string $sql
     * @param tinyint $fetchType
     * @return arrray $ret 
     */
    public function query($sql)
    {
        return $this->link->query($sql); 
    }
}
