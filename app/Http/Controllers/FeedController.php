<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Feeds;

class FeedController extends Controller
{
    public function index(){
    	$feed = Feeds::make('https://news.google.com/news/section?cf=all&hl=pt-BR&pz=1&ned=pt-BR_br&topic=n&output=rss');
	    $items = [
	      'title'     => $feed->get_title(),
	      'permalink' => $feed->get_permalink(),
	      'items'     => $feed->get_items(),
	    ];
	    
	    return view('feeds.index', $items);
    }
}
