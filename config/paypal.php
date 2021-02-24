<?php 
return [ 
 'client_id' => env('PAYPAL_CLIENT_ID','Aarv9atYDN8wkoh98m-zg7oc8PRWrtB-e3idnTbcJdnvQ3rFYchq_zEixp49YqI1ExZDAkUAGgdoXYNN'),
 'secret' => env('PAYPAL_SECRET','EIZ2HI_xOs7ouOKzfG7a27QLkICHmmgnvEWkFjz7NxD3W2FX0VHly6MetIOHx7aNOICddUgS5tVoKFkF'),
'settings' => array(
  'mode' => env('PAYPAL_MODE','sandbox'), //Option 'sandbox' or 'live', sandbox for testing
  'http.ConnectionTimeOut' => 1000, //Max request time in seconds
  'log.LogEnabled' => true, //Whether want to log to a file
  'log.FileName' => storage_path() . '/logs/paypal.log', //Specify the file that want to write on
  'log.LogLevel' => 'FINE' //Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
  /**
  * Logging is most verbose in the 'FINE' level and decreases as you
  * proceed towards ERROR
  */
 ),
];