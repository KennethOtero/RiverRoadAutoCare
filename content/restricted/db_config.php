<?php
class Calendar {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo = null;
  private $stmt = null;
  public $error = "";
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (Exception $ex) { exit($ex->getMessage()); }
  }

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  // (C) HELPER - EXECUTE SQL QUERY
  function exec ($sql, $data=null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
      return true;
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
  }

  // (D) SAVE EVENT
  function save ($start, $end, $txt, $color, $id=null) {
    // (D1) START & END DATE QUICK CHECK
    $uStart = strtotime($start);
    $uEnd = strtotime($end);
    if ($uEnd < $uStart) {
      $this->error = "End date cannot be earlier than start date";
      return false;
    }

    // (D2) SQL - INSERT OR UPDATE
    if ($id==null) {
      $sql = "INSERT INTO `TEvents` (`event_start`, `event_end`, `event_text`, `event_color`) VALUES (?,?,?,?)";
      $data = [$start, $end, $txt, $color];
    } else {
      $sql = "UPDATE `TEvents` SET `event_start`=?, `event_end`=?, `event_text`=?, `event_color`=? WHERE `event_id`=?";
      $data = [$start, $end, $txt, $color, $id];
    }

    // (D3) EXECUTE
    return $this->exec($sql, $data);
  }

  // (E) DELETE EVENT
  function del ($id) {
    return $this->exec("DELETE FROM `TEvents` WHERE `event_id`=?", [$id]);
  }

  // (F) GET TEvents FOR SELECTED MONTH
  function get ($month, $year) {
    // (F1) FIRST & LAST DAY OF MONTH
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dayFirst = "{$year}-{$month}-01 00:00:00";
    $dayLast = "{$year}-{$month}-{$daysInMonth} 23:59:59";

    // (F2) GET TEvents
    if (!$this->exec(
      "SELECT * FROM `TEvents` WHERE (
        (`event_start` BETWEEN ? AND ?)
        OR (`event_end` BETWEEN ? AND ?)
        OR (`event_start` <= ? AND `event_end` >= ?)
      )", [$dayFirst, $dayLast, $dayFirst, $dayLast, $dayFirst, $dayLast]
    )) { return false; }

    // $TEvents = [
    //  "e" => [ EVENT ID => [DATA], EVENT ID => [DATA], ... ],
    //  "d" => [ DAY => [EVENT IDS], DAY => [EVENT IDS], ... ]
    // ]
    $TEvents = ["e" => [], "d" => []];
    while ($row = $this->stmt->fetch()) {
      $eStartMonth = substr($row["event_start"], 5, 2);
      $eEndMonth = substr($row["event_end"], 5, 2);
      $eStartDay = $eStartMonth==$month
                 ? (int)substr($row["event_start"], 8, 2) : 1 ;
      $eEndDay = $eEndMonth==$month
               ? (int)substr($row["event_end"], 8, 2) : $daysInMonth ;
      for ($d=$eStartDay; $d<=$eEndDay; $d++) {
        if (!isset($TEvents["d"][$d])) { $TEvents["d"][$d] = []; }
        $TEvents["d"][$d][] = $row["event_id"];
      }
      $TEvents["e"][$row["event_id"]] = $row;
      $TEvents["e"][$row["event_id"]]["first"] = $eStartDay;
    }
    return $TEvents;
  }
}

// (G) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "itd2.cincinnatistate.edu");
define("DB_NAME", "02CPDM290OteroK");
define("DB_CHARSET", "utf8");
define("DB_USER", "kjotero2");
define("DB_PASSWORD", "0646911");

// (H) NEW CALENDAR OBJECT
$_CAL = new Calendar();
