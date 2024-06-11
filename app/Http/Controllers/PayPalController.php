<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use Session;
use URL;
use Redirect;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );

        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function payWithPayPal()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = [];
        foreach (Session::get('cart') as $item) {
            $payPalItem = new Item();
            $payPalItem->setName($item->product->name)
                       ->setCurrency('USD')
                       ->setQuantity($item->quantity)
                       ->setPrice($item->product->price);
            $items[] = $payPalItem;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping(0)
                ->setTax(0)
                ->setSubtotal(Session::get('cart_total'));

        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal(Session::get('cart_total'))
               ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription('Order payment')
                    ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(URL::route('status'))
                     ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->route('home')->with('error', 'Connection timeout');
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirectUrl)) {
            return Redirect::away($redirectUrl);
        }

        return redirect()->route('home')->with('error', 'Unknown error occurred');
    }

    public function getPaymentStatus()
    {
        $paymentId = Session::get('paypal_payment_id');

        if (empty($_GET['PayerID']) || empty($_GET['token'])) {
            return redirect()->route('home')->with('error', 'Payment failed');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        try {
            $result = $payment->execute($execution, $this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return  view('home.home')->with('error', 'Payment failed');
        }

        if ($result->getState() == 'approved') {
            // Payment is successful, handle accordingly
            return view('home.home')->with('success', 'Payment success');
        }

        return view('home.home')->with('error', 'Payment failed');
    }
}
