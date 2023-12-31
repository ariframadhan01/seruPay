<?php
date_default_timezone_set('Asia/Jakarta');
class BNI
{
    protected $ch;
    protected $user_agen =
        'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36';
    protected $cookie;
    protected $action_url;
    protected $mbparam;
    protected $logged_id = false;

    public function __construct()
    {
        if (defined('APPPATH'))
            $this->cookie = APPPATH . 'cache/bank_bni-cookie.txt';
        else
            $this->cookie = dirname(__file__) . '/bank_bni-cookie.txt';

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookie);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agen);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
    }

    public function login($username, $password)
    {
        if ($this->logged_id)
            return true;

        curl_setopt($this->ch, CURLOPT_URL,
            'https://ibank.bni.co.id/MBAWeb/FMB;jsessionid=0000gsadMFnW4TJnYCFiblgmvcx:1a1li5jho?page=Thin_SignOnRetRq.xml&MBLocale=bh');
        $result = curl_exec($this->ch);
        preg_match('/<form(.*?)action="(?<action_url>(.*?))"/', $result, $matches);

        if (!isset($matches['action_url']))
            return false;

        $this->action_url = $matches['action_url'];
        $param = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+" .
            "field+is+empty%21%22&CorpId=$username&PassWord=$password&__AUTHENTICATE__=Login&C" .
            "ancelPage=HomePage.xml&USER_TYPE=1&MBLocale=bh&language=bh&AUTHENTICATION_REQUEST" .
            "=True&__JS_ENCRYPT_KEY__=&JavaScriptEnabled=N&deviceID=&machineFingerPrint=&devic" .
            "eType=&browserType=&uniqueURLStatus=disabled&imc_service_page=SignOnRetRq&Alignme" .
            "nt=LEFT&page=SignOnRetRq&locale=en&PageName=Thin_SignOnRetRq.xml&formAction=https" .
            "%3A%2F%2Fibank.bni.co.id%2FMBAWeb%2FFMB%3Bjsessionid%3D0000gsadMFnW4TJnYCFiblgmvc" .
            "x%3A1a1li5jho&mConnectUrl=FMB&serviceType=Dynamic";
        curl_setopt($this->ch, CURLOPT_URL, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        $result = curl_exec($this->ch);
        preg_match('/class="MainMenuStyle" href="(?<url>(.*?))">/', $result, $matches);
        if (!isset($matches['url']))
            return false;

        parse_str($matches['url'], $params);
        if (!isset($params['mbparam']))
            return false;

        $this->mbparam = urlencode($params['mbparam']);
        $this->logged_id = true;
        return true;
    }

    public function get_balance($nomor_rekening)
    {
        if (!$this->logged_id)
            return 0;

        $nomor_rekening = substr('00000000000' . $nomor_rekening, -17);
        $url_enc = urlencode($this->action_url);
        $param = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+" .
            "field+is+empty%21%22&acc1=OPR%7C$nomor_rekening%7CBNI+TAPLUS&BalInqRq=Lanjut&MAIN" .
            "_ACCOUNT_TYPE=OPR&mbparam={$this->mbparam}&uniqueURLStatus=disabled&imc_service_p" .
            "age=AccountIDSelectRq&Alignment=LEFT&page=AccountIDSelectRq&locale=bh&PageName=Ac" .
            "countTypeSelectRq&formAction=$url_enc&mConnectUrl=FMB&serviceType=Dynamic";
        curl_setopt($this->ch, CURLOPT_URL, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($this->ch, CURLOPT_REFERER, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        $result = curl_exec($this->ch);
        $exp = explode('id="Row5_5"', $result, 3);
        if (!isset($exp[2]))
            return 0;

        preg_match('/class="BodytextUnbold">(?<saldo>(.*?))<\/span>/', $exp[2], $matches);
        if (!isset($matches['saldo']))
            return 0;
        $array = array();
        $saldo = substr(trim($matches['saldo']), 0, -3);
        $saldo = str_replace('.', '', $saldo);
        return (int)$saldo;

    }
    
    public function get_nama($nomor_rekening)
    {
        if (!$this->logged_id)
            return 0;

        $nomor_rekening = substr('00000000000' . $nomor_rekening, -17);
        $url_enc = urlencode($this->action_url);
        $param = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+" .
            "field+is+empty%21%22&acc1=OPR%7C$nomor_rekening%7CBNI+TAPLUS&BalInqRq=Lanjut&MAIN" .
            "_ACCOUNT_TYPE=OPR&mbparam={$this->mbparam}&uniqueURLStatus=disabled&imc_service_p" .
            "age=AccountIDSelectRq&Alignment=LEFT&page=AccountIDSelectRq&locale=bh&PageName=Ac" .
            "countTypeSelectRq&formAction=$url_enc&mConnectUrl=FMB&serviceType=Dynamic";
        curl_setopt($this->ch, CURLOPT_URL, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($this->ch, CURLOPT_REFERER, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        $result = curl_exec($this->ch);
        $exp = explode('<span id="Header" class="BodytextCol11">Nama</span>', $result);
        if (!isset($exp[1]))
            return 0;

        preg_match('/class="BodytextCol2">(?<nama>(.*?))<\/span>/', $exp[1], $matches);
        if (!isset($matches['nama']))
            return 0;
        $array = array();
        $nama = substr($matches['nama'], 4);
        return $nama;

    }
    
    public function get_information($nomor_rekening)
    {
        if (!$this->logged_id)
            return array();

        $nomor_rekening = substr('00000000000' . $nomor_rekening, -17);
        $url_enc = urlencode($this->action_url);
        $param = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+" .
            "field+is+empty%21%22&acc1=OPR%7C$nomor_rekening%7CBNI+TAPLUS&BalInqRq=Lanjut&MAIN" .
            "_ACCOUNT_TYPE=OPR&mbparam={$this->mbparam}&uniqueURLStatus=disabled&imc_service_p" .
            "age=AccountIDSelectRq&Alignment=LEFT&page=AccountIDSelectRq&locale=bh&PageName=Ac" .
            "countTypeSelectRq&formAction=$url_enc&mConnectUrl=FMB&serviceType=Dynamic";
        curl_setopt($this->ch, CURLOPT_URL, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($this->ch, CURLOPT_REFERER, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        $result = curl_exec($this->ch);
        $exp1 = explode('<span id="Header" class="BodytextCol11">Nama</span>', $result);
        $exp2 = explode('<span id="Header" class="BodytextCol11">Produk</span>', $result);
        $exp3 = explode('<span id="Header" class="BodytextCol11">Mata Uang</span>', $result);
        $exp4 = explode('id="Row5_5"', $result, 3);
        if (!isset($exp1[1]) && !isset($exp2[1]) && !isset($exp3[1]) && !isset($exp4[2]))
            return array();

        preg_match('/class="BodytextCol2">(?<nama>(.*?))<\/span>/', $exp1[1], $matches1);
        preg_match('/class="BodytextCol2">(?<produk>(.*?))<\/span>/', $exp2[1], $matches2);
        preg_match('/class="BodytextCol2">(?<mata_uang>(.*?))<\/span>/', $exp3[1], $matches3);
        preg_match('/class="BodytextUnbold">(?<saldo>(.*?))<\/span>/', $exp4[2], $matches4);
        $array = array();
        $saldo = substr(trim($matches4['saldo']), 0, -3);
        $saldo = str_replace('.', '', $saldo);
        $array[] = array(
                'name' => substr($matches1['nama'], 4),
                'product' => $matches2['produk'],
                'currency' => $matches3['mata_uang'],
                'balance' => $saldo,
                );
        if (!$array) {
            return ['result' => false, 'data' => null, 'message' => $array];
        } else {
            return ['result' => true, 'data' => $array,'message' => 'Account Information successfully obtained.'];
        }
    }

    public function get_transactions($nomor_rekening, $dari_tgl = null, $ke_tgl = null)
    {
        if (!$this->logged_id)
            return array();
        $nomor_rekening = substr('00000000000' . $nomor_rekening, -17);
        if (!$dari_tgl || !$ke_tgl) {
            $dari_tgl = date('d-m-Y', time() - (3600 * 24 * 3)); // 7 hari
            $ke_tgl = date('d-m-Y');
        }
        if (date('m', strtotime($dari_tgl)) != date('m', strtotime($ke_tgl)))
            $dari_tgl = $ke_tgl;
        $data = '';
        $result = $this->grab_transactions($nomor_rekening, $dari_tgl, $ke_tgl);
        if (stripos($result, 'ditentukan dan tanggal yang valid') !== false) {
            $dari_tgl = date('d-M-Y', strtotime($dari_tgl));
            $ke_tgl = date('d-M-Y', strtotime($ke_tgl));
            $data = $this->grab_transactions($nomor_rekening, $dari_tgl, $ke_tgl);
        } else {
            $data = $result;
        }
        if (stripos($data, '<span id="Header" class="BodytextCol1">Tanggal Transaksi</span>')
            === false) {
            return array();
        }
        $array = array();
        $exp = explode('<span id="Header" class="BodytextCol1">Tanggal Transaksi</span>',
            $data);
        foreach ($exp as $item) {
            if (stripos($item, '<span id="Header" class="BodytextCol1">Uraian Transaksi</span>')
                === false)
                continue;
            preg_match_all('/<span id="H"(.*?)>(?<data>(.*?))<\/span>/', $item, $matches);
            if (!isset($matches['data']))
                continue;
            $nominal = (int)str_replace('.', '', substr($matches['data'][3], 4, -3));
            $array = "-";
            $this_data[] = array(
                'tanggal' => date('Y-m-d', strtotime($matches['data'][0])),
                'keterangan' => $matches['data'][1],
                'debet' => $matches['data'][2] == 'Db' ? $nominal : 0,
                'kredit' => $matches['data'][2] == 'Cr' ? $nominal : 0,
                'type' => $matches['data'][2],
                );
            //$array = array('status' => true, 'data' => $this_data, 'message' => 'Account Mutation successfully obtained.');
        }
        if (!$this_data) {
            return ['result' => false, 'data' => null, 'message' => $this_data];
        } else {
            return ['result' => true, 'data' => $this_data,'message' => 'Account Mutation successfully obtained.'];
        }
        //return $array;
    }

    protected function grab_transactions($nomor_rekening, $dari_tgl, $ke_tgl)
    {
        $url_enc = urlencode($this->action_url);
        $param = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+" .
            "field+is+empty%21%22&acc1=OPR%7C$nomor_rekening%7CBNI+TAPLUS&TxnPeriod=-1&Search_" .
            "Option=Date&txnSrcFromDate=$dari_tgl&txnSrcToDate=$ke_tgl&FullStmtInqRq=Lanjut&MA" .
            "IN_ACCOUNT_TYPE=OPR&mbparam={$this->mbparam}&uniqueURLStatus=disabled&imc_service" .
            "_page=AccountIDSelectRq&Alignment=LEFT&page=AccountIDSelectRq&locale=bh&PageName=" .
            "AccountTypeSelectRq&formAction=$url_enc&mConnectUrl=FMB&serviceType=Dynamic";
        curl_setopt($this->ch, CURLOPT_URL, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_REFERER, $this->action_url);
        $result = curl_exec($this->ch);
        return $result;
    }

    public function logout()
    {
        if (!$this->logged_id)
            return false;

        $param = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+" .
            "field+is+empty%21%22&__LOGOUT__=Keluar&mbparam=" . $this->mbparam .
            "&uniqueURLStatus=disabled&imc_service_page=SignOffUrlRq&Alignment=LEFT&page=SignO" .
            "ffUrlRq&locale=bh&PageName=LoginRs&formAction=" . urlencode($this->action_url) .
            "&mConnectUrl=FMB&serviceType=Dynamic";
        curl_setopt($this->ch, CURLOPT_URL, $this->action_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_REFERER, $this->action_url);
        $result = curl_exec($this->ch);
        curl_close($this->ch);
        unlink($this->cookie);
        return true;
    }
}

