<?php
/**
 */
class WpLinks extends LiteRecord
{
	#
    public function allLinks()
    {
    	$sql = "SELECT link_url, link_name, link_target, link_description, link_rel FROM wp_links WHERE link_visible='Y' ORDER BY link_name";
        $a = $this->all($sql);
        return $a;
    }
}
