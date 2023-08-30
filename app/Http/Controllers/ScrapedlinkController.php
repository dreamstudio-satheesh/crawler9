<?php

namespace App\Http\Controllers;

use Artisan;
use App\Models\Website;
use App\Jobs\Scrapelink;
use App\Models\ScrapedLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapedlinkController extends Controller
{
    public function scrape_products($id)
    {
         $website = Website::where('id',$id)->first();
        if ($website)  {
            Scrapelink::dispatch( ['id' => $website->id,'url' => $website->url ,'page' => $website->product_url]);
            return back();
        }

      
        // dd(Artisan::output());
    }

    public function show($id)
    {
        $scrapedlinks = ScrapedLink::where('website_id', $id)->get();
        return view('scrapedlinks', compact('scrapedlinks'));
    }

    public function play(Request $request)
    {
       $title='';

       $data=array();
       
        if ($request->url)
        {
            
            $data = $request->validate([
                'url' => 'required|url:http,https',
            ]);
            

            $url=$request->url;
            $response = Http::get($url);
            $crawler = new Crawler($response->body(), $url);
            if ($request->title) {
                $data['title'] = $crawler->filter($request->title)->text();
            }
            if ($request->description) {
                $data['description'] = $crawler->filter($request->description)->text();
            }
            if ($request->price) {
                $data['price'] = $crawler->filter($request->price)->text();
            }
            if ($request->image) {
                $data['image']=$crawler->filter($request->image)->attr('src');
            }

          

           

          
            
        
        }
        
            return view('playground.create',compact('title','data'));
        
    }
}
