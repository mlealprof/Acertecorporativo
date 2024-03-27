
<?php
require_once 'vendor/autoload.php';
use MercadoPagoMercadoPagoConfig;
MercadoPagoConfig::setAccessToken("TEST-2417866519310966-012214-8ec39ef2608c69b640ffb03a94219b85-47514727");

$contents = json_decode(file_get_contents('php://input'), true);

$createRequest = [
  "transaction_amount" => 100,
  "description" => "description",
  "payment_method_id" => "pix",
    "payer" => [
      "email" => $contents['payer']['email'],
      "identification" => [
        "type" => $contents['payer']['identification']['type'],
        "number" => $contents['payer']['identification']['number']
      ]
    ],
    "payment" => [
      "transaction_amount" => $contents['transaction_amount'],
      "token" => $contents['token'],
      "installments" => $contents['installments'],
      "payment_method_id" => $contents['payment_method_id'],
      "issuer_id" => $contents['issuer_id']
    ]
];

$client = new PaymentClient();
$request_options = new MPRequestOptions();
$request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

$client->create($createRequest, $request_options);
?>
