document.addEventListener('DOMContentLoaded', function () {
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { token, error } = await stripe.createToken(cardElement);

        if (error) {
            console.error(error);
        } else {
            document.getElementById('stripeToken').value = token.id;
            form.submit();
        }
    });
});