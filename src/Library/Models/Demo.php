<?php

/**
 * Class Models_Demo
 */
class Models_Demo extends Models
{
    private static $_instance = NULL;

    final public static function getInstance()
    {
        if (!isset(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    function __construct()
    {
        parent::__construct();
        $this->rest     = REST_Server::instance();
        $this->_table   = 'common_account_info';
        $this->_primary = 'account_id';
    }

    function is_user($username, $pwd)
    {
        $sql = 'select ' . $this->_primary . ' from ' . $this->_table . ' where user_name = ? and user_pwd = ?';
        $a   = $this->db->getOne($sql, array($username, $pwd));

        return $a;
    }

    public function exits($where)
    {
        $_where = self::where($where);
        $back   = $this->db->getRow('select ' . $this->_primary . ' from ' . $this->_table . $_where['where_key'], $_where['where_value']);
        if (is_array($back) && count($back) > 0) {
            return $back;
        }

        return FALSE;
    }

    public function check_user($user_name)
    {
        if (!$this->exits(array('user_name' => $user_name))) {
            return FALSE;
        }

        return TRUE;
    }

    public function get_account_info($account_id)
    {
        $sql = 'select * from ' . $this->_table . ' where account_id = ?';
        $a   = $this->db->getRow($sql, array($account_id));

        return $a;
    }

    public function update_info($account_id, array $account_info)
    {
        return $this->db->update($this->_table, $account_info, array('account_id' => $account_id));
    }

}