<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    public function welcomeinfo()
    {
        $list = new Article();
        $list = $list->getWelcomeInfo();
        //$list['article_content']=html_entity_decode($list['article_content']);
        foreach ($list as $item) {
            $item['article_content'] = strip_tags($item['article_content']);
            $item['article_content'] = $Content = preg_replace("/&#?[a-z0-9]+;/i", " ", $item['article_content']);
        }
        return response()->json($list);
    }
}
