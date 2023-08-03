<?php

class FCM
{
    private $web_key = "AAAA9C2OO5g:APA91bEgLpVud4yHzB4lP4vnfkaz74Ei4BN8CmB63jIPqsusoTD_xLLuG7ra4Yps39CK1QbhD8BdLinHsHabBjIwUfS0auARAMMyob7yHI7xgYhza_EMs-3mlv-fa6vCnKW-qNjtxh8A"; 
    
    public function sendNotif($device_id, $notification, $data)
    {
        $curl = 'https://fcm.googleapis.com/fcm/send';
        if(is_array($device_id)) {
            $field = [
                'registration_ids' => $device_id,
                "notification" => $notification,
                "data" => $data
            ];
        } else {
            $field = [
                'to' => $device_id,
                "notification" => $notification,
                "data" => $data
            ];
        }

        $headers = array(
            'Authorization: key=' . $this->web_key,
            'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
        $result = curl_exec($ch);      
        curl_close($ch);
        // echo $result;
    }
}


// $notification = array(
//     'title' => 'Transaksi Sukses',
//     'text' => 'Pesanan Telkomsel Reguler 10.000 Sukses',
//     'click_action' =>  'Open_URI',
// );

// $data = array(
//     'picture' => 'https://cdn.icon-icons.com/icons2/894/PNG/512/Tick_Mark_Dark_icon-icons.com_69147.png',
//     'uri' =>  base_url('order/detail/'.$id),
// );

// /*
//     CATATAN PENGGUNAAN NOTIFIKASI

// FORMAT PENERIMA NOTIFIKASI :
//     > KE USER TERTENTU :
//         $fcm_token = [
//             "Token User 1",
//             "Token User 2",
//             "Token User ...",
//         ];

//     > KE SELURUH USER
//     $fcm_token = "/topics/NgalehKuy";

//     *Note: NgalehKuy (bersifat constant tidak boleh diganti)

// */

// // Kirim ke seluruh user
// $fcm_token = "/topics/NgalehKuy";

// $fcm = new FCM();
// $fcm->send_notification($fcm_token, $notification, $data);