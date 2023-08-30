<?php

namespace App\Console\Commands;

use App\Models\ScrapedLink;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeLinks extends Command
{
    protected $signature = 'scrape:links {id} {url} {page}';
    protected $description = 'Scrape all links from a website';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = $this->argument('id');
        $startingUrl = $this->argument('url');
        $productsLink = $this->argument('page');
        $domain = parse_url($startingUrl, PHP_URL_HOST);

        $queue = [$startingUrl];
        $visited = [];

       /*  */
        $this->info('Scraping completed.');
    }

    private function storeLinks($url, $id, $content = null)
    {
        ScrapedLink::insertOrIgnore([
            'website_id' => $id,
            'url' => $url,
            'content' => $content,
        ]);
    }
}
