<?php

namespace Wead\DigitalCep;

use Exception;

class Search{
    private $url = "https://viacep.com.br/ws/";

    public function getAddressFromZipCode(string $zipCode){
        try {
            ini_set('default_socket_timeout', 10);

            $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

            $get = file_get_contents($this->url . $zipCode . "/json");
            if($get === false){
                throw new Exception('Erro ao tentar estabelecer conexão com o site Viacep. Por favor tente novamente mais tarde (TIMEOUT)');
            }

            $retornoDecod = count((array)json_decode($get)) ? (array)json_decode($get) : 'Nenhum registro encontrado com esse CEP';
            
            return array(
                'status' => 'Retorno obtido com suceso',
                'mensagem' => $retornoDecod
            );
        } catch (Exception $ex) {
            return array(
                'status' => 'ERRO',
                'mensagem' => $ex->getMessage()
            );
        }
    }
}
