<?php //if (!defined('BASEPATH')) exit('No direct script access allowed');

function notifyOrder($order_store, $status) {
    $model = get_instance();
    $model->load->model('m_model');
    $checkOrderStore = $model->m_model->selectas('id', $order_store, 'orders_store');
    if (count($checkOrderStore) > 0) {
        $checkOrders = $model->m_model->selectas('id', $checkOrderStore[0]->orders, 'orders');
        if (count($checkOrders) > 0) {
            $checkOrderDetail = $model->m_model->selectas('orders_store', $checkOrderStore[0]->id, 'orders_detail');
            if (count($checkOrderDetail) > 0) {
            //------

                $getSupplier = $model->m_model->selectas('id', $checkOrderStore[0]->store, 'store');
                $getMarketer = $model->m_model->selectas('id', $checkOrderDetail[0]->agent, 'store');

                switch ($status) {
                    case '0':
                        $paramSupplier = array(
                            'user' => $getSupplier[0]->user, 
                            'global_id' => $order_store, 
                            'global_type' => 'order_store', 
                            'notify' => 'New Order #'.$checkOrders[0]->ref, 
                            'link' => 'supplier?detail='.$order_store, 
                            'date' => date('Y-m-d h:i:s')
                        );
                        $model->m_model->create($paramSupplier, 'user_notify');

                        if (count($getMarketer) > 0) {
                            $paramCustomer = array(
                                'user' => $getMarketer[0]->user, 
                                'global_id' => $order_store, 
                                'global_type' => 'order_store', 
                                'notify' => 'New Order #'.$checkOrders[0]->ref, 
                                'link' => 'marketer', 
                                'date' => date('Y-m-d h:i:s')
                            );
                            $model->m_model->create($paramCustomer, 'user_notify');
                        }
                        break;

                    case '1':
                        $paramCustomer = array(
                            'user' => $checkOrders[0]->user, 
                            'global_id' => $order_store, 
                            'global_type' => 'order_store', 
                            'notify' => 'Order was processed #'.$checkOrders[0]->ref, 
                            'link' => 'member/order/'.$order_store, 
                            'date' => date('Y-m-d h:i:s')
                        );
                        $model->m_model->create($paramCustomer, 'user_notify');

                        if (count($getMarketer) > 0) {
                            $paramCustomer = array(
                                'user' => $getMarketer[0]->user, 
                                'global_id' => $order_store, 
                                'global_type' => 'order_store', 
                                'notify' => 'Order was processed #'.$checkOrders[0]->ref, 
                                'link' => 'marketer', 
                                'date' => date('Y-m-d h:i:s')
                            );
                            $model->m_model->create($paramCustomer, 'user_notify');
                        }
                        break;

                    case '2':
                        $paramCustomer = array(
                            'user' => $checkOrders[0]->user, 
                            'global_id' => $order_store, 
                            'global_type' => 'order_store', 
                            'notify' => 'Order was shipped #'.$checkOrders[0]->ref, 
                            'link' => 'member/order/'.$order_store, 
                            'date' => date('Y-m-d h:i:s')
                        );
                        $model->m_model->create($paramCustomer, 'user_notify');

                        if (count($getMarketer) > 0) {
                            $paramCustomer = array(
                                'user' => $getMarketer[0]->user, 
                                'global_id' => $order_store, 
                                'global_type' => 'order_store', 
                                'notify' => 'Order was shipped #'.$checkOrders[0]->ref, 
                                'link' => 'marketer', 
                                'date' => date('Y-m-d h:i:s')
                            );
                            $model->m_model->create($paramCustomer, 'user_notify');
                        }
                        break;

                    case '3':
                        $paramSupplier = array(
                            'user' => $getSupplier[0]->user, 
                            'global_id' => $order_store, 
                            'global_type' => 'order_store', 
                            'notify' => 'Order Complete #'.$checkOrders[0]->ref, 
                            'link' => 'supplier?detail='.$order_store, 
                            'date' => date('Y-m-d h:i:s')
                        );

                        $model->m_model->create($paramSupplier, 'user_notify');
                        break;

                    case '4':
                        $paramCustomer = array(
                            'user' => $checkOrders[0]->user, 
                            'global_id' => $order_store, 
                            'global_type' => 'order_store', 
                            'notify' => 'Order was cancelled #'.$checkOrders[0]->ref, 
                            'link' => 'member/order/'.$order_store, 
                            'date' => date('Y-m-d h:i:s')
                        );
                        $model->m_model->create($paramCustomer, 'user_notify');

                        if (count($getMarketer) > 0) {
                            $paramCustomer = array(
                                'user' => $getMarketer[0]->user, 
                                'global_id' => $order_store, 
                                'global_type' => 'order_store', 
                                'notify' => 'Order was cancelled #'.$checkOrders[0]->ref, 
                                'link' => 'marketer', 
                                'date' => date('Y-m-d h:i:s')
                            );
                            $model->m_model->create($paramCustomer, 'user_notify');
                        }
                        break;

                    default:
                        # code...
                        break;
                }

            //-----
            }
        }
    }
}

