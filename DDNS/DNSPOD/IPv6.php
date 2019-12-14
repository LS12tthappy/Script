<?php
//parameter
$ID='';
$token='';
$domain='';
$record=array(""=>"",""=>"");
$key='';

$login=$ID.','.$token;
$client_ip=$_SERVER['REMOTE_ADDR'];  //Client IPv6

function curl_post($url,array $post_data){
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //$post
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    
    $res = curl_exec($ch);
    
    curl_close($ch);
    return $res;
    
}

function is_ipv6($ip)
{
    if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
        return true;
    else 
        echo "Client IP is not IPv6 Address\n";
        return false;
}

if($_GET['key'] == $key){
    if(is_ipv6($client_ip)){
        $post_data = array ("login_token" => $login ,"domain" => $domain,"format"=>'json','record_id'=> current($record);
        $res = json_decode(curl_post("https://dnsapi.cn/Record.Info",$post_data),true);
        if($res['record']['value'] !== $client_ip){
            foreach ($record as $key => $value) {
                $post_data = array ("login_token" => $login ,"domain" => $domain,"format"=>'json','record_line'=>'默认','record_id'=> $value,'record_type'=>'AAAA','value'=>$client_ip,'ttl'=>'180','sub_domain'=>$key);
                $res = json_decode(curl_post("https://dnsapi.cn/Record.Modify",$post_data),true);
                print_r($res);
        };
        } else{
            echo "record is right";
        }
    }
} else{
    echo 'Invalid Key';
}
    //$res=json_decode(curl_post("https://dnsapi.cn/Record.List",$post_data),true);
    //array_column($res['records'],'name');

?>