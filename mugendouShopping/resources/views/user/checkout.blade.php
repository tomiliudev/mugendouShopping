<head>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <div id="checkout">
        <p>決済ページへリダイレクトします。</p>
    </div>
</body>
<script>
    // Initialize Stripe.js
    const publicKey = '{{ $publicKey }}'
    const stripe = Stripe(publicKey);

    window.onload = function() {
        stripe.redirectToCheckout({
            sessionId: '{{ $session->id }}'
        }).then(function (result) {
            window.location.href = '{{ route('cart.index') }}'
        });
    }
</script>
