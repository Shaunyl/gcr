<?php
    $directory = "";
    include ($directory . "dbconf.php");

    class DbLayer implements IteratorAggregate {
        private $mysqli;
    
        protected $_data = array();
    
        function __construct() {
            $this -> mysqli = Database::getInstance();
        }

        public function read ($table, $fields = '*') {
            if ($fields == '*') {
                $columns = $fields;
            } else {
                $columns = $this -> parseFields($fields);
            }
            
            $statement = $this -> mysqli -> prepare('SELECT ' . $columns . ' FROM ' . $table);
            $statement -> execute();
        
            $this -> fetch($statement);

            return $this -> getIterator();
        }
        
        public function readRange ($table, $offset, $count, $fields = '*') {
            
            return $this -> read($table . ' LIMIT ' . $offset . ', ' . $count, $fields);
        }
        
        public function readWhere ($fields, $table, $predicates) {
            $params = array_values($predicates);
            $bind_names = $this -> extractBindParamsFormat($params);
            for ($i = 0; $i < count($params); $i++) {
                $bind_name = 'bind' . $i;
                $$bind_name = $params[$i];
                $bind_names[] = &$$bind_name;
            }
                                                
            $columns = $this -> parseFields($fields);
            $conditions = $this -> parsePredicates($predicates);
                        
            $statement = $this -> mysqli -> prepare('SELECT ' . $columns . ' FROM user WHERE ' . $conditions);
            call_user_func_array(array($statement, 'bind_param'), $bind_names);
            $statement -> execute();
        
            $this -> fetch($statement);
            
            return $this -> getIterator();
        }
        
        public function write ($fields, $table, $values) {
            $columns = $this -> parseFields($fields);
            $wildchars = $this -> parseWildChars($fields);
            
            $statement = $this -> mysqli -> prepare('INSERT INTO ' . $table . ' (' . $columns . ') VALUES (' . $wildchars . ')');
            $bind_names = $this -> extractBindParamsFormat($values);
            for ($i = 0; $i < count($values); $i++) {
                $bind_name = 'bind' . $i;
                $$bind_name = $values[$i];
                $bind_names[] = &$$bind_name;
            }
            
            call_user_func_array(array($statement, 'bind_param'), $bind_names);
            $statement -> execute();
            
            if (!$this -> mysqli -> commit()) {
                // log error in such a way..
            }
        }
        
        public function update ($table, $values) {
            $keys = array_values(array_keys($values));
            $updates = $this -> parsePredicates($keys, ',');
            $statement = $this -> mysqli -> prepare('UPDATE ' . $table . ' SET ' . $updates);
            
            $params = array_values($values);
            $bind_names = $this -> extractBindParamsFormat($params);
            for ($i = 0; $i < count($params); $i++) {
                $bind_name = 'bind' . $i;
                $$bind_name = $params[$i];
                $bind_names[] = &$$bind_name;
            }
            
            call_user_func_array(array($statement, 'bind_param'), $bind_names);
            $statement -> execute();
            
            if (!$this -> mysqli -> commit()) {
                // log error in such a way..
            }
        }
        
        public function updateWhere ($table, $values, $predicates) {

            $updates = $this -> parsePredicates($values, ',');
            $conditions = $this -> parsePredicates($predicates);

            $sql = 'UPDATE ' . $table . ' SET ' . $updates . ' WHERE ' . $conditions;
            $statement = $this -> mysqli -> prepare('UPDATE ' . $table . ' SET ' . $updates . ' WHERE ' . $conditions);

            $params1 = array_values($values);
            $params2 = array_values($predicates);
            $params = array_merge($params1, $params2);
            $bind_names = $this -> extractBindParamsFormat($params);
            for ($i = 0; $i < count($params); $i++) {               
                $bind_name = 'bind' . $i;
                $$bind_name = $params[$i];
                $bind_names[] = &$$bind_name;
            }

            call_user_func_array(array($statement, 'bind_param'), $bind_names);
            $statement -> execute();
            
            if (!$this -> mysqli -> commit()) {
                // log error in such a way..
                return false;
            }
            return true;
        }
        
        public function getIterator() {
            return new ArrayIterator($this -> _data);
        }
        
        function parseWildChars ($fields) {
            if (count($fields) == 0)
                return '';
            $wildchars = '?';
            for ($i = 1; $i < count($fields); $i++) {
                $wildchars = $wildchars . ', ?';
            }
            
            return $wildchars;
        }
        
        function parseFields ($fields) {
            if (count($fields) == 0)
                return null;
            
            $columns = $fields[0];
            for ($i = 1; $i < count($fields); $i++) {
                $columns = $columns . ', ' . $fields[$i];
            }
            return $columns;
        }
        
        function parsePredicates ($predicates, $sep = 'OR') {
            if (count($predicates) == 0)
                return null;

            $conditions = '';
            for ($i = 0; $i < count($predicates); $i++) {
                $key = key($predicates);
                $conditions = $conditions . $key . " = ? ";
                
                if ($i < count($predicates) - 1) {
                    $conditions = $conditions . $sep . ' ';
                }
                
                next($predicates);
            }           
            return $conditions;
        }
        
        function extractBindParamsFormat ($values) {
            $types = '';
            foreach($values as $value)
            {
                if(is_int($value)) {
                    // Integer
                    $types .= 'i';
                } elseif (is_float($value)) {
                    // Double
                    $types .= 'd';
                } elseif (is_string($value)) {
                    // String
                    $types .= 's';
                } else {
                    // Blob and Unknown
                    $types .= 'b';
                }
            }       
            $bind_names[] = $types;
            
            return $bind_names;
        }
        
        function fetch ($statement) {
            $result = $statement -> get_result();
            $this -> _data = array();
            while ($row = $result -> fetch_assoc()) {
                $this -> _data[] = $row;
            }
            
            $result -> close();
        }
    }

    $dblayer = new DbLayer();
?>



