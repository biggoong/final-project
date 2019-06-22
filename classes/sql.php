<?php
class sql
{
    private static $connect = false;
    private static $instance = false;

    public static function getInstance()
    {
        if (self::$instance == false) {
            self::$instance = new sql();
        }

        return self::$instance;
    }

    private function __clone()
    { }
    private function __wakeup()
    { }
    private function __construct()
    {
        if (self::$connect === false) {
            self::$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
            if (mysqli_connect_errno()) {
                echo mysqli_connect_error();
                die('SQL ERROR');
            }
        }
    }

    public function insert(string $table, array $data)
    {
        $columns = '';
        $values = '';
        foreach ($data as $name => $value) {
            $columns .= $columns == '' ? $name : ', ' . $name;
            $values .= $values == '' ? '\'' . $this->escape($value) . '\'' : ',\'' . $this->escape($value) . '\'';
        }
        $SQL = 'INSERT INTO ' . $table . ' (' . $columns . ') VALUES (' . $values . ')';
        return $this->query($SQL);
    }

    public function select(string $table, string $columns = '', array $where = [])
    {
        $SQL = 'SELECT ' . $columns . ' FROM ' . $table . $this->where($where);
        $res = $this->query($SQL);
        $out = [];
        while ($record = mysqli_fetch_assoc($res)) {
            $out[] = $record;
        }
        return $out;
    }

    public function select_column(string $table, string $columns = '*')
    {
        $SQL = 'SELECT ' . $columns . ' FROM ' . $table . ' WHERE 1';
        $res = $this->query($SQL);
        $out = [];
        while ($record = mysqli_fetch_assoc($res)) {
            $out[] = $record;
        }
        return $out;
    }

    public function select_join(
        string $from_table,
        string $columns = '*',
        string $join_table,
        string $on,
        array $where = [],
        string $order = ''
    ) {
        $SQL = 'SELECT ' . $columns . ' FROM ' . $from_table . ' join ' . $join_table . ' on ' . $on . $this->where($where) . $order;
        $res = $this->query($SQL);
        $out = [];
        while ($record = mysqli_fetch_assoc($res)) {
            $out[] = $record;
        }
        return $out;
    }

    public function select_count(string $table, string $columns = '*', array $where = [])
    {
        $SQL = 'SELECT count(' . $columns . ') FROM ' . $table . $this->where($where);
        $res = $this->query($SQL);
        $out = [];
        while ($record = mysqli_fetch_assoc($res)) {
            $out[] = $record;
        }
        return $out;
    }

    public function update($table, $data, $where)
    {
        $SQL = 'UPDATE ' . $table . ' SET ';
        $set = [];
        if (!is_array($data) || count($data) == 0) {
            throw new Exception('Data is not array');
        }
        foreach ($data as $f => $v) {
            $set[] = $f . '=\'' . $this->escape($v) . '\'';
        }
        $SQL .= implode(',', $set) . $this->where($where);
        return $this->query($SQL);
    }

    public function delete(string $table, array $where = [])
    {
        $SQL = 'DELETE FROM ' . $table . $this->where($where);
        $this->query($SQL);
    }

    public function where($where = [])
    {
        $WHERE = '';
        foreach ($where as $name => $value) {
            $operation = $name . '=\'' . $this->escape($value) . '\'';
            $WHERE .= $WHERE == '' ? ' WHERE ' . $operation : ' AND' . $operation;
        }
        return $WHERE;
    }

    public function escape(string $string)
    {
        return mysqli_escape_string(self::$connect, $string);
    }

    public function query($sql)
    {
        return mysqli_query(self::$connect, $sql);
    }
}
