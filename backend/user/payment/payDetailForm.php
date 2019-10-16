<?php
    include("../functions/init.php");

    $celestaid = $_POST['celesta_id'];
    $eventid = $_POST['event_id'];
    $profile = user_details($celestaid);
    $user_registered_events = json_decode($profile['events_registered']);
    print_r($user_registered_events);
?>

<html>
<head>
    <script>
        window.onload = function() {
            var d = new Date().getTime();
            document.getElementById("tid").value = d;
        };
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h3>Payment Details Form</h3>
        <form method="POST" name="customerData" action="ccavRequestHandler.php">
            <input type="text" name="tid" id="tid" value="1570793253839" hidden />
            <input type="text" name="merchant_id" id="merchant_id" value="221043" hidden/>
            <input type="text" name="order_id" value="123654789" hidden/>
            <input type="text" name="currency" value="INR" hidden/>
            <input type="text" name="redirect_url" value="http://www.techprolabz.com/ccavResponseHandler.php" hidden/>
            <input type="text" name="cancel_url" value="http://www.techprolabz.com/ccavResponseHandler.php" hidden/>
            <input type="text" name="language" value="EN" hidden/>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" name="amount" value="10" readonly/>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="billing_name" class="form-control" value="<?php echo $profile['first_name'] ." ". $profile['last_name'] ?>" readonly>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="billing_address" class="form-control" placeholder="Enter address" />
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="billing_city" class="form-control" placeholder="Enter city" />
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" name="billing_state" class="form-control" placeholder="Enter State" />
            </div>
            <div class="form-group">
                <label>ZIP Code</label>
                <input type="text" name="billing_zip" class="form-control" placeholder="Enter ZIP Code" />
            </div>
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="billing_country" class="form-control" placeholder="Enter Country" value="India"/>
            </div>
            <div class="form-group">
                <label>Telephone</label>
                <input type="text" name="billing_tel" class="form-control" placeholder="Enter telephone/mobile number" value="<?php echo $profile['phone']?>" />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="billing_email" class="form-control" value="<?php echo $profile['email']?>" />
            </div>
            <input class="btn btn-primary" type="submit" value="Pay">
        </form>
    </div>
