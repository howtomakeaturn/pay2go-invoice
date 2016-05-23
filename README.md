# 智付寶（pay2go）電子發票 wrapper

## 注意：目前只有實作「開立發票」API。「作廢發票」、「查詢發票」等等API，近期內尚無規劃實作。

Pay2goInvoice是一個用來呼叫智付寶電子發票API的library。

請參閱智付寶電子發票文件使用本library。

https://www.pay2go.com/info/site_description/api_description

# 安裝

您可以直接將檔案下載使用。或是使用composer安裝：
```
composer require "howtomakeaturn/pay2go-invoice:1.*"
```

# 使用範例


```php
//記得先手動、或是利用composer載入套件

$pay2go = new Howtomakeaturn\Pay2goInvoice\Pay2goInvoice();

$pay2go->setMerchantId('xxx'); //設定商店代號

$pay2go->setHashKey('xxx'); //設定hash key

$pay2go->setHashIv('xxx'); //設定hash iv

$pay2go->setTestMode(True); //測試環境請加上這行

//請參閱官方文件設定參數
//https://www.pay2go.com/info/site_description/api_description

$params = [
    "RespondType" => "JSON",
    "Version" => "1.3",
    "TimeStamp" => time(), //請以 time() 格式
    "TransNum" => "",
    "MerchantOrderNo" => "WC_TEST_" . rand(),
    "BuyerName" => "王大品",
    "BuyerUBN" => "99112233",
    "BuyerAddress" => "台北市南港區南港路一段 99 號",
    "BuyerEmail" => "abc@gmail.com",
    "BuyerPhone" => "0955221144",
    "Category" => "B2B",
    "TaxType" => "1",
    "TaxRate" => "5",
    "Amt" => "1000",
    "TaxAmt" => "50",
    "TotalAmt" => "1050",
    "CarrierType" => "",
    "CarrierNum" => rawurlencode(""),
    "LoveCode" => "",
    "PrintFlag" => "Y",
    "ItemName" => "Translation Service", //多項商品時,以「|」分開
    "ItemCount" => "1", //多項商品時,以「|」分開
    "ItemUnit" => "-", //多項商品時,以「|」分開
    "ItemPrice" => "1000", //多項商品時,以「|」分開
    "ItemAmt" => "1000", //多項商品時,以「|」分開
    "Comment" => "TEST,備註說明",
    "Status" => "1", //1=立即開立,0=待開立,3=延遲開立
    "CreateStatusTime" => "",
    "NotifyEmail" => "1", //1=通知,0=不通知
];

$result = $pay2go->send($params);
```

# Exceptions
目前只會針對智付寶回傳的錯誤訊息，丟出一種通用例外。

* Howtomakeaturn\Pay2goInvoice\Exception\GeneralException
