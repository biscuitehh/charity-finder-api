<?php namespace App\Http\Controllers;

use App\Models\Charity;
use Request;
use Illuminate\Http\Response;

class CharityController extends Controller {

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $count = Request::input('count', 50);
            $order_by = Request::input('order_by', 'name');

            // Validate start parameter
            if (Request::has('start')) {
                $start = Request::input('start');
            } else {
                $start = 0;
            }

            // Validate end parameter
            if (Request::has('end')) {
                $end = Request::input('end');
            } else {
                $end = 100;
            }

            // Validate order_by parameter
            if (Request::has('order_by')) {
                $order_by = Request::input('order_by');

                // For now only allow name
                if ($order_by != 'name') {
                    $order_by = 'name';
                }
            } else {
                $order_by = "name";
            }

            $response = [
                'charities' => []
            ];

            $statusCode = 200;
            $charities = Charity::take($count)->skip($start)->orderBy($order_by)->get();

            foreach($charities as $charity) {
                $response['charities'][] = [
                    'id' => $charity->id,
                    'ein' => $charity->ein,
                    'name' => $charity->name,
                    'street' => $charity->street,
                    'city' => $charity->city,
                    'state' => $charity->state,
                    'zip' => $charity->zip,
                    'location' => $charity->location
                ];
            }
        } catch (Exception $e) {
            $statusCode = 404;
        }

        return response()->json($response, $statusCode);
    }
}
