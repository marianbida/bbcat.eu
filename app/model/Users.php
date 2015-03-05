<?php
class Users extends MDB{
	public function __construct()
	{
		parent::__construct();
		$this->table = "users";
	}
	public function getList()
	{
		$list = array();
		$q = "select * from `{$this->table}` order by `first_name` asc;";
		$r = $this->q( $q );
		if( $r->num_rows > 0 )
		{
			while( $o = $r->fetch_object() )
			{
				$list[] = $o;
			}
		}
		return $list;
	}
	function get( $user_id )
	{
		$q = "select * from `{$this->table}` where `id` = '$user_id';";
		$r = $this->q( $q );
		if( $r->num_rows == 1 )
		{
			return $r->fetch_object();
		}else{
			return FALSE;
		}
	}
	function edit( $data )
	{
		$q = "update `{$this->table}` set `first_name` = \"{$data['first_name']}\", `last_name` = \"{$data['last_name']}\", `newsletter` = \"{$data['newsletter']}\", `email` = \"{$data['email']}\" where `id` = \"{$data['id']}\" limit 1;";
		$this->q( $q );
		return $this->affected_rows ? TRUE : FALSE;
	}
	function getNewsletterUsers()
	{
		$list = array();
		$q = "select `id`,`first_name`,`last_name`,`email` from `{$this->table}` where `newsletter` = 1 order by `first_name` asc;";
		$r = $this->q( $q );
		if( $r->num_rows > 0 )
		{
			while( $o = $r->fetch_object() )
			{
				$list[] = $o;
			}
		}
		return $list;
	}
	function remove( $user_id )
	{
		$q = "delete from `{$this->table}` where `id` = '$user_id';";
		$r = $this->q( $q );
		return $this->affected_rows ? TRUE : FALSE;
	}
}