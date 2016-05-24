<?php

namespace Howtomakeaturn\Pay2goInvoice;

class Pay2goInvoice
{
    protected $liveEndpoint = 'https://inv.pay2go.com/API/invoice_issue';
    protected $testEndpoint = 'https://cinv.pay2go.com/API/invoice_issue';
    protected $testMode = false;

    protected $merchantId;

    protected $hashKey;
    protected $hashIv;

    public function setMerchantId($id)
    {
        $this->merchantId = $id;
    }

    public function setHashKey($hashKey)
    {
        $this->hashKey = $hashKey;
    }

    public function setHashIv($hashIv)
    {
        $this->hashIv = $hashIv;
    }

    public function send($params)
    {
        if ($params == null) {
            throw new Exception\GeneralException('Parameters are not set.');
        }

        $post_data = $this->encryptParams($params);

        $transaction_data_array = array(
            'MerchantID_' => $this->merchantId,
            'PostData_' => $post_data,
        );

        $transaction_data_str = http_build_query($transaction_data_array);

        $result = Helper::curl_work($this->getEndpoint(), $transaction_data_str);

        $response = json_decode($result['web_info'], true);

        if ($response['Status'] !== 'SUCCESS') {
            throw new Exception\GeneralException($response['Status'].': '.$response['Message']);
        }

        return $result;
    }

    private function encryptParams($params)
    {
        $post_data_str = http_build_query($params);

        $post_data = trim(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->hashKey, Helper::addpadding($post_data_str), MCRYPT_MODE_CBC, $this->hashIv))); //加密

        return $post_data;
    }

    public function setTestMode($bool)
    {
        $this->testMode = $bool;
    }

    protected function getEndpoint()
    {
        return $this->testMode ? $this->testEndpoint : $this->liveEndpoint;
    }
}
