
<?php
require 'vendor/autoload.php';
session_start();
$booking_id = $_GET['booking_id'] ?? '';
$hotel_id = $_GET['hotel_id'] ?? '';
$amount = $_GET['amount'] ?? '';
$user_email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment - Travel Planner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .payment-container {
      background: linear-gradient(rgba(127, 195, 244, 0.8), rgba(13, 27, 81, 0.8));
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .payment-form {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
      max-width: 500px;
      width: 100%;
    }
    .StripeElement {
      background-color: white;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 15px;
    }
    .StripeElement--focus {
      border-color: #007bff;
      box-shadow: 0 0 3px #007bff;
    }
    #payment-message {
      margin-top: 15px;
      font-weight: bold;
    }
    .card-row { display: flex; gap: 10px; }
    .card-row > div { flex: 1; }
  </style>
</head>
<body>

<div class="payment-container">
  <form class="payment-form" id="paymentForm">
    <h2 class="text-center mb-4">Payment Details</h2>

    <div class="mb-3">
      <label for="payer_name" class="form-label">Name on Card</label>
      <input type="text" class="form-control" id="payer_name" placeholder="Eg: John Doe" required>
    </div>

    <label class="form-label">Card Number</label>
    <div id="card-number" class="StripeElement"></div>

    <div class="card-row">
      <div>
        <label class="form-label">Expiry Date</label>
        <div id="card-expiry" class="StripeElement"></div>
      </div>
      <div>
        <label class="form-label">CVC</label>
        <div id="card-cvc" class="StripeElement"></div>
      </div>
    </div>
    
    <div class="mb-3">
      <label class="form-label">Amount</label>
      <div class="input-group">
        <input type="text" class="form-control" value="<?= '$' . number_format((float)$amount, 2) ?>" readonly>
      </div>
    </div>

    <input type="hidden" id="booking_id" value="<?= htmlspecialchars($booking_id) ?>">
    <input type="hidden" id="hotel_id" value="<?= htmlspecialchars($hotel_id) ?>">
    <input type="hidden" id="amount" value="<?= htmlspecialchars($amount) ?>">
    <input type="hidden" id="user_email" value="<?= htmlspecialchars($user_email) ?>">

    <button type="submit" class="btn btn-success w-100">Pay Now</button>
    <div id="payment-message"></div>
  </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
  const stripe = Stripe("pk_test_51Rp2swF46FsybOou6eVcM2FUZzrVTio8pjrKN1tlk8QEXrAP8MUtBOFAdSPNg28iMb4RLHXk9icFzgCJAqOEBFLl00CVyWrlA6");//enter your API private key
  const elements = stripe.elements();

  const cardNumber = elements.create('cardNumber', { style: { base: { fontSize: '16px' } } });
  cardNumber.mount('#card-number');

  const cardExpiry = elements.create('cardExpiry', { style: { base: { fontSize: '16px' } } });
  cardExpiry.mount('#card-expiry');

  const cardCvc = elements.create('cardCvc', { style: { base: { fontSize: '16px' } } });
  cardCvc.mount('#card-cvc');

  const form = document.getElementById('paymentForm');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const messageEl = document.getElementById('payment-message');
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    messageEl.textContent = '';
    
    try {
        const formData = new FormData();
        formData.append('booking_id', document.getElementById('booking_id').value);
        formData.append('hotel_id', document.getElementById('hotel_id').value);
        formData.append('amount', document.getElementById('amount').value);

        const response = await fetch("create_payment_intent.php", {
            method: "POST",
            body: formData
        });

        if (!response.ok) throw new Error('Failed to create payment intent');
        const result = await response.json();
        if (result.error) throw new Error(result.error);

        const { error, paymentIntent } = await stripe.confirmCardPayment(
            result.clientSecret, {
                payment_method: {
                    card: cardNumber,
                    billing_details: { name: document.getElementById('payer_name').value }
                }
            }
        );
console.log("Stripe confirmCardPayment result:", paymentIntent, error);

        if (error) throw error;

        if (paymentIntent.status === 'succeeded') {
            // Send payment details to process_payment.php
            const saveData = new FormData();
            saveData.append('booking_id', document.getElementById('booking_id').value);
            saveData.append('hotel_id', document.getElementById('hotel_id').value);
            saveData.append('user_email', document.getElementById('user_email').value);
            saveData.append('payer_name', document.getElementById('payer_name').value);
            saveData.append('amount', document.getElementById('amount').value);
            saveData.append('payment_intent_id', paymentIntent.id);

            
            const saveResponse = await fetch('process_payment.php', {
                method: 'POST',
                body: saveData
            });

            const saveResult = await saveResponse.json();
            if (saveResult.status === 'success') {
                messageEl.textContent = 'Payment successful! Redirecting...';
                messageEl.style.color = 'green';
                setTimeout(() => { window.location.href = 'payment_success.php'; }, 2000);
            } else {
                throw new Error(saveResult.message);
            }
        }
    } catch (error) {
        messageEl.textContent = error.message;
        messageEl.style.color = 'red';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Pay Now';
    }
});
</script>
</body>
</html>
