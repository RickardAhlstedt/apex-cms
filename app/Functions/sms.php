<?php

use Illuminate\Support\Facades\Cache;

if( !function_exists( 'getSMSProvider' ) ) {
    function getSMSProvider() {
        $sProvider = config( 'sms.provider' );
        $aProviders = config( 'sms.providers' );
        $aProvider = $aProviders[$sProvider];
        $aProvider['name'] = $sProvider;
        return $aProvider;
    }
}

if( !function_exists( 'sendSMS' ) ) {
    function sendSMS( array $aParams = [] ) {
        $aProvider = getSMSProvider();
        if( $aProvider['dry_run'] == '1' ) {
            $aParams['dryrun'] = 'yes';
        }
        if( strpos( $aParams['to'], ';') !== false ) {
            $aRecipients = explode( ';', $aParams['to'] );
            $aResponses = [];
            foreach( $aRecipients as $sRecipient ) {
                $aResponses[] = sendSMS( [
                    'from' => $aParams['from'],
                    'to' => $sRecipient,
                    'message' => $aParams['message']
                ] );
            }
            return $aResponses;
        }

        $aResponse = [
            'status' => 200,
            'data' => ''
        ];
        $oCH = curl_init($aProvider['service_url']);
        curl_setopt($oCH, CURLOPT_USERPWD, $aProvider['username'] . ":" . $aProvider['password']);
        curl_setopt($oCH, CURLOPT_POSTFIELDS, http_build_query($aParams));
        curl_setopt($oCH, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($oCH, CURLOPT_POST, TRUE);
        $aResponse['data'] = json_decode( curl_exec($oCH) );
        curl_close($oCH);

        return $aResponse;
    }
}

function curlSMS( $aParams ) {
    $aProvider = getSMSProvider();
    $url = 'https://api.46elks.com/a1/SMS';
    $username = $aProvider['username'];
    $password = $aProvider['password'];
    $sms = array('from' => 'DummyFrom',
                'to' => '+46734147090',
                'message' => 'Hello hello!',
                'dryrun' => 'yes');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sms));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);

    print $result;
}
