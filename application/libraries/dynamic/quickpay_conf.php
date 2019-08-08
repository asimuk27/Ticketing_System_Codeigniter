<?php

/*
 * @file    quickpay_service.inc.php
 * @author  fengmin(felix021@gmail.com)
 * @date    2011-08-22
 * @version $Revision$
 *
 */

class quickpay_conf
{

    const VERIFY_HTTPS_CERT = false;

    static $timezone        = "Asia/Shanghai"; //时区
    static $sign_method     = "md5"; //摘要算法，目前仅支持md5 (2011-08-22)

    static $security_key    = "88888888"; //商户密钥

   //支付请求预定义字段
  /*   static $pay_params  = array(
        'version'       => '1.0.0',
        'charset'       => 'GBK', //UTF-8, GBK等
        'merId'         => '620055473925001', //商户填写
        'acqCode'       => '',  
        'merCode'       => '', 
        'merAbbr'       => '87EM4CA2QY1D',
    ); */

    //* 测试环境
    static $front_pay_url   = "http://202.82.58.122:5555/DPGW/MerchantSrv/Payment.action";
    static $back_pay_url    = "http://58.246.226.99/UpopWeb/api/BSPay.action";
    static $query_url       = "http://58.246.226.99/UpopWeb/api/Query.action";
       
    const FRONT_PAY = 1;
    const BACK_PAY  = 2;
    const RESPONSE  = 3;
    const QUERY     = 4;

    const CONSUME                = "01";
    const CONSUME_VOID           = "31";
    const PRE_AUTH               = "02";
    const PRE_AUTH_VOID          = "32";
    const PRE_AUTH_COMPLETE      = "03";
    const PRE_AUTH_VOID_COMPLETE = "33";
    const REFUND                 = "04";
    const REGISTRATION           = "71";

   const CURRENCY_CNY      = "554";

    static $pay_params_empty = array(
        "origQid"           => "",
        "acqCode"           => "",
        "merCode"           => "",
        "commodityUrl"      => "",
        "commodityName"     => "",
        "commodityUnitPrice"=> "",
        "commodityQuantity" => "",
        "commodityDiscount" => "",
        "transferFee"       => "",
        "customerName"      => "",
        "defaultPayType"    => "",
        "defaultBankNumber" => "",
        "transTimeout"      => "300000",
        "merReserved"       => "",
		"transType"       => "01",
    );

    static $pay_params_check = array(
        "version",
        "charset",
        "transType",
        "origQid",
        "merId",
        "merAbbr",
        "acqCode",
        "merCode",
        "commodityUrl",
        "commodityName",
        "commodityUnitPrice",
        "commodityQuantity",
        "commodityDiscount",
        "transferFee",
        "orderNumber",
        "orderAmount",
        "orderCurrency",
        "orderTime",
        "customerIp",
        "customerName",
        "defaultPayType",
        "defaultBankNumber",
        "transTimeout",
        "frontEndUrl",
        "backEndUrl",
        "merReserved",
    );

    static $query_params_check = array(
        "version",
        "charset",
        "transType",
        "merId",
        "orderNumber",
        "orderTime",
        "merReserved",
    );

    static $mer_params_reserved = array(
    //  NEW NAME            OLD NAME
        "cardNumber",       "pan",
        "cardPasswd",       "password",
        "credentialType",   "idType",
        "cardCvn2",         "cvn",
        "cardExpire",       "expire",
        "credentialNumber", "idNo",
        "credentialName",   "name",
        "phoneNumber",      "mobile",
        "merAbstract",

        //tdb only
        "orderTimeoutDate",
        "origOrderNumber",
        "origOrderTime",
    );

    static $notify_param_check = array(
        "version",
        "charset",
        "transType",
        "respCode",
        "respMsg",
        "respTime",
        "merId",
        "merAbbr",
        "orderNumber",
        "traceNumber",
        "traceTime",
        "qid",
        "orderAmount",
        "orderCurrency",
        "settleAmount",
        "settleCurrency",
        "settleDate",
        "exchangeRate",
        "exchangeDate",
        "cupReserved",
        "signMethod",
        "signature",
    );

    static $sign_ignore_params = array(
        "bank",
    );
}

?>
