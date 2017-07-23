<?php
/**
 */
class WpLinks extends LiteRecord
{
	#
    static function all()
    {
    	$sql = "SELECT link_url, link_name, link_target, link_description, link_rel FROM wp_links WHERE link_visible='Y'";
        $a = parent::all($sql);
        return $a;
    }
}
