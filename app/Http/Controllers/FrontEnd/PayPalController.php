<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PayPalController extends Controller
{
    public function paypal_payment(Request $request)
    {
        $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('payment.success'),
                    "cancel_url" => route('payment.cancel'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $request->amount
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {

                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }

                return redirect()
                    ->route('createpaypal')
                    ->with('error', 'Something went wrong.');

            } else {
                return redirect()
                    ->route('createpaypal')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
    }


    public function paypal_success(Request $request)
    {

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                return redirect()
                    ->route('createpaypal')
                    ->with('success', 'Transaction complete.');
            } else {
                return redirect()
                    ->route('createpaypal')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }

    }

     public function paypal_cancel(Request $request)
        {
            return redirect()
                ->route('createpaypal')
                ->with('error', $response['message'] ?? 'You have canceled the transaction.');
        }
}
