<?php namespace App\Libraries; 
use LSS\Array2XML;
use GuzzleHttp\Client;
use LSS\XML2Array;

class GepgProcess{
    protected $SpCode;
    protected $SubSpCode;
    protected $SpSysId;
    protected $client; 
   

    public function _construct()
    {
        $this->SpCode = 'SP19960';
        $this->SubSpCode = '1001';
        $this->SpSysId = 'WMAT001';
        
         
    }
    public function billSubmission($billDetails){
      

        
        //"digital signature\gepg.p12"
        if (!$cert_store = file_get_contents(base_url('signature') . "gepgclientprivate.pfx")) {
            echo "Error: Unable to read the cert file\n";
            exit;
        } else {
            if (openssl_pkcs12_read($cert_store, $cert_info, "passpass")) {
                
                
                //print_r($cert_info);    //Certificate Information;
                //$pkey = $cert_info['pkey'];  //private key
                //$cert = $cert_info['cert'];  //public key
                $id = round(microtime(true) * 1000);
                //Bill Request 
                $xml = Array2XML::createXML('gepgBillSubReq', $billDetails)->saveXML();
                $content =  str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $xml);

                //create signature
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");

                $signature = base64_encode($signature);  //output encrypted data base64 encoded  

                //echo "Signature of Signed Content"."\n".$signature."\n";

                //Compose xml request
                $data = "<Gepg>" . $content . "<gepgSignature>" . $signature . "</gepgSignature></Gepg>";


                $resultCurlPost = "";
                $serverIp = "https://uat1.gepg.go.tz";

                $uri = "/api/bill/sigqrequest"; //this is for q request
                //$uri = "/api/bill/sigsrequest"; //this if for s request

                $data_string = $data;
                echo "Message ready to GePG:" . "\n" . $data_string . "\n";

                $ch = curl_init($serverIp . $uri);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type:application/xml',
                        'Gepg-Com:default.sp.in',
                        'Gepg-Code:SP19960',
                        'Content-Length:' . strlen($data_string)
                    )
                );

                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

                //Capture returned content from GePG
                $resultCurlPost = curl_exec($ch);
                curl_close($ch);
                //$resultCurlPost=$data; 
                if (!empty($resultCurlPost)) {

                    echo "\n\n";
                    echo "Received Response\n";
                    echo  $resultCurlPost;
                    echo "\n";

                    //Tag for response
                    $dataTag = "gepgBillSubReqAck";
                    $signTag = "gepgSignature";

                    $vData = $this->getDataString($resultCurlPost, $dataTag);
                    $vSignature = $this->getSignatureString($resultCurlPost, $signTag);

                    echo "\n\n";
                    echo "Data Received:\n";
                    echo $vData;
                    echo "\n\n";
                    echo "Signature Received:\n";
                    echo $vSignature;
                    echo "\n";

                    if (!$pCertStore = file_get_contents("gepgpubliccertificate.pfx")) {
                        echo "Error: Unable to read the cert file\n";
                        exit;
                    } else {

                        //Read Certificate
                        if (openssl_pkcs12_read($pCertStore, $pCertInfo, "passpass")) {

                            //print_r($pCertInfo);
                            //print_r($pCertInfo['extracerts']);
                            //print_r($pCertInfo['extracerts']['0']);

                            //Decode Received Signature String
                            $rawSignature = base64_decode($vSignature);

                            //Verify Signature and state whether signature is okay or not
                            $ok = openssl_verify($vData, $rawSignature, $pCertInfo['extracerts']['0']);
                            if ($ok == 1) {
                                echo "\n\nSignature Status:";
                                echo "GOOD";
                            } elseif ($ok == 0) {
                                echo "\n\nSignature Status:";
                                echo "BAD";
                            } else {
                                echo "\n\nSignature Status:";
                                echo "UGLY, Error checking signature";
                            }
                        }
                    }
                } else {
                    echo "No result Returned" . "\n";
                }
            } else {

                echo "Error: Unable to read the cert store.\n";
                exit;
            }
        }

    }

    public function getDataString($inputStr, $dataTag)
    {
        $dataStartPos = strpos($inputStr, $dataTag);
        $dataEndPos = strrpos($inputStr, $dataTag);
        $data = substr($inputStr, $dataStartPos - 1, $dataEndPos + strlen($dataTag) + 2 - $dataStartPos);
        return $data;
    }

    public function getSignatureString($inputStr, $signTag)
    {
        $sigStartPos = strpos($inputStr, $signTag);
        $sigEndPos = strrpos($inputStr, $signTag);
        $signature = substr($inputStr, $sigStartPos + strlen($signTag) + 1, $sigEndPos - $sigStartPos - strlen($signTag) - 3);
        return $signature;
    }

}


?>