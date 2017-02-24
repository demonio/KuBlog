<?php
/**
 */
class WpTerms extends ActiveRecord
{
    #
    public function categories()
    {
        $sql = "SELECT t.name, t.slug 
            FROM wp_terms t, wp_term_taxonomy tt
            WHERE t.term_id=tt.term_id
            AND tt.taxonomy='category'";
        $a = $this->find_all_by_sql($sql);
        return $a;
    }

    #
    public function tagsByPost($post)
    {
        if ( empty($post->ID) ) throw new KumbiaException('NO HAY POST');

        $sql = "SELECT t.name, t.slug 
            FROM wp_posts p, wp_term_relationships tr, wp_term_taxonomy tt, wp_terms t
            WHERE t.term_id=tt.term_id
            AND p.ID=tr.object_id
            AND tr.term_taxonomy_id=tt.term_taxonomy_id
            AND tt.term_id=t.term_id
            AND tt.taxonomy='post_tag'
            AND tr.object_id='$post->ID'
        ";
        $a = $this->find_all_by_sql($sql);
        return $a;
    }
}
