# notification

line  sms notification package

---

## Installation

- step1: composer require ichen/notification
- step2: php artisan vender:publish // Nexmo\laravel\NexmoServiceProvider && Ichen\Notification\NotificationServiceProvider

---
## Configure

- 於.env新增相關設定

        #mail服務設定
        MAIL_MAILER=smtp
        MAIL_HOST=smtp.gmail.com or other host
        MAIL_PORT=587
        MAIL_USERNAME=your mail account
        MAIL_PASSWORD=your mail password
        MAIL_ENCRYPTION=tls or other type
        MAIL_FROM_ADDRESS=email address
        MAIL_FROM_NAME="${APP_NAME}"

        YOUR_EMAIL_NAME=email nickname ex:Ben

        #nexmo服務認證
        NEXMO_KEY= 
        NEXMO_SECRET=
 
        #簡訊發送位置
        NEXMO_USERNAME= 
        
        #line bot 編號
        LINE_BEARER=
---
## Usage

### **mail通知**

    mailNotification(array $mailTo, $subject, $message, array $filePath = [], array $ccTo = [])

#### Params

|   參數    | 必填  | 型態   | 說明         | 示例值                                          |
| :-------: | :---: | ------ | ------------ | ----------------------------------------------- |
|  $mailTo  |   Y   | String | 傳mail       | 'mailTo@gmail.com'                              |
| $subject  |   Y   | String | 標題         | 'XX資訊'                                        |
| $message  |   Y   | String | 傳送訊息     | '這是一則訊息'                                  |
| $filePath |       | array  | 傳送檔案位置 | ['C:\myproject\cat.png', 'C\myproject\dog.png'] |
|   $ccTo   |       | array  | 副件         | ['xxx@email.com', 'bbb@email.com']              |

---

### **line通知**

    lineNotification($message)

#### Params

|   參數   | 必填  | 型態   | 說明     | 示例值         |
| :------: | :---: | ------ | -------- | -------------- |
| $message |   Y   | String | 傳送訊息 | '這是一則訊息' |

---

### **sms通知**

    smsNotification($phoneNumber, $message)

#### Params

|     參數     | 必填  | 型態   | 說明     | 示例值         |
| :----------: | :---: | ------ | -------- | -------------- |
| $phoneNumber |   Y   | String | 電話號碼 | '0988654876'   |
|   $message   |   Y   | String | 傳送訊息 | '這是一則訊息' |
