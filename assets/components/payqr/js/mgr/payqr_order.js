$(function() {
    if(typeof payQR  !== "undefined")
    {
        payQR.onPaid(function(data) {

            var message = "Ваш заказ #" + data.orderId + " успешно оплачен на сумму: " + data.amount + "! ";

            if(typeof data.userData !== "undefined" && typeof data.userData.new_account !== "undefined" && (data.userData.new_account == true || data.userData.new_account == "true"))
            {
                message += " Администратор сайта свяжется с вами в самое ближайшее время!";
            }

            alert(message);

            //window.location.replace(window.location.origin + "/oformlenie-zakaza/?shk_action=empty");
            window.location.replace(window.location.origin + "/?shk_action=empty" + ( typeof data.userData.cart_id != "undefined" ? data.userData.cart_id : ""));
        });
    }
});
