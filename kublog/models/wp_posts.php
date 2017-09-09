<?php
/**
 */
class WpPosts extends LiteRecord
{
    #
    public function one($slug)
    {
        if ( preg_match('/[^a-z0-9\-]/', $slug) ) throw new KumbiaException('SLUG MALO');

        $sql = "SELECT p.ID, p.post_name, p.post_title, p.post_date, p.post_author, p.post_content, u.user_nicename, u.user_email, u.display_name 
            FROM wp_posts p, wp_users u
            WHERE p.post_author=u.ID
            AND p.post_status='publish'
            AND p.post_name=?
        ";
        $a = (object)$this->first($sql, [$slug])->values;
        return $a;
    }

    #
    public function allPost($year='', $month='', $day='')
    {
        $sql = "SELECT p.ID, p.post_name, p.post_title, p.post_date, p.post_author, p.post_content, u.user_nicename, u.user_email, u.display_name 
            FROM wp_posts p, wp_users u
            WHERE p.post_author=u.ID
            AND p.post_status='publish'
            AND p.post_type='post'";
        $values = [];
        if ($day) :
            $sql .= " AND p.post_date LIKE ?";
            $values[] = "$year-$month-$day%";
        elseif ($month) :
            $sql .= " AND p.post_date LIKE ?";
            $values[] = "$year-$month%";
        elseif ($year) :
            $sql .= " AND p.post_date LIKE ?";
            $values[] = "$year%";
        endif;
        $sql .= " ORDER BY p.post_date DESC LIMIT 10";
        $a = parent::all($sql, $values);
        return $a;
    }

    #
    public function latest($n=5)
    {
        $n = (int)$n;
        $sql = "SELECT p.post_date, p.post_title, p.post_name
            FROM wp_posts p
            WHERE p.post_status='publish'
            AND p.post_type='post'
            ORDER BY p.post_date DESC
            LIMIT $n
        ";
        $a = $this->all($sql);
        return $a;
    }

    #
    public function archive()
    {
        $sql = "SELECT p.post_date
            FROM wp_posts p
            WHERE p.post_status='publish'
            AND p.post_type='post'
            ORDER BY p.post_date DESC
        ";
        $posts = $this->all($sql);
        $a = [];
        foreach ($posts as $o)
        {
            $time = strtotime($o->post_date);
            $post_date = date('Y-m', $time); 
            $a[$post_date] = empty($a[$post_date]) ? 1 : ++$a[$post_date];
        }
        return $a;
    }

    #
    public function byAuthor($author)
    {
        if ( preg_match('/[^0-9a-z_ \-]/i', $author) ) throw new KumbiaException('AUTOR MALO');

        $sql = "SELECT p.ID, p.post_name, p.post_title, p.post_date, p.post_author, p.post_content, u.user_nicename, u.user_email, u.user_url, u.display_name
            FROM wp_posts p, wp_users u
            WHERE p.post_author=u.ID
            AND p.post_status='publish'
            AND u.user_nicename=?
        ";
        $a = $this->all($sql, [$author]);
        $sql = "SELECT meta_value FROM wp_usermeta WHERE user_id={$a[0]->ID} AND meta_key='description'";
        $b = $this->first($sql);
        $a[0]->description = $b->meta_value;
        return $a;
    }

    #
    public function byQuery($q)
    {
        if ( preg_match('/[^0-9a-z_ \-]/i', $q) ) throw new KumbiaException('QUERY MALO');

        $sql = "SELECT p.ID, p.post_name, p.post_title, p.post_date, p.post_author, p.post_content, u.user_nicename, u.user_email, u.user_url, u.display_name
            FROM wp_posts p, wp_users u
            WHERE p.post_author=u.ID
            AND p.post_status='publish'
            AND (p.post_title LIKE ? OR p.post_content LIKE ?)
        ";
        $a = $this->all($sql, ["%$q%", "%$q%"]);
        return $a;
    }

    #
    public function byTerm($term, $item)
    {
        $sql = "SELECT p.ID, p.post_name, p.post_title, p.post_date, p.post_author, p.post_content, t.name, t.slug, u.user_nicename, u.user_email, u.display_name
            FROM wp_posts p, wp_term_relationships tr, wp_term_taxonomy tt, wp_terms t, wp_users u
            WHERE t.term_id=tt.term_id
            AND p.ID=tr.object_id
            AND tr.term_taxonomy_id=tt.term_taxonomy_id
            AND tt.term_id=t.term_id
            AND tt.taxonomy=?
            AND t.slug=?
            AND p.post_author=u.ID
        ";
        $a = $this->all($sql, [$term, $item]);
        return $a;
    }
}
