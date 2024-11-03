<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Article;
use Deljdlx\WPTaverne\Models\Character;

class PageNotFound extends Base
{
    public function index()
    {
        $articles = Article::getAll();

        $buffer = $this->renderTemplate('layouts.404', [
        ]);
        return $buffer;
    }
}

