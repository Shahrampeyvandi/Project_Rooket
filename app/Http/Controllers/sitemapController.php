<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class sitemapController extends Controller
{
    //baraye estefade az sitemap behtar ast etelaat ra be soorate cache vared konim
    //chon sitemap be soorate roozane estefade mishavad va chon daryaft etelaat momken ast tool bakeshad
    // banabarin etelaat ra cache mikonim
    public function index()
    {
        $sitemap = app()->make('sitemap'); //vendor register roumen/sitemap
        $sitemap->setCache('laravel.sitemap' , 60);

        if (!$sitemap->isCached()){
            // manual item for sitemap add to method :
            //add($url, $date, priority , time);
            $sitemap->addSitemap(url()->to('sitemap-articles'));
        }

        return $sitemap->render('sitemapindex');
    }

    public function articles()
    {
        $sitemap = app()->make('sitemap'); //vendor register roumen/sitemap
        $sitemap->setCache('laravel.sitemap.articles' , 60);
        if (!$sitemap->isCached()) {
            $articles = Article::latest()->get();
            foreach ($articles as  $article){
                $sitemap->add(url()->to($article->path()),$article->created_at,'0.9','daily');

            }

        }
        return $sitemap->render();
    }
}
