<?php

    function curl($url, $arrayDados, $method){
        if(empty($url)) throw new Exception('Necessário envio da url');
        if(empty($arrayDados) || !is_array($arrayDados)) throw new Exception('Dados post tipagem incorreta');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($method!='GET' || $method!='get' ){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayDados);
        }else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arrayDados));
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }


    $url = 'https://www.receitaws.com.br/v1/cnpj/';

    $resp = curl($url, '03920751000629', 'GET');

    print_r($resp);

?>