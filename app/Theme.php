<?php
session_start();

require_once "includes/helpers.php";
require_once "classes/ThemeBase.php";
require_once "classes/ThemeWoo.php";

class Theme extends ThemeBase
{
    private $woo;

    protected function __construct()
    {
        parent::__construct();
        $this->woo = new ThemeWoo();
    }

    public function woo()
    {
        return $this->woo;
    }

    public function views()
    {
        return new class
        {
            public function miniCart()
            {
                get_template_part('views/mini-cart');
            }

            public function miniWishlist()
            {
                get_template_part('views/mini-wishlist');
            }

            public function social()
            {
                get_template_part('views/social');
            }
        };
    }

    public function pagination()
    {
        $prev = file_get_contents(path() . 'assets/img/icons/left-arrow.svg');
        $next = file_get_contents(path() . 'assets/img/icons/right-arrow.svg');
        the_posts_pagination([
            'show_all' => false,
            'end_size' => 2,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => $prev,
            'next_text' => $next,
        ]);
    }

}