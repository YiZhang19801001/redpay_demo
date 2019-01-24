<?php

namespace App\Http\Controllers;

use App\Listener;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        // read input
        $requestBody = [
            "amount" => $request->amount,
            "channel" => $request->channel,
            "currency" => $request->currency,
            "item" => $request->item,
            "mchNo" => $request->mchNo,
            "mchOrderNo" => $request->mchOrderNo,
            "notifyUrl" => $request->notifyUrl,
            "params" => $request->params,
            "payWay" => $request->payWay,
            "quantity" => $request->quantity,
            "returnUrl" => $request->returnUrl,
            "storeNo" => $request->storeNo,
            "timestamp" => $request->timestamp,
            "version" => $request->version,
        ];
        // declare secret key
        $secret = 'key=2c0ba056eafd47f681201ff022bf3130';

        // make request body
        $requestBody["sign"] = $this->getSign($requestBody, $secret);

        // call web api
        $data_string = json_encode($requestBody);
        $url = "https://dev-service.redpayments.com.au/pay/gateway/create-order";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));

        $curl_response = curl_exec($curl);

        // make reposnse object
        $responseBody = json_decode($curl_response);

        // return reponse
        return response()->json($responseBody, 200);

    }

    public function queryOrder(Request $request)
    {
        // read input
        $requestBody = [
            "mchNo" => $request->mchNo,
            "mchOrderNo" => $request->mchOrderNo,
            "timestamp" => $request->timestamp,
            "version" => $request->version,
        ];
// declare secret key
        $secret = 'key=2c0ba056eafd47f681201ff022bf3130';

// make request body
        $requestBody["sign"] = $this->getSign($requestBody, $secret);

// call web api
        $data_string = json_encode($requestBody);
        $url = "https://dev-service.redpayments.com.au/pay/gateway/query-order";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));

        $curl_response = curl_exec($curl);

// make reposnse object
        $responseBody = json_decode($curl_response);

// return reponse
        return response()->json($responseBody, 200);

    }

    public function listen(Request $request)
    {
        $response = Listener::create(['request_body' => json_encode($request)]);
    }

    public function listenGet()
    {
        $response = Listener::create(['request_body' => "receive one http get request"]);
    }

    private function getSign($params, $secret)
    {
        $str = '';
        ksort($params);
        foreach ($params as $k => $v) {
            $str .= "$k=$v&";
        }
        $str .= 'key=2c0ba056eafd47f681201ff022bf3130';
        return md5($str);
    }
}
