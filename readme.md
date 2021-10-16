## 專案說明
這是一個提供匯率轉換 API 的 Laravel 專案，目前只支援台幣 (TWD)、日圓 (JPY)、美金 (USD) 的匯率轉換。

## 執行方法
clone 此專案
```console
$ git clone [repository URL]
```

用 composer 安裝
```
$ composer insatll
```

複製一份 .env 檔
```
$ cp .env.example .env
```

產生 APP_KEY
```
$ php artisan key:generate
```

執行本地專案
```
$ php artisan serve --port=[your available port]
```

## 測試
假設網址是 `http://localhost:8080`

- 基本頁面測試：
瀏覽器開啟 `http://localhost:8080` 後可看到 Laravel 5 文字

- 匯率轉換 API 測試：
用 Postman 執行 API --- **GET** `http://localhost:8080/api/currency`
    - 範例輸入
        ```json
        {
            "src_currency_type": "TWD",
            "dst_currency_type": "JPY",
            "amount": 5340
        }
        ```
    - 範例輸出
        ```json
        {
            "status": "success",
            "code": "200",
            "data": {
                "dst_amount": "19,592.46"
            }
        }
        ```