function confirmOrder($order_store, $customer) {
    $model = get_instance();
    $model->load->model('m_model');
    $checkOrderStore = $model->m_model->selectas('id', $order_store, 'orders_store');
    if (count($checkOrderStore) > 0) {
        $checkOrders = $model->m_model->selectas('id', $checkOrderStore[0]->orders, 'orders');
        if (count($checkOrders) > 0) {
            if ($checkOrders[0]->user == $customer) {
                $checkOrderDetail = $model->m_model->selectas('orders_store', $checkOrderStore[0]->id, 'orders_detail');
                $FeeService = 0;
                if (count($checkOrderDetail) > 0) {
                    $wallet = 0;
                    foreach ($checkOrderDetail as $key => $valueDetail) {
                        $getProductStore = $model->m_model->selectas('id', $valueDetail->product_store, 'product_store');
                        if (count($getProductStore) > 0) {
                            //check harga apakah lebih dari 50.000.000 rupiah atau tidak
                            //jika iya makan ada potongan dana yang akan diterima oleh supplier
                            if ($getProductStore[0]->store_type == '1') {
                                $priceProductOrder=$valueDetail->price_basic * $valueDetail->quantity;
                                $FeeService=checkFeeForProduct($priceProductOrder);
                                //-- comission marketer
                                $getMarketer = $model->m_model->selectas2('id', $valueDetail->agent, 'marketer', '1', 'store');
                                if (count($getMarketer) > 0) {
                                    $getUserMarketer = $model->m_model->selectas('id', $getMarketer[0]->user, 'user');
                                    if (count($getUserMarketer) > 0) {
                                        $KomisiMkt=($valueDetail->price - $valueDetail->price_basic) * $valueDetail->quantity;
                                        //komisi marketer akan di potong dulu dengan function DiscKomisi($komisi, $Disc%)
                                        $potonganKomisi=DiscKomisi($KomisiMkt, 20);
                                        $KomisiMkt=$KomisiMkt-$potonganKomisi['potongan'];

                                        //hitung wallet marketer
                                        $wallet = $KomisiMkt + $getUserMarketer[0]->wallet;

                                        //add wallet perusahaan hasil dari potongan komisi markter
                                        updateWalletCompany($potonganKomisi['potongan']);


                                        $model->m_model->updateas('id', $getUserMarketer[0]->id, array('wallet' => $wallet), 'user');
                                    }
                                }
                                //-- commision supplier
                                $getSupplier = $model->m_model->selectas('id', $checkOrderStore[0]->store, 'store');
                                if (count($getSupplier) > 0) {
                                    $getUserSupplier = $model->m_model->selectas('id', $getSupplier[0]->user, 'user');
                                    if (count($getUserSupplier) > 0) {
                                        $subtotalHPP=($valueDetail->price_basic * $valueDetail->quantity);
                                        // check business creator dulu untuk mengurus fee
                                        //$FeeBCreator=BCreator($checkOrderStore[0]->store, $subtotalHPP);
                                        $FeeBCreator=0;
                                        $wallet = ($subtotalHPP - $FeeService - $FeeBCreator) + $getUserSupplier[0]->wallet;
                                        $model->m_model->updateas('id', $getUserSupplier[0]->id, array('wallet' => $wallet), 'user');
                                        //setalah update wallet toko berhasil
                                        //sekarang update wallet admin untuk penambahan fee yang didapat
                                        updateWalletCompany($FeeService);
                                    }
                                }
                            } else {
                                $priceProductOrder=$valueDetail->price * $valueDetail->quantity;
                                $FeeService=checkFeeForProduct($priceProductOrder);
                                //-- commision supplier
                                $getSupplier = $model->m_model->selectas('id', $checkOrderStore[0]->store, 'store');
                                if (count($getSupplier) > 0) {
                                    $getUserSupplier = $model->m_model->selectas('id', $getSupplier[0]->user, 'user');
                                    if (count($getUserSupplier) > 0) {
                                        //hitung potongan komisi supplier
                                        $KomisiSupplier=($valueDetail->price - $valueDetail->price_basic) * $valueDetail->quantity ;
                                        //komisi marketer akan di potong dulu dengan function DiscKomisi($komisi, $Disc%)
                                        $potonganKomisiSupplier=DiscKomisi($KomisiSupplier, 20);

                                        $wallet = (($valueDetail->price * $valueDetail->quantity) - $FeeService - $potonganKomisiSupplier['potongan']) + $getUserSupplier[0]->wallet;
                                        $model->m_model->updateas('id', $getUserSupplier[0]->id, array('wallet' => $wallet), 'user');
                                        //setalah update wallet toko berhasil
                                        //sekarang update wallet admin untuk penambahan fee yang didapat
                                        updateWalletCompany($FeeService + $potonganKomisiSupplier['potongan']);
                                    }
                                }
                            }
                            $getProduct = $model->m_model->selectas('id', $getProductStore[0]->product, 'product');
                            if (count($getProduct) > 0) {
                                $qty = $getProduct[0]->quantity - $valueDetail->quantity;
                                $model->m_model->updateas('id', $getProduct[0]->id, array('quantity' => $qty), 'product');
                            }
                        }
                    }
                }
                $model->m_model->updateas('id', $order_store, array('orders_status' => 3), 'orders_store');
            }
        }
        //-- Add fund shipping cost to supplier
        $getSupplier = $model->m_model->selectas('id', $checkOrderStore[0]->store, 'store');
        if (count($getSupplier) > 0) {
            $getUserSupplier = $model->m_model->selectas('id', $getSupplier[0]->user, 'user');
            if (count($getUserSupplier) > 0) {
                $wallet = $checkOrderStore[0]->shipping_cost + $getUserSupplier[0]->wallet;
                $model->m_model->updateas('id', $getUserSupplier[0]->id, array('wallet' => $wallet), 'user');
            }
        }
    }
}

