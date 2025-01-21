<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Form</title>
</head>
<body>
    <form method="post" action="ccavRequestHandler.php">
                <label for="merchant_id">Merchand ID:</label>
        <input type="number" name="merchant_id" value="3195148">
        <br/><br/>
        <label for="order_id">Order ID:</label>
        <input type="number" name="order_id" id="order_id" value="12345">
           <br/><br/>
                <label for="currency">Currency:</label>
        <input type="text" name="currency" value="INR">
           <br/><br/>
                        <label for="amount">Amount:</label>
        <input type="text" name="amount" value="10.00">
           <br/><br/>
                                   <label for="redirect_url">Redirect Url:</label>

        <input type="url" name="redirect_url" value="https://booking.namograndcentralpark.com/UAT/step-5.php">
           <br/><br/>
                                   <label for="cancel_url">Redirect Url:</label>

        <input type="url" name="cancel_url" value="https://booking.namograndcentralpark.com/UAT/cancel.php">
           <br/><br/>
        <input type="hidden" name="language" value="EN">
        <input type="submit" value="Check Out">
    </form>
</body>
</html>