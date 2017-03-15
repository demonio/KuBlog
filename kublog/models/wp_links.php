<?php
/**
 */
class WpLinks extends ActiveRecord
{
	#
    public function all()
    {
        $a = $this->find("columns: link_url, link_name, link_target, link_description, link_rel",
        	"conditions: link_visible='Y'");
        return $a;
    }
}
