<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use App\Models\ScrapedLink;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Exception\RequestException;

class GrabLinks extends Command
{
    protected $signature = 'grab:links {id} {url} {page}';
    protected $description = 'Crawl all pages on example.com';

    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    public function handle()
    {
        $id = $this->argument('id');
        $initialUrl = $this->argument('url');
        $pagelink = $this->argument('page');
        $this->info("Starting crawl from: $initialUrl");

        $visited = [];

        $this->crawlPage($initialUrl, $visited, 1, $pagelink, $id);
    }

    private function crawlPage($url, &$visited, $depth, $pagelink, $id)
    {
        // Check depth limit
        if ($depth > 4) {
            return;
        }

        if (in_array($url, $visited)) {
            return;
        }

        $visited[] = $url;

        $this->info("Crawling: $url (Depth: $depth)");

        try {
            // Fetching the HTML content
            $htmlContent = $this->client
                ->get($url)
                ->getBody()
                ->getContents();

            // Introduce rate limiting (1 request per second)
            sleep(1);
        } catch (RequestException $e) {
            $this->error("Failed to crawl URL $url: {$e->getMessage()}");

            // Log the status code if available
            if ($e->hasResponse()) {
                $this->error('HTTP Status Code: ' . $e->getResponse()->getStatusCode());
            }

            return;
        }

        // Initialize DomCrawler
        $crawler = new Crawler($htmlContent);

        // Check if URL matches example.com/products and save to database
        if (strpos($url, $pagelink) !== false) {
            ScrapedLink::insertOrIgnore([
                'website_id' => $id,
                'url' => $url,
                'content' => $htmlContent,
            ]);
        }

        /*  // Find all links on the page
        $crawler->filter('a')->each(function (Crawler $node) use (&$visited, $depth,$id) {
            $link = $node->link()->getUri();
            $this->crawlPage($link, $visited, $depth + 1,$link,$id);
        }); */

        // Find all links on the page
        $crawler->filter('a')->each(function (Crawler $node) use (&$visited, $depth, $id, $url) {
            $relativeLink = $node->attr('href');
            // Make the URL absolute if it is relative
            $link = $this->resolveUrl($relativeLink, $url);
            $this->crawlPage($link, $visited, $depth + 1, $link, $id);
        });
    }

    // ... (other parts of the code)

    private function resolveUrl($relativeUrl, $baseUrl)
    {
        // If the URL is already absolute, return it as is
        if (filter_var($relativeUrl, FILTER_VALIDATE_URL)) {
            return $relativeUrl;
        }

        // Otherwise, resolve it against the base URL
        return rtrim($baseUrl, '/') . '/' . ltrim($relativeUrl, '/');
    }
}
