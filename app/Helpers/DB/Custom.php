<?php
namespace App\Helpers\DB;
use PDO;
class CustomDB {
    private static $_instance = null; //store instance of the database if it is available
    private $_pdo,
            $_query,
            $_error,
            $_results, //result of query
            $_bindValues = array(),
            $_count = 0; //count of results
    
    private function __construct() {
        try { //try to connect to the database
            $dbHost = env("DB_HOST", "127.0.0.1");
            $dbName = env("DB_DATABASE", "e3mly");
            $dbUsername = env("DB_USERNAME", "root");
            $dbPassword = env("DB_PASSWORD", "");
            $this->_pdo = new PDO('mysql:host=' . $dbHost . ';dbname='. $dbName, $dbUsername, $dbPassword); 
        } catch(PDOException $ex) {
            die($ex->getMessage());
        }
    }
    public static function getInstance() { // to connect once to the database
        if(!isset(self::$_instance)) {
            self::$_instance = new CustomDB();
        }
        return self::$_instance;
    }
    //execute regular queries and can bind ? with values
    public function query($sql, $paramters = array()) {
        $this->_error = false;
        $this->_query = $sql;
        if($this->_query = $this->_pdo->prepare($sql)) {
            if(count($paramters)) { //to bind (?,?, ...) with parameters before excute query
                $counter = 1;
                foreach($paramters as $parameter) {
                    $this->_query->bindValue($counter, $parameter); // assign parameter to the counter number ? mark
                    $counter++;
                }
            }
            if($this->_query->execute()) { //excute query
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ); //return rows as object
                $this->_count = $this->_query->rowCount(); //count the number of rows
            } else {
                $this->_error = true;
            }
        }
        $this->_bindValues = array();
        return $this; // to chain it as query_name->error()
    }
    // getters
    public function error() { //return true if there is an error in the query
        return $this->_error;
    }
    public function results() { 
        return $this->_results;
    }
    public function first() { 
        return $this->_results[0];
    }
    public function count() {
        return $this->_count;
    }  
    
    public function where($where_clause, $values = array()) {
        $this->_query .= " WHERE " . $where_clause;
        $this->_bindValues += $values; //values to bind
        return $this;
    }
    public function order($orderby_clause) {
        $this->_query .= " ORDER BY " . $orderby_clause;
        return $this;
    }
    public function group($groupby_clause) {
        $this->_query .= " GROUP BY " . $groupby_clause;
        return $this;
    }
    public function having($having_clause, $values) {
        $this->_query .= " HAVING " . $having_clause;
        $this->_bindValues += $values; //values to bind
        return $this;
    }
    public function e() { //excute with get query
        return $this->query($this->_query, $this->_bindValues);
    }
    //custom functions make the query for you for (get, delete) funcs
    private function action($action, $cols,  $table) {
        $str = implode(', ', $cols);
        $this->_query = "{$action} {$str} FROM {$table}";
        return;
    }
    public function get($cols, $table) { 
        $this->action('SELECT', $cols, $table);
        return $this;
    }
    public function delete($table) {
        $this->action('DELETE', array(), $table);
        return $this;
    }
    public function insert($table, $cols) {
        $itemNum = count($cols);
        if($itemNum) {
            $keys = array_keys($cols);
            $this->_bindValues += array_values($cols);
            $quesMArk = '(';
            $counter = 1;
            foreach ($cols as $cols) {
                $quesMArk .= '?';
                if ($counter < $itemNum) {
                    $quesMArk .= ', '; 
                }
                $counter++;
            }
            $quesMArk .= ')';
            $this->_query = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES {$quesMArk}";
        }
        return $this;
    }
    public function update($table, $cols) {
        $itemNum = count($cols); 
        if($itemNum) { 
            $this->_bindValues += array_values($cols); //values to bind
            $set = '';
            $counter = 1;
            foreach($cols as $key => $value) {//to make the (attribute_name = ?, attribute_name = ?, ....) part of the query
                $set .= "{$key} = {$value}";
                if($counter < $itemNum) {
                    $set .= ', ';
                }
                $counter++;
            } 
            $this->_query = "UPDATE {$table} SET {$set}";
        }
        return false;
    }
}
/* 
How to use
(1) public function query($sql, $paramters = array()) function
you just pass your query to the function and it's all done
ex: (a) CustomDB::getInstance()->query("SELECT * FROM `users`");
    (b) CustomDB::getInstance()->query("SELECT * FROM `users` WHERE id = ?", [$id]);
    // if you try to write query("SELECT * FROM `users` WHERE {id = $id} it might work in this case
(2) public function get($cols, $table)
ex: (a) CustomDB::getInstance()->get([*], "users") =>SELECT * FROM users
    (b) CustomDB::getInstance()->get([username, password], "users")->where("age > ? and status = ?", [70, 'married'])->order("Country ASC, CustomerName DESC")->e();
    => SELECT username, password FROM users WHERE age > 70 and status = married
    ps: don't forget to use ->e() at the end it's the execution function you don't use it only with the query function
    (c) CustomDB::getInstance()->get(["COUNT(CustomerID)", "Country"], "CustomersGROUP")->group("Country")->having("COUNT(CustomerID) > ?",[5])->order("COUNT(CustomerID) DESC")->e();
    => SELECT COUNT(CustomerID), Country FROM Customers GROUP BY Country HAVING COUNT(CustomerID) > 5 ORDER BY COUNT(CustomerID) DESC
    **if you want to use the query function in (c)**
    => CustomDB::getInstance()->query("SELECT COUNT(CustomerID), Country FROM Customers GROUP BY Country HAVING COUNT(CustomerID) > ? ORDER BY COUNT(CustomerID) DESC", [5])
    if you want the result and ofcourse you want 
    ***********************************V.IMP******************************************
    (a:1)store it in variable => $users = DB::getInstance()->get([*], "users");
    (a:2)get the results by the results function => $results = $users->results();
    (a:3)if you want to check if there is an error or not => $error = $users->error();
(3) public function delete($table)
ex: (a) CustomDB::getInstance()->delete('users')->where("id = ?".[$id])->e();
(4) public function insert($table, $cols) 
ex: (a) CustomDB::getInstance()->insert("posts", array(
            'title' => $title,
            'body' => $body,
            'min_cost' => $min_cost,
            'max_cost' => $max_cost,
            'description_file' => $fileNameToStore,
            'period' => $period,
            'user_id' => $user_id,
            'category' => $category,
            'created_at' => $created_at
        ))->e(); 
        // [] or array() doesn't matter ofcourse 
        //we could get rid of the e() function here but to keep the consistancy of the class you have to use it
(5) public function update($table, $cols)
ex: (a) CustomDB::getInstance()->update("posts", array(
            'title' => $title,
            'body' => $body,
            'min_cost' => $min_cost,
            'max_cost' => $max_cost,
            'description_file' => $fileNameToStore,
            'period' => $period,
            'user_id' => $user_id,
            'category' => $category,
            'created_at' => $created_at
        ))->where(title = ?,["Hello my name is abdulrahman"])->e(); 
*/