function checkFeeForProduct($priceProduct=null){
    $Fee=0;
    if($priceProduct!=null){
        if($priceProduct >=50000000){
            $Fee=$priceProduct*1/100;
        }
        else{
            $Fee=0;
        }
    }
    return $Fee;
}

function DiscKomisi($komisi=0, $disc=0){
    //$disc dalam bentuk persentasi 20=20%, 30=30%, 75=75%
    $r=array();
    $r['potongan']= $komisi*$disc/100;
    return $r;
}

function updateWalletCompany($value=0){
    //$value itu nilai yang dipakai untuk memotong hasil komisi marketer jadi nilai potongan itu masuk
    //ke wallet perusahaan
    $model = get_instance();
    //check wallet perusahaan dulu
    $data = $model->m_model->selectas('name_company', 'Bazaarplace', 'wallet_admin');
    if(count($data)>0){
        $walletCompany=$data[0]->wallet+$value;
        $update_status = $model->m_model->updateas('id', $data[0]->id, array('wallet'=>$walletCompany), 'wallet_admin');
    }
    else{
        $walletCompany=$value;
        $paramWallet=array(
                        'name_company'=>'Bazaarplace',
                        'wallet'=>$walletCompany
                    );
        $model->m_model->create($paramWallet, 'wallet_admin');
    }

    return TRUE;    
}

function FeeBCreator($store_supplier, $product_store_id, $subtotal=0){
    $model = get_instance();
    //check apakah ada business cretornya atau tidak
    $BCreator=$model->m_model->selectas2('store_id_supplier', $store_supplier,'product_store_id', $$product_store_id, 'business_creator');
    $komisi=0;
    if(count($BCreator)>0){
        foreach ($BCreator as $keyBCreator => $valueBCreator) {
            # code...
            $fee=$valueBCreator->fee; //ini dalam bentuk %
            $komisi= ($subtotal * $fee/100);
        }
    }
    else{
        $komisi=0;
    }
    return $komisi;   
}

function categories() {
    $model = get_instance();
    $model->load->model('m_model');
    $sql="select * from category_parent ORDER BY order_nav ASC, id ASC";
    $data = $model->m_model->selectcustom($sql);
    return $data;
}

function categories_store($categories_store=null) {
    $model = get_instance();
    $model->load->model('m_model');
    if($categories_store!=null){
        $where = "id in (".$categories_store.")";
    }
    else{
        $where = "";
    }
    $sql="select * from category_parent where ".$where." ORDER BY order_nav ASC, id ASC";
    $data = $model->m_model->selectcustom($sql);
    return $data;
}

function categoryParentName($id, $lang=null) {
    $model = get_instance();
    $model->load->model('m_model');
    $data = $model->m_model->selectas('id', $id, 'category_parent');
    if (count($data) > 0) {
        if($lang==null || $lang=='bahasa'){
          return $data[0]->name_id;
        }
        else{
          return $data[0]->name;
        }
    }
}

function categoryParentSEO($id) {
    $model = get_instance();
    $model->load->model('m_model');
    $data = $model->m_model->selectas('id', $id, 'category_parent');
    if (count($data) > 0) {
        return $data[0]->seo;
    }
}

function categorySubName($id, $lang=null) {
    $model = get_instance();
    $model->load->model('m_model');
    $data = $model->m_model->selectas('id', $id, 'category_sub');
    if (count($data) > 0) {
        if($lang==null || $lang=='bahasa'){
          return $data[0]->name_id;
        }
        else{
          return $data[0]->name;
        }
    }
}

function categoryChildName($id, $lang=null) {
    $model = get_instance();
    $model->load->model('m_model');
    $data = $model->m_model->selectas('id', $id, 'category_child');
    if (count($data) > 0) {
        if($lang==null || $lang=='bahasa'){
          return $data[0]->name_id;
        }
        else{
          return $data[0]->name;
        }
    }
}

function categorySubList($id) {
    $model = get_instance();
    $model->load->model('m_model');
    $data = $model->m_model->selectas('id', $id, 'category_sub');
    if (count($data) > 0) {
        return $data[0]->name;
    }
}

function membership($id=null) {
    $model = get_instance();
    $model->load->model('m_model');
    $data = $model->m_model->select('membership');
    return $data;
}

function membershipDetail($id=null) {
    $model = get_instance();
    $model->load->model('m_model');
    $query_custom="select A.*, B.type, B.badge
                    from membership_detail A 
                    join membership B on (B.id = A.membership_id)
                    where A.price>0
                    order by A.membership_id, A.period ASC";
    $data = $model->m_model->selectcustom($query_custom);
    return $data;
}

