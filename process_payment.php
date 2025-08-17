<?php
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey("YOUR_STRIPE_SECRET_KEY");

$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

try {
    $booking_id = $_POST['booking_id'] ?? null;
    $hotel_id = $_POST['hotel_id'] ?? null;
    $user_email = $_POST['user_email'] ?? null;
    $payer_name = $_POST['payer_name'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $payment_intent_id = $_POST['payment_intent_id'] ?? null;

    if (!$payment_intent_id) {
        throw new Exception("No payment intent ID received");
    }

    // Step 1: Get the PaymentIntent
    $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

    // Step 2: Get the latest charge ID
    $latest_charge_id = $paymentIntent->latest_charge;
    if (!$latest_charge_id) {
        throw new Exception("No charge associated with this PaymentIntent");
    }

    // Step 3: Fetch full charge details
    $charge = \Stripe\Charge::retrieve($latest_charge_id);

    // Step 4: Extract required data
    $transaction_id = $charge->id ?? '';
    $last4 = $charge->payment_method_details->card->last4 ?? '';
    $exp_month = $charge->payment_method_details->card->exp_month ?? '';
    $exp_year = $charge->payment_method_details->card->exp_year ?? '';
    $brand = $charge->payment_method_details->card->brand ?? '';
    $status = $charge->status ?? 'pending';
    $currency = strtoupper($charge->currency ?? 'USD');

    // Step 5: Insert into DB
    $stmt = $conn->prepare("
        INSERT INTO payments 
        (booking_id, hotel_id, user_email, payer_name, amount, currency, card_last4, card_brand, card_exp_month, card_exp_year, payment_intent_id, transaction_id, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "iissdsssisiis", 
        $booking_id, $hotel_id, $user_email, $payer_name, $amount, $currency,
        $last4, $brand, $exp_month, $exp_year, $payment_intent_id, $transaction_id, $status
    );

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'transaction_id' => $transaction_id]);
    } else {
        throw new Exception("DB Insert failed: " . $stmt->error);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
