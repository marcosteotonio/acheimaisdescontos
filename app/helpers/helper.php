<?php

use App\Notificacao;

function OBTER_ENDERECO($cep)
{
	$class = new Jarouche\ViaCEP\BuscaViaCEPJSONP();
	$result = $class->retornaCEP($cep); 
	return $result;    
}

function RAND_CODIGO()
{
	$pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';	
	return substr(str_shuffle(str_repeat($pool, 4)), 0, 4).'-'.substr(str_shuffle(str_repeat($pool, 4)), 0, 4);
}

function RAND_NUMERO_CARTAO()
{
	$pool = '0123456789';	
	return  substr(str_shuffle(str_repeat($pool, 4)), 0, 4).'-'.
			substr(str_shuffle(str_repeat($pool, 4)), 0, 4).'-'.
			substr(str_shuffle(str_repeat($pool, 4)), 0, 4).'-'.
			substr(str_shuffle(str_repeat($pool, 4)), 0, 4);
}

function NOTIFICAR($token, $texto, $adicional){
	
	$content = array(
		"en" => $texto
	);

	$fields = array(
		'app_id' => "52c74b91-44e0-4794-a884-e64d11d52199",
		'include_player_ids' => array($token),
		'contents' => $content,
		'data' => $adicional
		// 'large_icon' => 'http://fidelit.plugse.online/logo-black.png'
	);

	$fields = json_encode($fields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													'Authorization: Basic NmU3MzJiMjktYWU4Ny00NmVjLWI2OTYtMTI3M2M0YmMyMWZk'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	curl_close($ch);

	return $response;		
}
	
function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen( $output_file, 'wb' ); 
    fwrite( $ifp, base64_decode( $base64_string ) );
    fclose( $ifp ); 

    return $output_file; 
}

?>