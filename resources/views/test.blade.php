{{ Form::open() }}
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
            data-amount="999"
            data-name="Stripe.com"
            data-description="Widget"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="ph"
            data-email="jomeravengoza@gmail.com"
            data-zip-code="true">
    </script>
{{ Form::close() }}