<?php namespace Libs\Illuminate; 

class DBFactory {

    private static $instances = array(); // database connections

    private static $key;

    const CONNECT_TIMEOUT = 4;

    public function __construct($DBName = '', $DBType = 'slave', $DBConfig = [])
    {
        
        empty($DBName) && $DBName = 'default';
    
        $host    = isset($DBConfig[$DBType]['host'])    ? $DBConfig[$DBType]['host']    :  Config::$mysqlConfig[$DBName][$DBType]['host'];
        $port    = isset($DBConfig[$DBType]['port'])    ? $DBConfig[$DBType]['port']    :  Config::$mysqlConfig[$DBName][$DBType]['port']; 
        $uname   = isset($DBConfig[$DBType]['uname'])   ? $DBConfig[$DBType]['uname']   :  Config::$mysqlConfig[$DBName][$DBType]['uname']; 
        $passwd  = isset($DBConfig[$DBType]['passwd'])  ? $DBConfig[$DBType]['passwd']  :  Config::$mysqlConfig[$DBName][$DBType]['passwd'];
        $dbname  = isset($DBConfig[$DBType]['dbname'])  ? $DBConfig[$DBType]['dbname']  :  Config::$mysqlConfig[$DBName][$DBType]['dbname']; 
        $charset = isset($DBConfig[$DBType]['charset']) ? $DBConfig[$DBType]['charset'] :  Config::$mysqlConfig[$DBName][$DBType]['charset']; 
        
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
    public function select($table, $fields, $conds = NULL, $appends = NULL)
    {
        $sql = "SELECT ";
        
        $fields = implode(',', $fields);

        $sql .= " {$fields} FROM {$table}";

        foreach($conds as $key => $value)
        {
            $conds[$key] = self::$instances[self::$key]->real_escape_string($value);
        }  
        
        if (!empty($conds)) 
        {
            foreach($conds as $key => $value) 
            {
                $arr[] = " {$key}{$value}";
            }
            $string = implode(' AND ', $arr);
            $sql .= " WHERE {$string}";
        }

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
     * Execute sql statement
     * 
     * @param string $sql
     * @param tinyint $fetchType
     * @return arrray $ret 
     */
    public function query($sql)
    {
        return self::$instances[self::$key]->query($sql); 
    }
}
