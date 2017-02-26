<?php
/**
 */
class BlogController extends AppController
{
    #
    public function index($year='', $month='', $day='', $slug='')
    {
        if ($slug) :
            $this->post = (new WpPosts)->one($slug);
            $this->tags = (new WpTerms)->tagsByPost($this->post);
            View::select('post');
        else :
            $this->posts = (new WpPosts)->all(10, $year, $month, $day);
            View::select('posts');
        endif;

        $this->aside();
    }

    #
    public function aside()
    {
        $this->categories = (new WpTerms)->categories();
        $this->last_posts = (new WpPosts)->all(3);
    }

    #
    public function author($author)
    {
        $this->aside();
        $this->posts = (new WpPosts)->byAuthor($author);
        $this->main_header = $author;
        $this->header_type = 'Autor:';
        View::select('posts');
    }

    #
    public function category($category)
    {
        $this->aside();
        $this->posts = (new WpPosts)->byTerm('category', $category);
        $this->main_header = mb_strtoupper($category);
        $this->header_type = 'Categoría:';
        View::select('posts');
    }

    #
    public function tag($tag)
    {
        $this->aside();
        $this->posts = (new WpPosts)->byTerm('post_tag', $tag);
        $this->main_header = mb_strtoupper($this->posts[0]->name);
        $this->header_type = 'Etiqueta:';
        View::select('posts');
    }
}
