<?php

class Visitor {
    public $id;
    public $name;
    public $email;
    public $phone;
    public $visit_date;
    public $purpose;
    public $remarks;

    function __construct($name, $email, $phone, $visit_date, $purpose, $remarks) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->visit_date = $visit_date;
        $this->purpose = $purpose;
        $this->remarks = $remarks;
    }
}
?>
