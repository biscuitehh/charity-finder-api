<?php
/**
 * charity_import.job.php
 * User: biscuit
 * Date: 1/28/15
 * Time: 10:26 PM
 */

date_default_timezone_set('America/New_York');

// Composer
require_once('../vendor/autoload.php');

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\User as User;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'   => 'sqlite',
    'database' => '../storage/database.sqlite',
    'prefix'   => ''
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$IRS_URL = 'http://www.irs.gov/pub/irs-soi/';
$LINK_REGEX = '/eo_[^.]{2}\.(csv)/i';
$ROWS_PER_CHUNK = 20;

$scraper = new Goutte\Client();
$client = new GuzzleHttp\Client();

$crawler = $scraper->request('GET', $IRS_URL);
$nodes = $crawler->filter('a');


foreach($nodes as $node) {
    $link = $node->textContent;

    // determine if this is csv
    if (preg_match($LINK_REGEX, $link)) {
        $url = $IRS_URL . $link;

        // fetch & parse - ick irs timeouts
        // we could even do this async, but we might break irs :(
        $res = $client->get($url,
            ['timeout' => 0, 'connect_timeout' => 0, 'future' => true]
        );

        $res->then(function ($res) use ($url, $ROWS_PER_CHUNK) {
            echo("Loading: $url\n");

            // Parse CSV into multi-dimensional array
            $lines = explode("\n", $res->getBody());
            $header = str_getcsv(array_shift($lines));

            $data = array();

            foreach ($lines as $line) {
                $raw = str_getcsv($line);
                if (isset($raw[0])) {
                    $date = new DateTime();
                    $csv = array();
                    $csv['ein'] = $raw[0];
                    $csv['name'] = $raw[1];
//                    $csv['ico'] = $raw[2];
                    $csv['street'] = $raw[3];
                    $csv['city'] = $raw[4];
                    $csv['state'] = $raw[5];
                    $csv['zip'] = $raw[6];
//                    $csv['group'] = $raw[7];
//                    $csv['subsection'] = $raw[8];
//                    $csv['affiliation'] = $raw[9];
//                    $csv['classification'] = $raw[10];
//                    $csv['ruling'] = $raw[11];
//                    $csv['deductibility'] = $raw[12];
//                    $csv['foundation'] = $raw[13];
//                    $csv['activity'] = $raw[14];
//                    $csv['organization'] = $raw[15];
//                    $csv['status'] = $raw[16];
//                    $csv['tax_period'] = $raw[17];
//                    $csv['asset_cd'] = $raw[18];
//                    $csv['income_cd'] = $raw[19];
//                    $csv['filing_req_cd'] = $raw[20];
//                    $csv['pf_filing_req_cd'] = $raw[21];
                    $csv['created_at'] = $date;
                    $csv['updated_at'] = $date;
                    $data[] = $csv;
                }
            }

            // Chunk & Go
            $chunks = array_chunk($data, $ROWS_PER_CHUNK);
            foreach($chunks as $chunk) {
                // Add to Database
                App\Models\Charity::insert($chunk);
            }
            echo("Completed processing ".count($data)." records from: $url\n");
        });
    }
}
