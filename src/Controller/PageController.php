<?php

namespace App\Controller;

class PageController extends Controller
{
    public function home()
    {
        $this->render("home");
    }
}