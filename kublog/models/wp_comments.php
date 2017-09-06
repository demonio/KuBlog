<?php
/**
 */
class WpComments extends LiteRecord
{
    #
    public function add($post)
    { 
        if ($post['telefono']) return;
        $comment_post_ID = filter_var($post['post_ID'], FILTER_SANITIZE_NUMBER_INT);
        $comment_author = strip_tags($post['author']);
        $comment_author_email = filter_var($post['email'], FILTER_SANITIZE_EMAIL);
        $comment_author_url = filter_var($post['url'], FILTER_SANITIZE_URL);
        $comment_author_ip = $_SERVER['REMOTE_ADDR'];
        $comment_date = date('Y-m-d H:i:s');
        $comment_date_gmt = date('Y-m-d H:i:s');
        $comment_content = strip_tags($post['comment']);
        $comment_karma = 0;
        $comment_approved = 1;
        $comment_agent = $_SERVER['HTTP_USER_AGENT'];
        $comment_type = '';
        $comment_parent = (int)$post['parent'];
        $user_id = 0;

        $sql = "INSERT INTO wp_comments SET
            comment_post_ID=?,
            comment_author=?,
            comment_author_email=?,
            comment_author_url=?,
            comment_author_ip=?,
            comment_date=?,
            comment_date_gmt=?,
            comment_content=?,
            comment_karma=?,
            comment_approved=?,
            comment_agent=?,
            comment_type=?,
            comment_parent=?,
            user_id=?
        ";
        static::query($sql,
        [
            $comment_post_ID, 
            $comment_author, 
            $comment_author_email, 
            $comment_author_url, 
            $comment_author_ip,
            $comment_date,
            $comment_date_gmt,
            $comment_content,
            $comment_karma,
            $comment_approved,
            $comment_agent,
            $comment_type,
            $comment_parent,
            $user_id
        ]);
    }

	#
    static function all($post_id)
    {        
    	$sql = "SELECT
                c.comment_ID, 
                c.comment_author, 
                c.comment_author_email, 
                c.comment_author_url, 
	    		c.comment_date, 
	    		c.comment_content, 
	    		c.comment_parent
            FROM wp_posts p, wp_comments c
            WHERE c.comment_post_ID=p.ID
            AND c.comment_post_ID=?
            AND c.comment_approved=1
            ORDER BY c.comment_date
        ";
        $a = parent::all($sql, [$post_id]);
        return $a;
    }

	# ULTIMOS COMENTARIOS A PRIORI PARA EL ASIDE
    public function latest($n=4)
    {        
        $n = (int)$n;
    	$sql = "SELECT c.comment_ID, c.comment_author, c.comment_author_url, p.post_date, p.post_title, p.post_name
            FROM wp_posts p, wp_comments c
            WHERE c.comment_post_ID=p.ID
            AND c.comment_approved=1
            ORDER BY c.comment_date DESC
            LIMIT $n
        ";
        $a = parent::all($sql);
        return $a;
    }

    # CUENTA EL NUMERO DE COMENTARIOS QUE TIENE CADA POSTS
    public function count($id=0)
    {
        $sql = "SELECT c.comment_post_ID
            FROM wp_comments c
            WHERE c.comment_approved=1
        ";
        if ($id) $sql .= " AND comment_post_ID=?";
        $comments = parent::all($sql, [$id]);
        if ( ! $comments ) return;
        foreach ($comments as $o)
        {
            $a[$o->comment_post_ID] = empty($a[$o->comment_post_ID]) ? 1 : ++$a[$o->comment_post_ID];
        }
        return $a;
    }

    #
    public function one($id)
    {        
        $sql = "SELECT * FROM wp_comments c WHERE c.comment_ID=?";
        $a = $this->first($sql, [$id]);
        return $a;
    }
}
