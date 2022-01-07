<?php

namespace Elit1\ObjectOriented;

use ADOConnection;
use ADODB_mysql;
use ADODB_mysqli;
use ADORecordSet;
use ADORecordSet_array;
use ADORecordSet_empty;
use Elit1\ObjectOriented\Helpers\ChangeKeyCase;
use Elit1\ObjectOriented\Helpers\FlattenArray;
use Elit1\ObjectOriented\Helpers\PreparedQMark2SqlValue;

class Database
{
    private ADODB_mysqli | ADOConnection | ADODB_mysql | false $db;
    private int $lastmysqlrow = -1;
    private bool $isdb_default_utf8_charset = false;
    private string $default_charset = 'UTF-8';
    private bool $avoidPreparedSql = false;

    public static function getInstance (): static
    {
        return new static();
    }

    public function __construct ()
    {
        $this->connect();
    }

    private function connect ($dbDriver = 'mysqli')
    {
        $db = ADONewConnection($dbDriver);
        $db->connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'), getenv('DB_PORT'));
        if ($db->isConnected()) {
            $this->db = $db;
        }
    }

    /**
     * Convert PreparedStatement to SQL statement
     */
    public function convert2Sql ($ps, $vals)
    {
        if (empty($vals)) {
            return $ps;
        }
        for ($index = 0; $index < count($vals); $index++) {
            // Package import pushes data after XML parsing, so type-cast it
            if (is_a($vals[$index], 'SimpleXMLElement')) {
                $vals[$index] = (string)$vals[$index];
            }
            if (is_string($vals[$index])) {
                $vals[$index] = $this->db->qstr($vals[$index]);
            }
            if ($vals[$index] === null) {
                $vals[$index] = "NULL";
            }
        }
        return preg_replace_callback("/('[^']*')|(\"[^\"]*\")|([?])/", [new PreparedQMark2SqlValue($vals), "call"], $ps);
    }

    public function getRecords (string $sql, array $params = []): array
    {
        $recordSet = $this->pquery($sql, $params);
        $records = [];
        while ($row = $this->fetchByAssoc($recordSet)) {
            $records[] = $row;
        }
        return $records;
    }

    public function insert (string $table, array $record)
    {
        $this->db->autoExecute($table, $record);
    }

    public function update (string $table, array $record, string $where)
    {
        $this->db->autoExecute($table, $record, 'UPDATE', $where);
    }

    public function delete (string $table, array $record)
    {
        $this->db->autoExecute($table, $record, 'DELETE');
    }

    public function fetchByAssoc ($result, $rowNum = -1, $encode = true)
    {
        if (is_object($result)) {
            if ($result->EOF) {
                return null;
            }
            if ($rowNum < 0) {
                $row = ChangeKeyCase::change($result->GetRowAssoc(false));
                $result->MoveNext();
                if ($encode && is_array($row)) {
                    return array_map('htmlentities', $row);
                }
                return $row;
            }

            if ($this->getRowCount($result) > $rowNum) {
                $result->Move($rowNum);
            }
            $this->lastmysqlrow = $rowNum;
            $row = ChangeKeyCase::change($result->GetRowAssoc(false));
            $result->MoveNext();

            if ($encode && is_array($row)) {
                return array_map('htmlentities', $row);
            }
            return $row;
        }

        return [];
    }

    private function checkConnection ()
    {
        if (!isset($this->db)) {
            $this->connect(false);
        }
    }


    /**
     * @param          $sql
     * @param  array   $params
     * @param  bool    $dieOnError
     * @param  string  $msg
     *
     * @return ADORecordSet|ADORecordSet_array|ADORecordSet_empty|bool|void|null
     */
    public function pquery ($sql, array $params = [], bool $dieOnError = false, string $msg = 'Error in query')
    {
        $this->checkConnection();

        $this->executeSetNamesUTF8SQL();

        $params = FlattenArray::flatten($params);

        if ($this->avoidPreparedSql || empty($params)) {
            $sql = $this->convert2Sql($sql, $params);
            $recordSet = $this->db->Execute($sql);
            $result = &$recordSet;
        } else {
            $recordSet1 = $this->db->Execute($sql, $params);
            $result = &$recordSet1;
        }

        $this->lastmysqlrow = -1;
        if (!$result) {
            if ($dieOnError) {
                die($msg);
            }
        }

        return $result;
    }

    private function executeSetNamesUTF8SQL (bool $force = false)
    {
        // Performance Tuning: If database default charset is UTF-8, we don't need this
        if (strtoupper($this->default_charset) === 'UTF-8' && ($force || !$this->isdb_default_utf8_charset)) {
            $this->db->Execute("SET NAMES utf8");
        }
    }

    public function hasAffectedRows(): bool
    {
        return $this->db->Affected_Rows();
    }


    /* ADODB newly added. replacement for mysql_num_rows */
    public function num_rows ($result)
    {
        return $this->getRowCount($result);
    }

    private function getRowCount ($result)
    {
        if (isset($result) && !empty($result)) {
            $rows = $result->RecordCount();
        }
        return $rows ?? null;
    }


    public function disconnect ()
    {
        if (isset($this->database)) {
            $this->database->disconnect();
            unset($this->database);
        }
    }

}