function checkmembership($user_id=null) {
    $model = get_instance();
    $model->load->model('m_model');
    $date_current=date('Y-m-d');
    $query_custom="select A.*
                    from invoices_membership A 
                    where A.status=1 && A.status_payment=2 && A.user_id=".$user_id."
                    limit 1";
    $data['data'] = $model->m_model->selectcustom($query_custom);
    if(count($data['data'])>0){
        //count sisa harganya
        $arr_date_expired=explode('-', $data['data'][0]->date_expired);
        $date_expired=date("Y-m-d", mktime( 0, 0, 0, $arr_date_expired[1], $arr_date_expired[2], $arr_date_expired[0]));
        if(strtotime($date_expired)>= strtotime($date_current)){
            $data['status']="1";
        }
        else{
            $data['status']="2";
            $update_status = $model->m_model->updateas('id', $data['data'][0]->id, array('status'=>$data['status']), 'invoices_membership');
            $update_badge = $model->m_model->updateas('user', $user_id, array('badge'=>NULL), 'store');
        }
    }
    else{
        $data['status']=0;
    }
    return $data;
}
//----------------

function check_img($path=null) {
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $data=array();
    if($path==null){
        $data['path']=site_url('images/images.jpeg');
        return $data;
    }

    $path_arr=explode('/', $path);
    $num_path_arr=count($path_arr);
    $i=1;
    $new_path="";
    foreach ($path_arr as $value) {
        if($i == $num_path_arr){
            $value=rawurlencode($value) ;
            $new_path.=$value;
        }
        else{
            $new_path.=$value."/";
        }
        $i++;
    }
    $headers = get_headers(site_url($new_path));
    $id_header=substr($headers[0], 9, 3);
    if($id_header==200){
        //connection OK 
        $data['path']=site_url($new_path);
    }
    else{
        //connection NOT FOUND
        $data['path']=site_url('images/images.jpeg');
    }
    return $data;
}

function convert_tgl_dMY($time) {
    if($time==null || $time=='0000-00-00'){
        return '-';
    }
    $strtime=strtotime($time);
    $tgl=date('d M Y', $strtime);
    return $tgl;
}

function convert_tgl_MdY($time) {
    $strtime=strtotime($time);
    $tgl=date('M d Y', $strtime);
    return $tgl;
}

function convert_time_HiMdY($time) {
    $strtime=strtotime($time);
    $tgl=date('H:i | M d Y', $strtime);
    return $tgl;
}
function convert_time_NdMYHis($time) {
    $strtime=strtotime($time);
    $tgl=date('l, d F Y H:i:s', $strtime);
    return $tgl;
}

function convert_time_dmy($time, $type_date='date') {
    if($time==null || $time=='0000-00-00'){
        return '';
    }
    if($type_date=='date'){
        $arr_date=explode('-', $time);
        $time=date("d-m-Y", mktime(0, 0, 0, $arr_date[1], $arr_date[2], $arr_date[0]));
    }
    //$strtime=strtotime($time);
    $tgl=$time;
    return $tgl;
}

function convert_time_ymd($time, $type_date='date') {
    if($time==null || $time=='00-00-0000'){
        return '0000-00-00';
    }
    if($type_date=='date'){
        $arr_date=explode('-', $time);
        $time=date("Y-m-d", mktime(0, 0, 0, $arr_date[1], $arr_date[0], $arr_date[2]));
    }
    //$strtime=strtotime($time);
    $tgl=$time;
    return $tgl;
}
function convert_time_ddmmyy($time, $type_date='date') {
    if($time==null){
        return '0000-00-00';
    }
    if($type_date=='date'){
        $arr_date=explode('-', $time);
        $time=date("dmy", mktime(0, 0, 0, $arr_date[1], $arr_date[0], $arr_date[2]));
    }
    //$strtime=strtotime($time);
    $tgl=$time;
    return $tgl;
}

function get_month() {
  $MonthArray = array(
    "1" => "January", "2" => "February", "3" => "March", "4" => "April",
    "5" => "May", "6" => "June", "7" => "July", "8" => "August",
    "9" => "September", "10" => "October", "11" => "November", "12" => "December",
  );
    return $MonthArray;
}