</body>
<!-- <script language="javascript" type="text/javascript" src="json.js"></script>-->
<!-- <script src="jquery-1.7.2.min.js"></script>-->
<script language="javascript" type="text/javascript" src="json.js"></script>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/javascript">
    $(function() {

        /* json object contains
        	 1) payOptType - Will contain payment options allocated to the merchant. Options may include Credit Card, Net Banking, Debit Card, Cash Cards or Mobile Payments.
        	 2) cardType - Will contain card type allocated to the merchant. Options may include Credit Card, Net Banking, Debit Card, Cash Cards or Mobile Payments.
        	 3) cardName - Will contain name of card. E.g. Visa, MasterCard, American Express or and bank name in case of Net banking.
        	 4) status - Will help in identifying the status of the payment mode. Options may include Active or Down.
        	 5) dataAcceptedAt - It tell data accept at CCAvenue or Service provider
        	 6)error -  This parameter will enable you to troubleshoot any configuration related issues. It will provide error description.
        */
        var jsonData;
        var access_code = "" // shared by CCAVENUE
        var amount = "6000.00";
        var currency = "INR";

        $.ajax({
            url: 'https://secure.ccavenue.com/transaction/transaction.do?command=getJsonData&access_code=' + access_code + '&currency=' + currency + '&amount=' + amount,
            dataType: 'jsonp',
            jsonp: false,
            jsonpCallback: 'processData',
            success: function(data) {
                jsonData = data;
                // processData method for reference
                processData(data);
                // get Promotion details
                $.each(jsonData, function(index, value) {
                    if (value.Promotions != undefined && value.Promotions != null) {
                        var promotionsArray = $.parseJSON(value.Promotions);
                        $.each(promotionsArray, function() {
                            console.log(this['promoId'] + " " + this['promoCardName']);
                            var promotions = "<option value=" + this['promoId'] + ">" +
                                this['promoName'] + " - " + this['promoPayOptTypeDesc'] + "-" + this['promoCardName'] + " - " + currency + " " + this['discountValue'] + "  " + this['promoType'] + "</option>";
                            $("#promo_code").find("option:last").after(promotions);
                        });
                    }
                });
            },
            error: function(xhr, textStatus, errorThrown) {
                alert('An error occurred! ' + (errorThrown ? errorThrown : xhr.status));
                //console.log("Error occured");
            }
        });

        $(".payOption").click(function() {
            var paymentOption = "";
            var cardArray = "";
            var payThrough, emiPlanTr;
            var emiBanksArray, emiPlansArray;

            paymentOption = $(this).val();
            $("#card_type").val(paymentOption.replace("OPT", ""));
            $("#card_name").children().remove(); // remove old card names from old one
            $("#card_name").append("<option value=''>Select</option>");
            $("#emi_div").hide();

            //console.log(jsonData);
            $.each(jsonData, function(index, value) {
                //console.log(value);
                if (paymentOption != "OPTEMI") {
                    if (value.payOpt == paymentOption) {
                        cardArray = $.parseJSON(value[paymentOption]);
                        $.each(cardArray, function() {
                            $("#card_name").find("option:last").after("<option class='" + this['dataAcceptedAt'] + " " + this['status'] + "'  value='" + this['cardName'] + "'>" + this['cardName'] + "</option>");
                        });
                    }
                }

                if (paymentOption == "OPTEMI") {
                    if (value.payOpt == "OPTEMI") {
                        $("#emi_div").show();
                        $("#card_type").val("CRDC");
                        $("#data_accept").val("Y");
                        $("#emi_plan_id").val("");
                        $("#emi_tenure_id").val("");
                        $("span.emi_fees").hide();
                        $("#emi_banks").children().remove();
                        $("#emi_banks").append("<option value=''>Select your Bank</option>");
                        $("#emi_tbl").children().remove();

                        emiBanksArray = $.parseJSON(value.EmiBanks);
                        emiPlansArray = $.parseJSON(value.EmiPlans);
                        $.each(emiBanksArray, function() {
                            payThrough = "<option value='" + this['planId'] + "' class='" + this['BINs'] + "' id='" + this['subventionPaidBy'] + "' label='" + this['midProcesses'] + "'>" + this['gtwName'] + "</option>";
                            $("#emi_banks").append(payThrough);
                        });

                        emiPlanTr = "<tr><td>&nbsp;</td><td>EMI Plan</td><td>Monthly Installments</td><td>Total Cost</td></tr>";

                        $.each(emiPlansArray, function() {
                            emiPlanTr = emiPlanTr +
                                "<tr class='tenuremonth " + this['planId'] + "' id='" + this['tenureId'] + "' style='display: none'>" +
                                "<td> <input type='radio' name='emi_plan_radio' id='" + this['tenureMonths'] + "' value='" + this['tenureId'] + "' class='emi_plan_radio' > </td>" +
                                "<td>" + this['tenureMonths'] + "EMIs. <label class='merchant_subvention'>@ <label class='emi_processing_fee_percent'>" + this['processingFeePercent'] + "</label>&nbsp;%p.a</label>" +
                                "</td>" +
                                "<td>" + this['currency'] + "&nbsp;" + this['emiAmount'].toFixed(2) +
                                "</td>" +
                                "<td><label class='currency'>" + this['currency'] + "</label>&nbsp;" +
                                "<label class='emiTotal'>" + this['total'].toFixed(2) + "</label>" +
                                "<label class='emi_processing_fee_plan' style='display: none;'>" + this['emiProcessingFee'].toFixed(2) + "</label>" +
                                "<label class='planId' style='display: none;'>" + this['planId'] + "</label>" +
                                "</td>" +
                                "</tr>";
                        });
                        $("#emi_tbl").append(emiPlanTr);
                    }
                }
            });

        });


        $("#card_name").click(function() {
            if ($(this).find(":selected").hasClass("DOWN")) {
                alert("Selected option is currently unavailable. Select another payment option or try again later.");
            }
            if ($(this).find(":selected").hasClass("CCAvenue")) {
                $("#data_accept").val("Y");
            } else {
                $("#data_accept").val("N");
            }
        });

        // Emi section start
        $("#emi_banks").live("change", function() {
            if ($(this).val() != "") {
                var cardsProcess = "";
                $("#emi_tbl").show();
                cardsProcess = $("#emi_banks option:selected").attr("label").split("|");
                $("#card_name").children().remove();
                $("#card_name").append("<option value=''>Select</option>");
                $.each(cardsProcess, function(index, card) {
                    $("#card_name").find("option:last").after("<option class=CCAvenue value='" + card + "' >" + card + "</option>");
                });
                $("#emi_plan_id").val($(this).val());
                $(".tenuremonth").hide();
                $("." + $(this).val() + "").show();
                $("." + $(this).val()).find("input:radio[name=emi_plan_radio]").first().attr("checked", true);
                $("." + $(this).val()).find("input:radio[name=emi_plan_radio]").first().trigger("click");

                if ($("#emi_banks option:selected").attr("id") == "Customer") {
                    $("#processing_fee").show();
                } else {
                    $("#processing_fee").hide();
                }

            } else {
                $("#emi_plan_id").val("");
                $("#emi_tenure_id").val("");
                $("#emi_tbl").hide();
            }



            $("label.emi_processing_fee_percent").each(function() {
                if ($(this).text() == 0) {
                    $(this).closest("tr").find("label.merchant_subvention").hide();
                }
            });

        });

        $(".emi_plan_radio").live("click", function() {
            var processingFee = "";
            $("#emi_tenure_id").val($(this).val());
            processingFee =
                "<span class='emi_fees' >" +
                "Processing Fee:" + $(this).closest('tr').find('label.currency').text() + "&nbsp;" +
                "<label id='processingFee'>" + $(this).closest('tr').find('label.emi_processing_fee_plan').text() +
                "</label><br/>" +
                "Processing fee will be charged only on the first EMI." +
                "</span>";
            $("#processing_fee").children().remove();
            $("#processing_fee").append(processingFee);

            // If processing fee is 0 then hiding emi_fee span
            if ($("#processingFee").text() == 0) {
                $(".emi_fees").hide();
            }

        });


        $("#card_number").focusout(function() {
            /*
             emi_banks(select box) option class attribute contains two fields either allcards or bin no supported by that emi
            */
            if ($('input[name="payment_option"]:checked').val() == "OPTEMI") {
                if (!($("#emi_banks option:selected").hasClass("allcards"))) {
                    if (!$('#emi_banks option:selected').hasClass($(this).val().substring(0, 6))) {
                        alert("Selected EMI is not available for entered credit card.");
                    }
                }
            }

        });


        // Emi section end


        // below code for reference

        function processData(data) {
            var paymentOptions = [];
            var creditCards = [];
            var debitCards = [];
            var netBanks = [];
            var cashCards = [];
            var mobilePayments = [];
            $.each(data, function() {
                // this.error shows if any error
                console.log(this.error);
                paymentOptions.push(this.payOpt);
                switch (this.payOpt) {
                    case 'OPTCRDC':
                        var jsonData = this.OPTCRDC;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function() {
                            creditCards.push(this['cardName']);
                        });
                        break;
                    case 'OPTDBCRD':
                        var jsonData = this.OPTDBCRD;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function() {
                            debitCards.push(this['cardName']);
                        });
                        break;
                    case 'OPTNBK':
                        var jsonData = this.OPTNBK;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function() {
                            netBanks.push(this['cardName']);
                        });
                        break;

                    case 'OPTCASHC':
                        var jsonData = this.OPTCASHC;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function() {
                            cashCards.push(this['cardName']);
                        });
                        break;

                    case 'OPTMOBP':
                        var jsonData = this.OPTMOBP;
                        var obj = $.parseJSON(jsonData);
                        $.each(obj, function() {
                            mobilePayments.push(this['cardName']);
                        });
                }

            });

            //console.log(creditCards);
            // console.log(debitCards);
            // console.log(netBanks);
            // console.log(cashCards);
            //  console.log(mobilePayments);

        }
    });
</script>

</html>