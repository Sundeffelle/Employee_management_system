const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);
function payWithPaystack(e){

    e.preventDefault();

    let handler = PaystackPop.setup({
        key: 'pk_live_965a95be20cbb7a714abc0202ef0d122f3f8ad43',
        email: document.getElementById("email-address").value,
        amount: document.getElementById("amount").value *100,
        currency: "GHS",
        ref: '' +Math.floor((Math.random() * 1000000000) + 1),

        onClose: function(){
            alert('Window Closed.');
        },
        callback: function(response){
            let message = 'Payment Complete! Reference:' + response.reference;
            alert(message)

        }
    });
    handler.openIframe();
}