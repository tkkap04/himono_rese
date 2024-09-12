document.addEventListener('DOMContentLoaded', function () {
    const stripe_public_key = document.querySelector('meta[name="stripe-key"]').getAttribute('content');

    var handler = StripeCheckout.configure({
        key: stripe_public_key,
        locale: 'auto',
        currency: 'JPY',
        token: function (token) {
            var form = document.getElementById('payment-form');

            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            var amountInput = document.createElement('input');
            amountInput.setAttribute('type', 'hidden');
            amountInput.setAttribute('name', 'amount');
            amountInput.setAttribute('value', document.getElementById('amount').value);
            form.appendChild(amountInput);

              form.submit();
        }
    });

    document.getElementById('customButton').addEventListener('click', function (e) {
        e.preventDefault();

        var amount = document.getElementById('amount').value;
        if (!amount) {
            alert('支払い金額を入力してください。');
            return;
        }

        handler.open({
            name: 'お支払い画面',
            description: '現在はデモ画面です',
            amount: parseInt(amount),
            currency: 'JPY'
        });
    });

    window.addEventListener('popstate', function () {
        handler.close();
    });
});