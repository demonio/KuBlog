<?php
/**
 */
class WpUsers extends ActiveRecord
{
	#
    public function byID($cols='display_name')
    {
        $users = $this->find("columns: ID, $cols");
        foreach ($users as $o) $a[$o->ID] = $o;
        return $a;
    }
}