function getChannelPayment() {
    $MerchantId="32451";
    $UserId="bot32451";
    $password="hT5chpSv";
    $Signature=sha1(md5(($UserId.$password)));
    //json get_channel
    $jsonGetChannel='{"request":"Daftar Payment Channel","merchant_id":"'.$MerchantId.'", "merchant":"Indo Bazaar", "signature":"'.$Signature.'"}';
  // end param get channel payment
    $curl = curl_init();
    curl_setopt_array($curl, array(
        //CURLOPT_URL => "https://dev.faspay.co.id/cvr/100001/10", //development
        CURLOPT_URL => "https://web.faspay.co.id/cvr/100001/10", //production
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $jsonGetChannel,
        CURLOPT_SSL_VERIFYHOST=> false,
        CURLOPT_SSL_VERIFYPEER=> false
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return 0;
    }
    else {
        //print_r($response);
        $data = json_decode($response, true);
        return $data;
    }
}


function getVirtualAcc($data_invoice) {
    $MerchantId="32451";
    $UserId="bot32451";
    $password="hT5chpSv";
    $bill_no=$data_invoice['data_orders']['ref'];
    $Signature=sha1(md5(($UserId.$password.$bill_no)));
    $payment_channel=$data_invoice['data_orders']['payment'];
    $expired_payment=$data_invoice['data_orders']['expired_payment'];
    $created=$data_invoice['data_orders']['created'];
    $user=$data_invoice['data_orders']['user'];
    $user_name=$data_invoice['user_data']->name;
    $email=$data_invoice['user_data']->email;
    $phone_number=$data_invoice['user_data']->phone;
    $total_amount=$data_invoice['total_amount'];
    //json get_channel
    $jsonGetVA='{
                      "request":"Transmisi Info Detil Pembelian",
                      "merchant_id":"'.$MerchantId.'",
                      "merchant":"Indo Bazaar",
                      "bill_no":"'.$bill_no.'",
                      "bill_reff":"'.$bill_no.'",
                      "bill_date":"'.$created.'",
                      "bill_expired":"'.$expired_payment.'",
                      "bill_desc":"Pembayaran #'.$bill_no.'",
                      "bill_currency":"IDR",
                      "bill_gross":"0",
                      "bill_miscfee":"0",
                      "bill_total":"'.$total_amount.'",
                      "cust_no":"'.$user.'",
                      "cust_name":"'.$user_name.'",
                      "payment_channel":"'.$payment_channel.'",
                      "pay_type":"1",
                      "bank_userid":"",
                      "msisdn":"'.$phone_number.'",
                      "email":"'.$email.'",
                      "terminal":"10",
                      "billing_name":"0",
                      "billing_lastname":"0",
                      "billing_address":"",
                      "billing_address_city":"",
                      "billing_address_region":"",
                      "billing_address_state":"",
                      "billing_address_poscode":"",
                      "billing_msisdn":"",
                      "billing_address_country_code":"ID",
                      "receiver_name_for_shipping":"",
                      "shipping_lastname":"",
                      "shipping_address":"",
                      "shipping_address_city":"",
                      "shipping_address_region":"",
                      "shipping_address_state":"",
                      "shipping_address_poscode":"",
                      "shipping_msisdn":"",
                      "shipping_address_country_code":"ID",
                      "item":[
                        {
                          "product":"'.$bill_no.'",
                          "qty":"1",
                          "amount":"'.$total_amount.'",
                          "payment_plan":"01",
                          "merchant_id":"'.$MerchantId.'",
                          "tenor":"00"
                        }
                      ],
                      "reserve1":"",
                      "reserve2":"",
                      "signature":"'.$Signature.'"
                    }';
  // end param get channel payment
    $curl = curl_init();
    curl_setopt_array($curl, array(
        //CURLOPT_URL => "https://dev.faspay.co.id/cvr/300011/10", //development
        CURLOPT_URL => "https://web.faspay.co.id/cvr/300011/10", //production
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $jsonGetVA,
        CURLOPT_SSL_VERIFYHOST=> false,
        CURLOPT_SSL_VERIFYPEER=> false
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    //print_r($response);
    //echo "<br>";
    //echo $err;
    //die();
    curl_close($curl);
    if ($err) {
        return 0;
    }
    else {
        //print_r($response);
        $data = json_decode($response, true);
        return $data;
    }
}

function redirect_faspay($url) {
    echo $url;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_SSL_VERIFYHOST=> false,
        CURLOPT_SSL_VERIFYPEER=> false
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if (!empty($response)) {
        return FALSE;
    }
    else {
        return TRUE;
    }
}


function dapatkanDate($day) {
    //$day should be -day or +day
    //is just string
    $theDate=date('Y-m-d H:i:s', strtotime($day.' day'));
    return $theDate;
}

function TotalOfProduct($sql) {
    $model = get_instance();
    $model->load->model('m_model');
    $query=$model->m_model->selectcustom($sql);
    $numAll=count($query);
    return $numAll;
}

function TotalOfPage($numAll, $numLimit) {
    $page=floor($numAll/$numLimit);
    $restItem=$numAll%$numLimit;
    if($restItem>0){
        $page++;
    }
    return $page;
}

function clean_string($string)
{
    # code...
    $ord=preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', nl2br($string));
    
    return $ord;
}

function pagingnation($totalProduct, $limit, $page_active, $param, $links=4){ 
    $last       = ceil( $totalProduct / $limit );
 
    $start      = ( ( $page_active - $links ) > 0 ) ? $page_active - $links : 1;
    $end        = ( ( $page_active + $links ) < $last ) ? $page_active + $links : $last;
 
    $html       = '<div class="btn-group btn-group-sm right" style="float:right">';
    $class      = ( $page_active == 1 ) ? "disabled" : "";
    $html       .= '<a id="num_page" class="btn btn-default <?php echo $class; ?>" href="'.$param.'page=' . ( $page_active - 1 ) . '">&laquo;</a>';
 
    if ( $start > 1 ) {
        $html   .= '<a class="btn btn-default " href="'.$param.'page=1">1</a>';
        $html   .= '<a class="btn btn-default disabled"><span>...</span></a>';
    }
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $page_active == $i ) ? "active" : "";
        $html   .= '<a class="btn btn-default '. $class . '" href="'.$param.'page=' . $i . '">' . $i . '</a>';
    }
 
    if ( $end < $last ) {
        $html   .= '<a class="btn btn-default disabled"><span>...</span></a>';
        $html   .= '<a id="num_page" class="btn btn-default <?php echo $class; ?>" href="'.$param.'page=' . $last . '">' . $last . '</a>';
    }
 
    $class      = ( $page_active == $last ) ? "disabled" : "";
    $html       .= '<a id="num_page" class="btn btn-default <?php echo $class; ?>" href="'.$param.'page=' . ( $page_active + 1 ) . '">&raquo;</a>';
 
    $html       .= '</div>';
 
    return $html;
}

