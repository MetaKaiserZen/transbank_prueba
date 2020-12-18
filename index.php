<?php

    $dir = $_SERVER['DOCUMENT_ROOT'];

    require_once($dir . '/transbank/vendor/autoload.php');

    use Transbank\Webpay\Configuration;
    use Transbank\Webpay\Webpay;

    // $transaction = (new Webpay(Configuration::forTestingWebpayPlusNormal()))->getNormalTransaction();

    $PRV_K = '-----BEGIN RSA PRIVATE KEY----------END RSA PRIVATE KEY-----';

    $CERT = '-----BEGIN CERTIFICATE----------END CERTIFICATE-----';

    $configuration = new \Transbank\Webpay\Configuration();
    $configuration->setEnvironment("PRODUCCION");
    $configuration->setCommerceCode('597036175613');
    $configuration->setPrivateKey( $PRV_K );
    $configuration->setPublicCert( $CERT );

    $transaction = new \Transbank\Webpay\Webpay($configuration);

    $amount = $_POST['inputTransbank'];

    $sessionID = 'sessionID';
    $buyOrder = strval(rand(10000, 9999999));
    $returnUrl = 'https://www.tranvial.cl/transbank/return.php';
    $finalUrl = 'https://www.tranvial.cl/transbank/final.php';

    $initResult = $transaction->initTransaction($amount, $sessionID, $buyOrder, $returnUrl, $finalUrl);

    $formAction = $initResult->url;
    $tokenWs = $initResult->token;
?>

<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

		<title>Transbank</title>
	</head>
	<body>
	    <main class="py-4">
    	    <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Resumen</div>
                            <div class="card-body">
                                <h3>Pagar con WebPay</h3>
                    			<form action="<?php echo $formAction ?>" method="POST">
                    				<input type="hidden" name="token_ws" value="<?php echo $tokenWs ?>">
                    				<div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"><b>Orden de Compra:</b></label>
                                        <label class="col-md-6 col-form-label"><?php echo $buyOrder ?></label>
                                    </div>
                    				<div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"><b>Valor:</b></label>
                                        <label class="col-md-6 col-form-label">$<?php echo $amount ?></label>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">Pagar con WebPay</button>
                                        </div>
                                    </div>
                    			</form>
    		                </div>
    		            </div>
    		        </div>
    		    </div>
    		</div>
		</main>

		<!-- Optional JavaScript -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
	</body>
</html>
