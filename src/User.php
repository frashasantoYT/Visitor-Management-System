<?php
class User {
    public $id;
    public $username;
    public $password;
    public $role;
    public $is_active;

    function __construct($username, $password, $role, $is_active = true) {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->is_active = $is_active;
    }
}
?>
