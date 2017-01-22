<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 * Process an incoming Http request send by the router
 *
 * @author jp
 * @version 2016-14 save automation
 *
 * PDO for WAMP - Windows
 * PDO object db access
 * 
 */
abstract class fwDao
{
    /*
     * pdo object
     */
    private static $db;
    var $table ="current table";
    var $sql ="";
    var $id =-1;
    
    
    /**
     * sql request with optional parameters
     * 
     * @param string $sql  SELECT statement
     * @param array $params
     * @return PDOStatement
     */
    /**
     * SQL SELECT
     * @param array $data
     * @return PDOStatement
     */
    public function get($data=array())
    {   
        fwTrace(debug_backtrace(), $data);
       
        $fields = "*";
        $conditions = "";
        $order = "ORDER BY id DESC";
        $limit = "";
        extract($data);             //Importe les variables dans la table des symboles
        
        if(!empty($data["conditions"])){ $conditions = "WHERE ".$data["conditions"]; }
        if(!empty($data["limit"])){ $limit = "LIMIT ".$data["limit"]; }
        
        $this->sql = "SELECT $fields FROM `".$this->table."`  $conditions $order $limit";
        appWatch($this->sql, ".get(sql)", get_class());
        try {
        $result = self::getDB()->prepare($this->sql) ;
        //$result->execute() ;
        if (!$result->execute()) throw new \PDOException("fwDao.get, Error during execute operation");
        $result = $result->fetchAll();
        appWatch(count($result), ".get(#record)", get_class());
        return $result;
        }catch (\PDOException $e) {
            $msg = 'fwDao.get(PDO error) ' . $e->getFile() . ' Line' . $e->getLine() . ' SQL: ' . $this->sql . ' : ' . $e->getMessage();
            throw new \Exception($msg);
        }
        catch (\Exception $e) {
            $msg = 'fwDao.get(error) ' . $e->getFile() . ' Line' . $e->getLine() . ' SQL: ' . $this->sql . ' : ' . $e->getMessage();
            throw new \Exception($msg);
        }
    }
    
    /**
     * get by key
     *
     * @param string $key
     * @param string $column (WHERE $column=$key)
     */
    public function getRecord($key,$column="") {
        if (!empty($column)) {
            $record = $this->get(array("conditions"=> "$column = '$key'"));
        } else {
            $record = $this->get(array("conditions"=> "id = '$key'"));
        }
        appWatch($record, ".getRecord", get_class());
        
        if (empty($record)) return $record;                     //key not found
        //return the retrieved record
        else return $record[0] ;
    }

    /**
     * Save data into the database
     * @param $data data to be saved
     * */
    public function save($data){
        //standard data
        $data['date_created']=date('Y-m-d H:i:s');
        fwTrace(debug_backtrace(), $data);
        
        if(!empty($data["id"])) {
            $sql = "UPDATE `".$this->table."` SET ";
            foreach($data as $k=>$v){
                $k=strtolower($k);
                if($k!="id"){       
                    $v= substr(self::getDB()->quote($v), 1, sizeof($v)-2);              
                    $sql .= "$k='$v',";
                }
            }
            $sql = substr($sql,0,-1);
            $sql .= " WHERE id=".$data["id"];
        }
        else{
            $sql = "INSERT INTO `".$this->table."` (";
            unset($data["id"]);
            foreach($data as $k=>$v){
                    $k=strtolower($k);
                    $sql .= "$k,";
            }
            $sql = substr($sql,0,-1);
            $sql .=") VALUES (";
            foreach($data as $k=>$v){
                    $v= substr(self::getDB()->quote($v), 1, sizeof($v)-2);
                    $sql .= "'$v',";
            }
            $sql = substr($sql,0,-1);
            $sql .= ")";
        }
        try {
            $this->sql=$sql;
            appWatch($sql,"save(sql)", get_class($this));
            $request = self::getDB()->prepare($sql);
            if (!$request->execute()) throw new \PDOException("fwDao.save, Error during save operation");
            if(!isset($data["id"])){
                $this->id=self::getDB()->lastInsertId();
                info("i", "Object created successfully($this->id)");  //popup window
                appWatch(array("save/Object created successfully"=>$this->id), "", get_class());
            }
            else{
                $this->id = $data["id"];
                info("i", "Object updated successfully($this->id)");  //popup window
                appWatch(array("save/Object updated successfully"=>$this->id), "", get_class());
            }
            return true;
        } catch (\PDOException $e) {
            $msg = 'fwDao.save(PDO error) ' . $e->getFile() . ' Line' . $e->getLine() . ' SQL: ' . $this->sql . ' : ' . $e->getMessage();
            throw new \Exception($msg);
        }
        catch (\Exception $e) {
            $msg = 'fwDao.save(error) ' . $e->getFile() . ' Line' . $e->getLine() . ' SQL: ' . $this->sql . ' : ' . $e->getMessage();
            throw new \Exception($msg);
        }
    }
  