function pagingnation_materialTheme($totalProduct, $limit, $page_active, $param, $links=4){ 
    $last       = ceil( $totalProduct / $limit );
 
    $start      = ( ( $page_active - $links ) > 0 ) ? $page_active - $links : 1;
    $end        = ( ( $page_active + $links ) < $last ) ? $page_active + $links : $last;
 
    $html       = '<nav aria-label="..." style="float:right;">
                        <ul class="pagination">';
    $class      = ( $page_active == 1 ) ? "disabled" : "";
    $html       .= '<li class="page-item '.$class.'">';
    $html       .= '<a id="num_page" onclick="event.preventDefault();" class="page-link " href="'.$param.'page=' . ( $page_active - 1 ) . '">&laquo; <span class="sr-only">Previous</span></a>';
    $html       .= '</li>';
 
    if ( $start > 1 ) {
        $html   .= '<li class="page-item">';
        $html   .= '<a id="num_page" class="page-link" href="'.$param.'page=1" onclick="event.preventDefault();" >1</a>';
        $html   .= '</li>';

        $html   .= '<li class="page-item">';
        $html   .= '<a onclick="event.preventDefault();" class="page-link disabled"><span>...</span></a>';
        $html   .= '</li>';
    }
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $page_active == $i ) ? "active" : "";
        $html   .= '<li class="page-item '. $class . '">';
        $html   .= '<a id="num_page" onclick="event.preventDefault();" class="page-link " href="'.$param.'page=' . $i . '">' . $i . '</a>';
        $html   .= '</li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li class="page-item '.$class.'">';
        $html   .= '<a class="page-link disabled"><span>...</span></a>';
        $html   .= '</li>';
        $html   .= '<li class="page-item">';
        $html   .= '<a id="num_page" onclick="event.preventDefault();" class="page-link " href="'.$param.'page=' . $last . '">' . $last . '</a>';
        $html   .= '</li>';
    }
 
    $class      = ( $page_active == $last ) ? "disabled" : "";
    $html   .= '<li class="page-item '.$class.'">';
    $html       .= '<a id="num_page" onclick="event.preventDefault();" class="page-link " href="'.$param.'page=' . ( $page_active + 1 ) . '">&raquo;</a>';
    $html   .= '</li>';
 
    $html       .= '</ul>';
    $html       .= '</nav>';
 
    return $html;
}

function pagingnation_materialTheme_noNav($totalProduct, $limit, $page_active, $param, $links=4){ 
    $last       = ceil( $totalProduct / $limit );
 
    //$start      = ( ( $page_active - $links ) > 0 ) ? $page_active - $links : 1;
    $start      = ( ( $page_active - $links ) > 0 ) ? $page_active - $links : 1;
    $end        = ( ( $page_active + $links ) < $last ) ? $page_active + $links : $last;
 
    $html       = '<nav aria-label="..." style="float:right;">
                        <ul class="pagination">';

    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $page_active == $i ) ? "active" : "";
        $html   .= '<li class="page-item '. $class . '" page_id="page'.$i.'">';
        $html   .= '<a id="num_page" onclick="event.preventDefault();" class="page-link " href="'.$param.'page=' . $i . '">' . $i . '</a>';
        $html   .= '</li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li class="page-item" page_id="page'.$last.'">';
        $html   .= '<a id="num_page" onclick="event.preventDefault();" class="page-link " href="'.$param.'page=' . $last . '">' . $last . '</a>';
        $html   .= '</li>';
    }
 
    $html       .= '</ul>';
    $html       .= '</nav>';
 
    return $html;
}

function create_folder_store($combine2=null, $combine1=null){
    // Desired folder structure
    //$structure = './depth1/depth2/depth3/';
    if($combine2 == null || $combine1 == null){
        return array('status'=>FALSE);
    }
    else{
        $name_folder = $combine1.'-'.$combine2;
        $structure = FCPATH.'/images/product/'.$name_folder;
        // To create the nested structure, the $recursive parameter 
        // to mkdir() must be specified.

        if (mkdir($structure, 0777, true)) {
            return array('status'=>TRUE, 'name_directory'=>$name_folder);
        }
        else{
            return array('status'=>FALSE);
        }
    }
}

function clearText($value){
    if($value!=null){
        $value = trim($value);
        //$value = filter_var($value, FILTER_SANITIZE_MAGIC_QUOTES);
        $value = filter_var($value, FILTER_SANITIZE_ADD_SLASHES);
    }
    return $value;
}

