<?php
/**
 */
class WpPosts extends ActiveRecord
{
    #
    public function one($slug)
    {

        if ( preg_match('/[^a-z\-]/', $slug) ) throw new KumbiaException('SLUG MALO');

        return $this->find_first("conditions: post_status='publish' AND post_name='$slug'");
    }

	#
    public function all($n=10, $year='', $month='', $day='')
    {
    	return $this->find("conditions: post_status='publish'", 
            "order: post_date DESC",
            "limit: $n");
    }

	#
    public function byTerm($term, $item)
    {
    	$sql = "SELECT p.post_name, p.post_title, p.post_date, p.post_author, p.post_content, t.name, t.slug 
    		FROM wp_posts p, wp_term_relationships tr, wp_term_taxonomy tt, wp_terms t
    		WHERE t.term_id=tt.term_id
    		AND p.ID=tr.object_id
    		AND tr.term_taxonomy_id=tt.term_taxonomy_id
    		AND tt.term_id=t.term_id
    		AND tt.taxonomy='$term'
    		AND t.slug='$item'
    	";
        $a = $this->find_all_by_sql($sql);
        return $a;
    }
}
