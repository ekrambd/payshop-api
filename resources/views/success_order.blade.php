<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Success</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

        body{
            background:#f4f6f9;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .success-card{
            max-width:650px;
            width:100%;
            border:none;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.1);
        }

        .success-header{
            background:#28a745;
            padding:40px 20px;
        }

        .success-icon{
            width:110px;
            height:110px;
            border-radius:50%;
            background:#fff;
            color:#28a745;
            font-size:55px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
        }

        .success-body{
            padding:40px;
            text-align:center;
        }

        .success-body h2{
            font-weight:700;
            margin-bottom:20px;
        }

        .success-body p{
            color:#666;
            font-size:17px;
            line-height:30px;
        }

        .btn-custom{
            min-width:180px;
            margin:8px;
        }

    </style>

</head>

<body>

<div class="card success-card">

    <div class="success-header">

        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

    </div>

    <div class="success-body">

        <h2 class="text-success">
            Order Placed Successfully!
        </h2>

        <p>

            Thank you for choosing us.

            <br><br>

            Your order has been received successfully.

            Our vendor will contact you shortly to confirm your order and provide further assistance.

            We appreciate your trust and look forward to serving you.

        </p>

        <div class="mt-4">

            <a href="{{ url('/') }}"
               class="btn btn-success btn-lg btn-custom">
                <i class="fas fa-home"></i>
                Continue Shopping
            </a>

            <a href="{{ url('/my-orders') }}"
               class="btn btn-outline-dark btn-lg btn-custom">
                <i class="fas fa-shopping-bag"></i>
                My Orders
            </a>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>