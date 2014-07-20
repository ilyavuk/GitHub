<?php
class MY_Pagination extends CI_Pagination {

    public function __construct() {
        parent::__construct();
    }

    public function set_cur_page($var) {
        $this->cur_page = $var;
    }
}