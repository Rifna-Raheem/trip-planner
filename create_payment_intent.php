<?php
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey("YOUR_STRIPE_SECRET_KEY"); // Your secret key

header('Content-Type: application/json');

try {
    // Get amount from POST (since I'm using FormData)
    if (!isset($_POST['amount']) || !is_numeric($_POST['amount'])) {
        throw new Exception('Invalid amount provided');
    }

    $amount = (float)$_POST['amount'];
    if ($amount <= 0) {
        throw new Exception('Amount must be greater than zero');
    }

    // Create PaymentIntent
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => intval($amount * 100), // Convert to cents
        'currency' => 'usd',
        'payment_method_types' => ['card'],
    ]);

    echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
