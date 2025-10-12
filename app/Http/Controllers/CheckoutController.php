<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CheckoutController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show the checkout page
     */
    public function showCheckout(Request $request, string $transactionId)
    {
        try {
            // Get payment details
            $payment = Payment::where('transaction_id', $transactionId)
                ->with(['plan', 'company'])
                ->firstOrFail();

            // Check if payment is still pending
            if ($payment->status !== 'pending') {
                return redirect()->route('payment.status', ['transactionId' => $transactionId]);
            }

            $plan = $payment->plan;
            $amount = $request->get('amount', $payment->amount);
            $planName = $request->get('plan', $plan->name);

            return view('checkout', compact('payment', 'plan', 'amount', 'planName', 'transactionId'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid checkout session.');
        }
    }

    /**
     * Process the payment
     */
    public function processPayment(Request $request, string $transactionId)
    {
        try {
            $result = $this->paymentService->confirmPayment($transactionId);

            if ($result['success']) {
                return redirect()->route('payment.success', ['transactionId' => $transactionId])
                    ->with('success', 'Payment completed successfully!');
            } else {
                return redirect()->route('payment.failed', ['transactionId' => $transactionId])
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            return redirect()->route('payment.failed', ['transactionId' => $transactionId])
                ->with('error', 'An error occurred during payment processing.');
        }
    }

    /**
     * Show payment success page
     */
    public function paymentSuccess(string $transactionId)
    {
        try {
            $payment = Payment::where('transaction_id', $transactionId)
                ->with(['plan', 'company'])
                ->firstOrFail();

            return view('payment-success', compact('payment'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid payment session.');
        }
    }

    /**
     * Show payment failed page
     */
    public function paymentFailed(string $transactionId)
    {
        try {
            $payment = Payment::where('transaction_id', $transactionId)
                ->with(['plan', 'company'])
                ->firstOrFail();

            return view('payment-failed', compact('payment'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid payment session.');
        }
    }

    /**
     * Show payment status
     */
    public function paymentStatus(string $transactionId)
    {
        try {
            $paymentStatus = $this->paymentService->getPaymentStatus($transactionId);
            $payment = Payment::where('transaction_id', $transactionId)
                ->with(['plan', 'company'])
                ->firstOrFail();

            return view('payment-status', compact('payment', 'paymentStatus'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid payment session.');
        }
    }

    /**
     * Cancel payment
     */
    public function cancelPayment(string $transactionId)
    {
        try {
            $result = $this->paymentService->cancelPayment($transactionId);

            return redirect()->route('home')
                ->with('info', 'Payment cancelled successfully.');

        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Unable to cancel payment.');
        }
    }
}
