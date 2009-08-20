<?php

require_once(dirname(__file__).'/../Util/Auth.php');
require_once(dirname(__file__).'/Controller.php');

class DbController extends Controller {

    var $table = 'sometablename';
    
    var $maintable = null;

    // Params to fields mapping
    var $mapping = array(
        'id' => 'id',
        'name' => 'name',
        'example_name' => 'another_name_in_table',
        'shortname' => 'name_in_table'
    );
    
    // Filters patterns for sql where clauses
    var $filters = array('id'); //'name_in_table' => '%name_in_table%');

    // Mandatory params for put operations
    var $put = array(); //'name', 'example_name');
    
    // Mandatory params for delete operations
    var $delete = array(); //'name', 'example_name');

    // Response returned fields from table
    var $return = array('id', 'name');

    var $orderBy = null; //'id';
    var $order = null; //'ASC';

    var $dsn = null;

    function __construct($params = array(), $dsn = null) {
        $this->dsn = $dsn ? $dsn : Config::get('dsn');
        $this->maintable = trim(array_shift(explode(',', $this->table)));
        parent::__construct($params);
    }

    function get() {
        $sql = $this->getSqlSelect();
        $sql .= $this->getSqlFrom();
        $sql .= $this->getSqlWhere();
        $sql .= $this->getSqlJoin();
        $sql .= $this->getSqlMisc();
        return $this->query($sql);
    }

    function post() {
        // 201 Created or 304 Not Modified or 409 Conflict
        // Ensures for mandatory fields presence
        if (array_intersect($this->put, array_keys($this->params)) != $this->put)
            throw new Exception("Missing mandatory params for put action");
        // Starts sql generation
        $updates = array();
        foreach ($this->getFieldsValues(false) as $field => $valueh) {
            $updates[] = "{$field} = '{$valueh['value']}'";
        }
        // Creates final sql
        $sql = "UPDATE {$this->maintable} SET";
        $sql .= implode(', ', $updates);
        $sql .= $this->getSqlWhere();
        return $this->query($sql);        
    }

    function put() {
        // 201 Created or 304 Not Modified or 409 Conflict
        // Ensures for mandatory fields presence
        if (array_intersect($this->put, array_keys($this->params)) != $this->put)
            throw new Exception("Missing mandatory params for put action");
        // Starts sql generation
        $fieldsValues = $this->getFieldsValues(false);
        $sqlF = $sqlV = array();
        foreach ($fieldsValues as $field => $valueh) {
            $sqlF[] = $field;
            $sqlV[] = "'{$valueh['value']}'";
        }
        // Creates final sql
        $sql = "INSERT INTO {$this->maintable}".
            " (".implode(', ', $sqlF).") VALUES (".implode(', ', $sqlV).")";
        return $this->query($sql);        
    }

    function delete() {
        // 404 Not Found or 200 OK (default)
        // Ensures mandatory fields presence
        if (array_intersect($this->delete, array_keys($this->params)) != $this->delete)
            throw new Exception("Missing mandatory params for delete action");
        // Starts sql generation
        $sql = "DELETE FROM {$this->maintable}" .
            $this->getSqlWhere(false);
        return $this->query($sql);
    }
    
    function count() {
        $sql = "SELECT count(" . array_shift($this->mapping) . ") as count";
        $sql .= $this->getSqlFrom();
        $sql .= $this->getSqlWhere();
        $sql .= $this->getSqlJoin();
        $sql .= $this->getSqlMisc();
        return array_shift($this->query($sql));
    }



    // Returns a table_field => value mapping array from http request
    function getFieldsValues($usePatterns = true) {
        $mapping = array();        
        foreach ($this->params as $paramname => $paramvalue) {
            if (!array_key_exists($paramname, $this->mapping)) continue;
            $field = $this->mapping[$paramname];
            $value = $usePatterns && array_key_exists($paramname, $this->filters) ?
                // applying filter pattern to value
                str_replace(
                    $field,                // replaces field name
                    $paramvalue,           // by param value
                    $this->filters[$field] // in field pattern
                ) : $paramvalue;
            $mapping[$field] = array(
                value => $value,
                wildcard => $value !== $paramvalue
            );
        }
        return $mapping;
    }

    function getSqlSelect() {
        return " SELECT ".implode(', ', $this->return);
    }

    function getSqlFrom() {
        return " FROM {$this->table}";
    }
    
    function getSqlWhere($usePattern = true) {
        $sql = ' WHERE 1=1';
        foreach ($this->getFieldsValues($usePattern) as $field => $valueh) {
            $sql .= " AND {$field}";
            $sql .= $valueh['wildcard'] ? " LIKE" : " =";
            $sql .= " '".addslashes($valueh['value'])."'";
        }
        return $sql;
    }

    function getSqlJoin() {
        return '';
    }

    function getSqlMisc() {
        if ($this->order && $this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy} {$this->order}";
        }
        if ($this->params['limit']) {
            $this->params['offset'] = $this->params['offset'] ? $this->params['offset'] : 0;
            $sql .= " LIMIT {$this->params['offset']},{$this->params['limit']}";
        }
        return $sql;
    }

    function getSqlWhereFulltextSearch($paramname, $searchfields) {
        // multifields, fulltext where clause
        if (!isset($this->params[$paramname])) return $sql;
        $fulltext = $this->params[$paramname];
        if (!$fulltext) return $sql;
        $sql .= ' AND ( 0';
        foreach (explode(' ', $fulltext) as $text) {
            foreach ($searchfields as $searchfield) {
                if (!empty($fulltext)) $sql .= " OR {$searchfield} LIKE '%{$text}%'";
            }
        }
        $sql .= ' )';
        return $sql;
    }

    function query($sql) {
        // TODO: use an abstaction layer framework, for integrator comfort
        // preg_replace non [\s\d] with % ? seems good enough to allow only alphanumerics
        // apply mysql_real_escape_string($sql) on conditions values ?
        // Connects to database
        $m = $this->parse($this->dsn);
        $db = @mysql_connect($m['host'], $m['user'], $m['passwd']);
        if (!$db) throw new Exception("Failed to connect to database server"); //header("HTTP/1.0 500 Internal Server Error");
        @mysql_select_db($m['db']);
        // Executes query
        $qr = mysql_query($sql);
        mysql_close();
        if (!$qr) throw new Exception("Invalid query: {$sql} ###" . mysql_error($db));
        // Creates an array of results
        if (is_resource($qr)) {
            $result = array();
            while ($row = mysql_fetch_assoc($qr)) {
                $result[] = $row;
            }
        } else {
            $result = array(
                insertid => mysql_insert_id($db),
                affectedrows => mysql_affected_rows($db),
                raw => $qr
            );
        }
        // Debug information
        if (isset($_REQUEST['debug'])) Util::debug(
            'DbController debug',
            'Query:', $sql,
            'Result:', $result);
        return $result;
    }

    function parse($dsn) {
        preg_match("/(.+):\/\/(.+)\:(.+)@(.+)\/(.+)/", $dsn, $m);
        return array(
            'type' => $m[1],
            'user' => $m[2],
            'passwd' => $m[3],
            'host' => $m[4],
            'db' => $m[5]
        );
    }
}

?>
