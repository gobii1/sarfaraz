<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<button id="pay-button">Bayar</button>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        fetch("{{ route('payment.token') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                amount: 100000, // Total amount to be paid
                first_name: "John",
                last_name: "Doe",
                email: "john.doe@example.com",
                phone: "08123456789"
            })
        })
        .then(response => response.json())
        .then(data => {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log(result);
                },
                onPending: function(result) {
                    console.log(result);
                },
                onError: function(result) {
                    console.log(result);
                }
            });
        });
    };
</script>
