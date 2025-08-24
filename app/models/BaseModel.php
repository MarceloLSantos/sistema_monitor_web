<?php
// ### app/models/BaseModel.php (abstract for common DB ops)
abstract class BaseModel {
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getInstance();
    }
}
?>