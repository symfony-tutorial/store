<?php

namespace AppBundle\Service;

class JsonRpcClient
{

    private $url;
    private $username;
    private $password;

    function __construct($url, $username, $password) {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    public function call($method, $params = array(), $id = 'id') {
        $data = json_encode(array(
            "jsonrpc" => "2.0",
            "id" => $id,
            "method" => $method,
            "params" => $params,
        ));

        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        return json_decode(curl_exec($curl));
    }

}
