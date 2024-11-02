<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Article;
use Deljdlx\WPTaverne\Models\Character;

class Home extends Base
{
    public function index()
    {
        $articles = Article::getAll();

        $buffer = $this->renderTemplate('layouts.home', [
            'articles' => $articles,
        ]);
        return $buffer;
    }
}