function notifyApproval($productStore_tmp=null, $status='approved') {
    if($productStore_tmp == null){
        return false;
    }
    $model = get_instance();
    $model->load->model('m_model');
    //getlang product
    $lang_product=$model->m_model->selectas('product', $productStore_tmp[0]->product,'product_lang');
    $storeMkt=$productStore_tmp[0]->store;
    $userMkt=$productStore_tmp[0]->user;
    $productStore=$model->m_model->selectas2('product', $productStore_tmp[0]->product, 'store', $storeMkt,'product_store');
    switch ($status) {
        case 'approved':
            $paramNotify = array(
                'user' => $userMkt, 
                'global_id' => $userMkt.$productStore[0]->id, 
                'global_type' => 'userMKTproduct_store', 
                'notify' => 'New Product Approved #'.$lang_product[0]->title, 
                //'link' => 'marketer/readNotif/'.$userMkt.$productStore[0]->id.'?link=product/detail/'.$productStore[0]->id.'/'.$lang_product[0]->seo, 
                'link' => 'marketer/readNotif/'.$userMkt.$productStore[0]->id.'?link=marketer/product/', 
                'date' => date('Y-m-d h:i:s')
            );
            $model->m_model->create($paramNotify, 'user_notify');
            break;
        case 'unapproved':
            $paramNotify = array(
                'user' => $userMkt, 
                'global_id' => $userMkt.$productStore[0]->id, 
                'global_type' => 'userMKTproduct_store', 
                'notify' => 'New Product Unapproved #'.$lang_product[0]->title, 
                //'link' => 'marketer/readNotif/'.$userMkt.$productStore[0]->id, 
                'link' => 'marketer/readNotif/'.$userMkt.$productStore[0]->id.'?link=marketer/product/', 
                'date' => date('Y-m-d h:i:s')
            );
            $model->m_model->create($paramNotify, 'user_notify');
            break;
    }
}

function lsPekerjaan(){
    $model = get_instance();
    $model->load->model('m_model');
    $data=$model->m_model->select('ags_pekerjaan');
    return $data;
}

function lsKawin(){
    $model = get_instance();
    $model->load->model('m_model');
    $data=$model->m_model->select('ags_sts_kawin');
    return $data;
}

function lshubkwg(){
    $model = get_instance();
    $model->load->model('m_model');
    $data=$model->m_model->select('ags_hub_kwg');
    return $data;
}

function lsPendidikan(){
    $model = get_instance();
    $model->load->model('m_model');
    $sql="SELECT pndk_akhir FROM ags_kwg_detail_table where pndk_akhir is NOT NULL && pndk_akhir != '' group by pndk_akhir";
    $data=$model->m_model->selectcustom($sql);
    return $data;
}

function lsWil(){
    $model = get_instance();
    $model->load->model('m_model');
    $sql="SELECT * FROM wilayah";
    $data=$model->m_model->selectcustom($sql);
    return $data;
}

function ls_Hoby(){
    $model = get_instance();
    $model->load->model('m_model');
    $sql="SELECT * FROM hoby";
    $data=$model->m_model->selectcustom($sql);
    return $data;
}
function ls_Profesi(){
    $model = get_instance();
    $model->load->model('m_model');
    $sql="SELECT * FROM profesi";
    $data=$model->m_model->selectcustom($sql);
    return $data;
}

function get_name($table, $colom_id, $value_id, $colom_appear){
    $model = get_instance();
    $model->load->model('m_model');
    $data=$model->m_model->selectas($colom_id, $value_id, $table);
    return $data[0]->$colom_appear;
}

function spacetobr($value=null){
    $data='-';
    if($value!=null){
        $data=str_replace(' ', '<br>', $value) ;
    }
    return $data;

}
function checkhubkwg($value=null, $arr_hubkwg=null, $type_view=null){
    $data='-';
    if(is_numeric($value)){
        if(isset($arr_hubkwg[$value])){
            if($type_view=='pdf'){
                $data=str_replace(' ', '<br>', $arr_hubkwg[$value]['hub_keluarga']) ;
            }
            else{
                $data=$arr_hubkwg[$value]['hub_keluarga'];
            }
        }
    }
    return $data;
}
function checksts_kawin($value=null, $arr_sts_kawin=null, $type_view=null){
    $data='-';
    if(is_numeric($value)){
        if(isset($arr_sts_kawin[$value])){
            if($type_view=='pdf'){
                $data=str_replace(' ', '<br>', $arr_sts_kawin[$value]['status_kawin']) ;
            }
            else{
                $data=$arr_sts_kawin[$value]['status_kawin'];
            }
        }
    }
    return $data;
}

function checksts_pekerjaan($value=null, $type_view=null){
    $sts_pekerjaan=array(0=>'Belum Bekerja', 1=>'Sudah Bekerja', 2=>'Pensiun', );
    $data='-';
    if(is_numeric($value)){
        if(isset($sts_pekerjaan[$value])){
            if($type_view=='pdf'){
                $data=str_replace(' ', '<br>', $sts_pekerjaan[$value]) ;
            }
            else{
                $data=$sts_pekerjaan[$value];
            }
        }
    }
    return $data;
}
function checknullString($value=null)
{
    $data= $value;
    if($value==null){
        $data= '-';
    }
    return $data;

}

