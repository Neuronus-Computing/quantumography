<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Auth;
use App\Models\UserPayment;
use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PaymentSuccessEmail;
use Stripe\Invoice;
use App\Models\Subscription as UserSubscription;
use Mail;

class PaymentController extends Controller
{
    public function checkout(Request $request, $priceId)
    {
        $user = Auth::user();
        session()->put(['price_id' => $priceId]);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $priceId,
                        'quantity' => 1,
                    ],
                ],
                'customer_email' => $user->email,
                'mode' => 'subscription', // Use 'subscription' mode for creating subscriptions
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('plan.index'),
            ]);

            // Redirect to the Stripe Checkout page
            return redirect()->away($session->url);
        } catch (\Exception $e) {
            session()->put(['error' => "Something went wrong, please try again."]);
            return redirect()->back();
        }
    }
    public function successPayment(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));


        $session = Session::retrieve($request->input('session_id'));
        $subscriptionId = $session->subscription;

        $subscription = Subscription::retrieve($subscriptionId);
        $user = Auth::user();
        // Retrieve the latest invoice
        $invoice = Invoice::retrieve($subscription->latest_invoice);

        $paymentIntentId = $invoice->payment_intent;
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        // Retrieve the payment method associated with the payment intent
        $paymentMethodId = $paymentIntent->payment_method;
        $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

        // Extract card and brand details
        $cardBrand = $paymentMethod->card->brand;
        $cardLast4 = $paymentMethod->card->last4;
        $amount = $subscription->amount;
        // Format the payment method
        $paymentMethodFormatted = $cardBrand . '-' . $cardLast4;

        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'stripe_id' => $subscription->id,
            'stripe_price' => $subscription->items->data[0]->price->id,
            'plan_name' => $subscription->items->data[0]->price->nickname,
            'amount' => $paymentIntent->amount / 100,
            'currency' => $subscription->currency,
            'card' => $paymentMethodFormatted,
            'started_at' => date('Y-m-d H:i:s', $subscription->current_period_start),
            'end_at' => date('Y-m-d H:i:s', $subscription->current_period_end),
        ]);

        $emails = env('ADMIN_EMAIL');
        $cc_emails = explode(',', $emails);

        $validated_cc_emails = [];
        foreach ($cc_emails as $email) {
            $email = trim($email, ' "');
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($validated_cc_emails, $email);
            }
        }
        $data = [
            'payment_details' => $subscription,
            'user' => $user,
        ];
        $pdf = PDF::loadView('email.payment-success', $data);
        Mail::send('email.success-message', ['emailData' => $data], function ($message) use ($data, $validated_cc_emails, $pdf) {
            $message->to($data["user"]->email)
                ->subject("Image Enlarge - Payment Success")
                ->cc($validated_cc_emails)
                ->attachData($pdf->output(), 'invoice.pdf');
        });
        return redirect()->route('payment.success.show');
    }
    public function paymentDetails()
    {
        $pageTitle = 'Payment Details';
        $submenu=['link'=>route('image.index'), 'title'=>"Image Enlarger"];
        $userSubscription = UserSubscription::where('user_id', Auth::id())->latest()->first();
        $plan = Plan::where('price_id', $userSubscription->stripe_price)->first();
        return view('payment.details', compact('pageTitle', 'plan', 'userSubscription','submenu'));
    }
    public function cancelSubscription(Request $request)
    {
        $user= Auth::user();
        // Set your Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Subscription ID to cancel
        $subscriptionId = $request->subscription_id;

        // Retrieve the subscription
        $subscription = Subscription::retrieve($subscriptionId);

        // Cancel the subscription at the end of the current period
        $subscription->cancel();
        $user->subscriptions()->where('stripe_id', $subscriptionId)->update(['cancelled_at'=>now()]);
        return redirect()->back()->with('success','Subscription cancelled successfully.');
    }
}
