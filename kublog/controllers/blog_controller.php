<?php
/**
 */
class BlogController extends AppController
{
    #
    public function index($year='', $month='', $day='', $slug='')
    {
        if ($slug) :
            if ( ! empty($_POST['add_comment']) ) (new WpComments)->add($_POST);
            $this->post = (new WpPosts)->one($slug);
            $this->tags = (new WpTerms)->tagsByPost($this->post);
            $this->comments = (new WpComments)->all($this->post->ID);
            $this->n_comments = (new WpComments)->count($this->post->ID);
            $this->comment = ( Input::get('comment_ID') )
                ? (new WpComments)->one( Input::get('comment_ID') ) : '';
            View::select('post');
        else :
            $this->posts = (new WpPosts)->all($year, $month, $day);
            $this->n_comments = (new WpComments)->count();
            View::select('posts');
        endif;

        $this->aside();
    }

    #
    public function aside()
    {
        $this->categories = (new WpTerms)->categories();
        $this->links = (new WpLinks)->all();
        $this->last_posts = (new WpPosts)->latest(5);
        $this->last_comments = (new WpComments)->latest(4);
        $this->archive = (new WpPosts)->archive();
    }

    #
    public function author($author)
    {
        $this->aside();
        $this->posts = (new WpPosts)->byAuthor($author);
        $this->main_header = $this->posts[0]->display_name;
        $this->header_type = 'Autor:';
        $this->author = 1;
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
    public function search()
    {
        $this->aside();
        $this->posts = (new WpPosts)->byQuery($_GET['q']);
        $this->main_header = mb_strtoupper($_GET['q']);
        $this->header_type = 'Buscar:';
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
