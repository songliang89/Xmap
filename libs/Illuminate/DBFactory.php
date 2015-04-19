<?php namespace Libs\Illuminate; 

class DBFactory {

    private $instances = array(); // database connections

    private $link = null;

    const CONNECT_TIMEOUT = 4;

    public function __construct($DBName, $DBConfig)
    {
        
        $dbkey = md5(implode('#', array($host, $port, $uname, $dbname, $port, $charset)));

        $this->link = mysqli_init();
        $this->link->options(MYSQLI_OPT_CONNECT_TIMEOUT, self::CONNECT_TIMEOUT);
        
        if ($this->connect($host, $uname, $passwd, $dbname, $port))
        {
            $this->instance[$key] = $this->link;    
        }
    } 

    /**
     * DB connect
     *
     *
     */
    public function connect($host, $uname = NULL, $passwd = NULL, $dbname = NULL, $port = NULL)
    {
        return $this->link->real_connect($host, $uname, $passwd, $dbname, $port);
    }
   
    /**
     * Set connect timeout limit. 
     *
     * @return void
     */ 
    public function setConnectTimeout($seconds)
    {
        return $seconds > 0 ? $this->instance->setOption(MYSQLI_OPT_CONNECT_TIMEOUT, $seconds) : false;
    }

    /**
     * Set charset
     *
     * @return void
     */
    public function setCharst($charset = 'utf8'){
        $this->instance->set_charset($charset);
    }

    public function select($table, $fields, $options, $appends)
    {
        $sql = "SELECT ";
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
        $query = $this->instance->query($sql);
        $ret = array();
        while ($row = $query->fetch_assoc()) {
            empty($row) || $ret[] = $row;
        }
        return $ret;
    }
}
