<?php
/**
 */
class WpUsers extends LiteRecord
{
	#
    public function byID($cols='display_name')
    {
    	$sql = "SELECT ID, $cols FROM wp_users";
        $users = parent:all($sql);
        foreach ($users as $o) $a[$o->ID] = $o;
        return $a;
    }
}