function checkBaptisSidi($baptis=null, $sidi=null)
{
    $data='-';
    if(in_array($baptis, array(null, 0)) && in_array($sidi, array(null, 0))){
        $data= 'Calon';
    }
    else if(in_array($baptis, array(null, 0)) && !in_array($sidi, array(null, 0))){
        $data= 'Baptis';
    }
    else if(!in_array($baptis, array(null, 0)) && !in_array($sidi, array(null, 0))){
        $data= 'SIDI';
    }

    return $data;

}

function getUmur($now=null, $past=null)
{
    $data='-';
    $d1 = new DateTime($now);
    $d2 = new DateTime($past);

    $diff = $d2->diff($d1);


    return $diff->y;

}

function getKategoriPelayanan()
{
    $model = get_instance();
    $model->load->model('m_model');
    $rdata=$model->m_model->selectas('id >= 0', null, 'ags_group_data');
    $data=array();
    //<span class="label label-warning" style="margin-right:5px;">Guru</span>
    foreach ($rdata as $key => $value) {
        # code...
        $data[$value->id]=$value;
    }
    return $data;

}

function get_dateInWeek($numberDay, $type=1){
    //$type=1 normal week | 2=next week
    $data=array();
    //1 = monday, 7=sunday
    $startDay=1;
    $startDay=$startDay-$numberDay;
    $endDay=7;
    $endDay=$endDay-$numberDay;

    if($type==2){
        $startDay=1;
        //$startDay=(($startDay-($numberDay)) * -1) ;
        $endDay=7;
        //$endDay=(($endDay-($numberDay) ) * -1);
        //if($numberDay<7){
        $numberDaynewWeek=$endDay-$numberDay+1;
        $numberDaynewWeek2=$endDay-$numberDay+7;

        //}

        $date_newWeek=date('Y-m-d', strtotime(' +'.$numberDaynewWeek.' day'));
        $date_newWeekEnd=date('Y-m-d', strtotime(' +'.$numberDaynewWeek2.' day'));
        //date_create($date_newWeekEnd); 
        //echo $date_newWeekEnd."<br>";
        //echo date('Y-m-d'); die();

        $data['date_name_from']=date('d F Y', strtotime(' +'.$numberDaynewWeek.' day'));
        $data['date_name_to']=date('d F Y', strtotime(' +'.$numberDaynewWeek2.' day'));

        $data['date_from']=date('m-d', strtotime(' +'.$numberDaynewWeek.' day'));
        $data['date_to']=date('m-d', strtotime(' +'.$numberDaynewWeek2.' day'));
    }else{
        $data['date_name_from']=date('d F Y', strtotime(' +'.$startDay.' day'));
        $data['date_name_to']=date('d F Y', strtotime(' +'.$endDay.' day'));

        $data['date_from']=date('m-d', strtotime(' +'.$startDay.' day'));
        $data['date_to']=date('m-d', strtotime(' +'.$endDay.' day'));
    }

    $arrDateFrom=explode('-', $data['date_from']);
    $arrDateTo=explode('-', $data['date_to']);

    $data['day_from']=$arrDateFrom[1];
    $data['month_from']=$arrDateFrom[0];

    $data['day_to']=$arrDateTo[1];
    $data['month_to']=$arrDateTo[0];

    return $data;

}
//CHRISTIAN FERNANDO
function singkat_nama($string=null, $limit=21, $add=''){
        //FERININGSIH BUDI
    //$string='FERININGSIH BUDI PRASADA HAGNI';
    $trim_string=trim($string);
    //echo "trim: ".$trim_string."<br>";
    $arr_nama=explode(' ', trim($trim_string));
    $lastword=-1;
    $limit=$limit;
    $tot_len=0;
    $cut_position=-1;
    $num_space=count($arr_nama);
    foreach ($arr_nama as $key => $value) {
        // code...
        $add_whitespace=null;
        if($lastword>-1){
            continue;
        }

        $len_word=strlen($value);
        $tot_len=$tot_len+$len_word+1;

        if($tot_len>=$limit){
            if($key>0){
                $lastword=$key-1;
                $cut_position=strlen($arr_nama[$key-1]);
            }
            else{
                $lastword=$key;
                $cut_position=strlen($arr_nama[$key]);
            }
        }else{
            if($tot_len<19){
                $add_whitespace="<br>";
            }
        }
    }

    $new_string="";
    if($lastword>-1){
        foreach ($arr_nama as $key => $value) {
            // code...
            if($key<=$lastword){
                $new_string.=$value." ";
            }
            else{
                $len_word=strlen($value);
                $new_string.=substr($value, 0,1).". ";
            }
        }
    }
    else{
        $new_string=$trim_string;
    }
    //echo $tot_len."<br>";
    //echo $lastword."<br>";

    return $new_string." ".$add_whitespace;

}
//ANTON MANUNGKU. 

function countBulanTercover($total_biayaKPKP, $saldo_akhir, $current_Month){
    $data=array();
    //hitung jumlah bulan yg dapat tercover karena tagihannya ini perbulan 
    //berdasarkan total_biayaKPKP (bulanan) dengan saldo akhir yg dipunya

    $est=$saldo_akhir/$total_biayaKPKP;//die($est);
    $est_tercover=date('F Y', strtotime(floor($est).' months') );
    $data['month']=$est_tercover;
    $data['num_month']=floor($est);
    return $data;
}