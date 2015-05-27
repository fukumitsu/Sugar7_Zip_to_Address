<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ZipToAddress extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetItemEndpoint' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array('ZipToAddress'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'GetItems',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Get Address',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }
 
    public function GetItems($api, $args)
    {
        if($args['type'] == 'japanese') {
            $argments['zipcode'] = $args['zip'];
            $url = 'http://zipcloud.ibsnet.co.jp/api/search';
            return self::call_service($url, '', 'GET',$argments, true, false, true);
        } else {
            $url = 'http://api.zippopotam.us/'  . $args['CC'].'/'. $args['zip'];
            return self::call_service($url, '', 'GET','' , true, false, true);
        }
    }

    /**
     * Generic function to make cURL request.
     * @param $url - The URL route to use.
     * @param string $oauthtoken - The oauth token.
     * @param string $type - GET, POST, PUT, DELETE. Defaults to GET.
     * @param array $arguments - Endpoint arguments.
     * @param array $encodeData - Whether or not to JSON encode the data.
     * @param array $returnHeaders - Whether or not to return the headers.
     * @return mixed
     */
    private function call_service(
        $url,
        $oauthtoken='',
        $type='GET',
        $arguments=array(),
        $encodeData=true,
        $returnHeaders=false,
        $decode=true
    )
    {
        $type = strtoupper($type);
        if ($type == 'GET')
        {
            $url .= "?" . http_build_query($arguments);
        }
        $curl_request = curl_init($url);
        if ($type == 'POST')
        {
            curl_setopt($curl_request, CURLOPT_POST, 1);
        }
        elseif ($type == 'PUT')
        {
            curl_setopt($curl_request, CURLOPT_CUSTOMREQUEST, "PUT");
        }
        elseif ($type == 'DELETE')
        {
            curl_setopt($curl_request, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, $returnHeaders);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);
        if (!empty($oauthtoken))
        {
            $token = array("oauth-token: {$oauthtoken}");
            curl_setopt($curl_request, CURLOPT_HTTPHEADER, $token);
        }
        if (!empty($arguments) && $type !== 'GET')
        {
            if ($encodeData)
            {
                //encode the arguments as JSON
                $arguments = json_encode($arguments);
            }
            curl_setopt($curl_request, CURLOPT_POSTFIELDS, $arguments);
        }
        $result = curl_exec($curl_request);
        if ($returnHeaders)
        {
            //set headers from response
            list($headers, $content) = explode("\r\n\r\n", $result ,2);
            foreach (explode("\r\n",$headers) as $header)
            {
                header($header);
            }
            //return the nonheader data
            return trim($content);
        }
        curl_close($curl_request);
        //decode the response from JSON
        $response = $result;
        if ($decode) {
            $response = json_decode($result);
        }
        return $response;
    }
}
?>