    /**
     * sql delete
     * @param int record id
     * @throws fw\Exception on sql insert error
     * @return boolean true if successfull insert
     */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM `".$this->table."` WHERE id=$id";
            $this->sql=$sql;
            appWatch($sql,"fwDao.save(sql)", get_class($this));
            $request = self::getDB()->prepare($sql);
            //$request->execute();
            if (!$request->execute()) throw new \PDOException("fwDao.delete, Error during delete operation");
            info("i", "Object deleted successfully($id)");        //popup window
            appWatch(array("delete/Object deleted successfully" => $id), "", get_class());
            return true;
        } catch (\PDOException $e) {
            $msg = 'fwDao.delete(PDO error) ' . $e->getFile() . ' Line' . $e->getLine() . ' SQL: ' . $this->sql . ' : ' . $e->getMessage();
            //die(mysql_error()."<br/> => ".$msg);
            throw new \Exception($msg);
        } catch (\Exception $e) {
            $msg = 'fwDao.delete(error) ' . $e->getFile() . ' Line' . $e->getLine() . ' SQL: ' . $this->sql . ' : ' . $e->getMessage();
            throw new \Exception($msg);
        }
    }
      
    /**
     * return a DB connection object and initialize connection if needed
     */
    private static function getDB()
    {
        try {
            if (self::$db == null) {
                // new connection
                // get configuration params from config file
                $dsn = fw\fwConfiguration::get("dsn");
                fwWatch(array($dsn => "initialize database connection"), "", get_class());
                $login = fw\fwConfiguration::get("login");
                $pwd = fw\fwConfiguration::get("pwd");
                // new connection
                self::$db = new \PDO($dsn, $login, $pwd, array(                            
                    // \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION        
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING
                ));

            }
            
            return self::$db;
        } catch (\PDOException $e) {
            throw new \Exception("fwDao.getDB(PDO error) MySql connection error(" .$dsn. ")");
        }
        catch (\Exception $e) {
            throw new \Exception("fwDao.getDB(PDO error) MySql connection error(" .$dsn. ")");
        }
    }

    /**
     * return # record count
     *
     * @return int count
     */
    public function count($data=array())
    {
        $conditions="";
        if (!empty($data)) {
            extract($data);             //Importe les variables dans la table des symboles
        }
        
        $param=array(
            "fields" => 'count(*) AS count', "order" => "" ,
            "conditions" => $conditions);
        
        $result = $this->get($param);
        return $result[0]['count'];
    }
    
    /**
     * return # column count
     *
     * @return int count
     */
    public function columnCount()
    {
        $dsn = fw\fwConfiguration::get("dsn");
        $conditions = 'table_schema = ' . $dsn . ' AND table_name='. $this.table;
        $table=$this->table;                            //save table
        $this->table='information_schema.COLUMNS';
        $param=array(
            "conditions" => $conditions
        );
        $result = $this->count($param);
        $this->table=$table;                            //restore table
        return $result;
    }
    
} // end class





