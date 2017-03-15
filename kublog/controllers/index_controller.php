<?php
/**
 */
class IndexController extends AppController
{
    public function index()
    {
        Redirect::to('/blog/');
        return false;
    }
}
