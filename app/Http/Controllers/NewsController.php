<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Config;
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\News_card;
use App\User; 

class NewsController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$news = News_card::orderBy('created_at', 'desc')->get();
		$refined = [];
		if(count($news) > 0){
            // preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $news[0]->content, $image);
			// $firstImg = $image['src'];
			foreach($news as $key => $value){
				preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $value->content, $image);
				if($image && $image['src']){
					$firstImg = $image['src'];
				}else{
					$firstImg = '';
				}
				$pureStr = strip_tags($value->content ,"<p>");
				$pureStr1 = substr($pureStr,0, 900).'...';
				$pureStr2 = substr($pureStr,0, 80).'...';
				$pureStr3 = substr($pureStr,0, 400).'...';
				str_replace('style="text-align:center"', 'style="text-align:center;margin:0 auto;padding-bottom:1rem"', $value->content);
				array_push($refined, ['firstImg' => $firstImg, 'firstStr' => $pureStr1,'secondStr' => $pureStr2,'thirdStr' => $pureStr3, 'full' => $value->content]);
			}
		}

		return view('news_card',[
			'news' => $news,
			'refined' => $refined,
		]);
	}
    public function get($id)
    {
		$news = News_card::where('id',$id)->first();
		if($news === null) {
			abort(404);
		}
		preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $news->content, $image);
		if($image && $image['src']){
			$firstImg = $image['src'];
		}else{
			$firstImg = '';
		}
		$news->content = str_replace('style="text-align:center"', 'style="text-align:center;margin:0 auto;padding-bottom:1rem"', $news->content);
		return view('news_card_detail',[
			'news' => $news,
		]);
	}

}