# 暑期實驗室甄選會模擬網站

## 專案介紹

本專案為「暑期實驗室甄選會模擬網站」，提供考生及管理員使用的網頁系統，協助模擬實驗室甄選相關流程。

本網站使用 **CodeIgniter 4** PHP Framework 開發，並使用 **SQLite3** 作為資料庫。

### 前台功能

* 考生註冊
* 考生登入
* 忘記密碼
* 公告資訊瀏覽
* 公告附件下載
* 校系分則查詢
* 網路報名系統瀏覽
* 甄選相關資訊瀏覽

### 後台功能

* 管理員登入
* 管理員帳號資料管理
* 管理員權限與狀態管理
* 管理員操作紀錄
* 公告新增、編輯及刪除
* 公告附件管理
* 首頁功能頁面開啟／關閉管理
* 首頁跑馬燈管理
* 考生個人資料查詢
* 考生報名資料查詢

---

# 開發環境

本專案主要使用以下技術：

* PHP 8.3
* CodeIgniter 4
* SQLite3
* Composer
* PhpSpreadsheet
* HTML
* CSS
* JavaScript
* Git / GitHub

---

# 專案環境需求

開始使用本專案前，請確認本機已安裝：

* PHP
* Composer
* Git

另外，PHP 必須啟用專案所需的相關 Extension，包括：

* `intl`
* `mbstring`
* `sqlite3`
* `zip`

可使用以下指令確認 PHP 版本：
```bash
php -v
```

確認 Composer：
```bash
composer -V
```

確認 `zip` Extension：
```bash
php -m | findstr zip
```

如果指令執行後有出現：
```bash
zip
```
代表 PHP 已啟用 `zip` Extension。

---

# 專案安裝

## 1. Clone GitHub 專案

使用 Git 將專案複製至本機：

```bash
git clone https://github.com/yunnn41399/apply116.git
```

進入專案目錄：

```bash
cd apply116
```

---

## 2. 安裝 Composer 套件

在專案根目錄執行：

```bash
composer install
```

此指令會依照 `composer.json` 及 `composer.lock` 安裝專案所需的 PHP 套件。

---

# 環境設定

## 1. 建立 `.env`

專案根目錄提供 `env` 作為環境設定範本。

Clone 專案後，請將：

```text
env
```

複製成：

```text
.env
```

Windows 可以執行：

```bash
copy env .env
```

`.env` 為本機環境設定檔，不會提交至 GitHub。

---

## 2. 設定網站網址

開啟 `.env`，確認：

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'
```

若網站使用其他網址或 Port，請依照本機環境修改 `app.baseURL`。

---

## 3. 設定資料庫

本專案使用 **SQLite3**。

資料庫檔案名稱為：

```text
apply116.sqlite
```

資料庫會存放於：

```text
writable/apply116.sqlite
```

資料庫路徑已於 `app/Config/Database.php` 中使用 `WRITEPATH` 設定，因此不需要將本機專案的完整路徑寫入 `.env`。

例如：

```text
C:\...\apply116\writable\apply116.sqlite
```

不需要寫入 GitHub 或 `.env`。

---

# 建立資料庫

Clone 專案後，由於 `writable/apply116.sqlite` 不會提交至 GitHub，因此第一次在新的電腦使用專案時，需要重新建立資料庫。

專案包含 Migration，請執行：

```bash
php spark migrate
```

可以使用以下指令確認 Migration 狀態：

```bash
php spark migrate:status
```

---

# 初始資料設定

本專案部分功能需要透過 Seeder 建立初始資料。

第一次建立本機環境時，依需求執行以下 Seeder。

## 建立預設管理員

先在 `.env` 設定：

```ini
ADMIN_DEFAULT_USERNAME = <請填入預設最高管理員帳號>
ADMIN_DEFAULT_PASSWORD = <請填入預設最高管理員密碼>
ADMIN_DEFAULT_EMAIL = "<請填入預設最高管理員電子信箱>"
```

執行：

```bash
php spark db:seed AdminSeeder
```

---

## 建立首頁跑馬燈資料

首頁跑馬燈功能使用 `HomepageMarqueeSeeder` 建立初始資料：

```bash
php spark db:seed HomepageMarqueeSeeder
```

---

## 建立首頁頁面資料

首頁頁面開啟／關閉管理功能使用 `HomepagePageSeeder` 建立初始資料：

```bash
php spark db:seed HomepagePageSeeder
```

---

# 校系資料設定

校系查詢功能使用 **PhpSpreadsheet** 讀取 Excel 校系資料。

## 1. 啟用 PHP `zip` Extension

請找到本機 PHP 安裝目錄中的：

```text
php.ini
```

找到：

```ini
;extension=zip
```

將前面的 `;` 移除：

```ini
extension=zip
```

儲存 `php.ini` 後重新啟動 PHP／CodeIgniter 開發伺服器。

可在專案根目錄開啟 CMD，執行：

```bash
php -m | findstr zip
```

如果出現：

```text
zip
```

代表 `zip` Extension 已啟用。

---

## 2. 匯入校系資料

執行：

```bash
php spark import:departments
```

如果出現類似：

```text
成功匯入 2206 筆資料
```

代表校系資料已成功匯入。

（也可以進入 SQLite 資料庫確認 `departments` 資料表中是否已有校系資料。）

完成後重新啟動開發伺服器：

```bash
php spark serve
```

再進入首頁的校系分則查詢頁面，並使用查詢功能確認是否正常。

---

# 公告附件上傳設定

公告系統允許管理員上傳附件，為避免附件檔案容量過大導致無法上傳，需要修改 PHP 的 `php.ini` 設定。

找到個人電腦中的：

```text
php.ini
```

修改：

```ini
upload_max_filesize = 10M
post_max_size = 12M
```

其中：

* `upload_max_filesize = 10M`：單一上傳檔案大小上限為 10 MB
* `post_max_size = 12M`：單次 POST 請求資料大小上限為 12 MB

修改並儲存完成後，請重新啟動 PHP／CodeIgniter 開發伺服器，使設定生效。

> 若使用 Apache、XAMPP 或其他 PHP Server，請依實際使用的 PHP 環境重新啟動對應服務。

---

# 忘記密碼功能設定

本專案的後臺管理員忘記密碼功能使用 Gmail SMTP 寄送密碼重設信件。

請在 `.env` 設定：

```ini
email.fromName = "Apply116 後臺管理"

email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPUser = "<請填入負責寄送重設密碼信件的 Gmail 信箱>"
email.SMTPPass = "<請填入該 Gmail 帳號的 Google App Password>"
email.SMTPPort = 587
email.SMTPCrypto = tls
```

其中：

* `email.SMTPUser`：負責寄送後臺管理員忘記密碼信件的 Gmail 帳號
* `email.SMTPPass`：該 Gmail 帳號的 Google App Password
* `email.SMTPPort`：SMTP 使用的 Port
* `email.SMTPCrypto`：SMTP 加密方式

**請勿將實際 Gmail 密碼或 Google App Password 上傳至 GitHub。**

> **Google App Password 取得方式：**
> 1. 登入負責寄送後臺管理員忘記密碼信件的 Gmail 帳號。
> 2. 進入該 Google 帳戶的「安全性」。
> 3. 確認該帳號已開啟 兩步驟驗證。
> 4. 找「[應用程式密碼](https://myaccount.google.com/apppasswords)」。  
> 5. 建立一組新的應用程式密碼，例如名稱可以填：Apply116。
> 6. Google 會產生一組 16 位元的應用程式密碼。
> 7. 複製 16 位元的應用程式密碼後，刪除中間的空格，貼到 `email.SMTPPass = ` 的後方。
---

# 啟動網站

完成上述環境設定後，在專案根目錄執行：

```bash
php spark serve
```

成功啟動後，開啟：

```text
http://localhost:8080
```

即可進入網站。

---

# 第一次建立本機環境

第一次 Clone 專案時，可以依照以下順序進行：

```bash
git clone https://github.com/yunnn41399/apply116.git
cd apply116

composer install

copy env .env

php spark migrate

php spark db:seed AdminSeeder
php spark db:seed HomepageMarqueeSeeder
php spark db:seed HomepagePageSeeder

php spark import:departments

php spark serve
```

另外需要確認：

1. `.env` 已依照本機環境設定。
2. PHP `zip` Extension 已啟用。
3. `php.ini` 已設定：

   ```ini
   upload_max_filesize = 10M
   post_max_size = 12M
   ```
4. `departments` 資料表已成功匯入校系資料。

---

# 專案目錄結構

主要目錄結構如下：

```text
apply116/
│
├── app/
│   ├── Config/
│   ├── Controllers/
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeds/
│   ├── Models/
│   ├── Services/
│   └── Views/
│
├── public/
│   ├── CSS/
│   ├── JS/
│   └── uploads/
│
├── system/
│
├── writable/
│   ├── cache/
│   ├── logs/
│   ├── session/
│   └── uploads/
│
├── tests/
│
├── env
├── .gitignore
├── composer.json
├── composer.lock
├── spark
└── README.md
```

### 主要目錄說明

| 目錄                         | 說明                 |
| -------------------------- | ------------------ |
| `app/Config/`              | 網站及 CodeIgniter 設定 |
| `app/Controllers/`         | 處理使用者請求及網站功能流程     |
| `app/Database/Migrations/` | 資料庫 Migration      |
| `app/Database/Seeds/`      | 建立初始資料的 Seeder     |
| `app/Models/`              | 資料庫操作及資料模型         |
| `app/Services/`            | 系統功能服務及共用邏輯        |
| `app/Views/`               | 網頁畫面               |
| `public/`                  | 網站公開資源             |
| `system/`                  | CodeIgniter 4 核心系統 |
| `writable/`                | 系統執行時產生及寫入的資料      |
| `tests/`                   | 測試相關檔案             |

---

# 注意事項

1. 第一次 Clone 專案後，需要自行建立 `.env`。
2. 本專案使用 SQLite3，資料庫檔案位於 `writable/apply116.sqlite`。
3. 第一次建立本機環境時，需要執行 Migration。
4. 第一次建立本機環境時，需要依需求執行各 Seeder。
5. 校系查詢功能需要啟用 PHP `zip` Extension。
6. 使用公告附件上傳功能前，需要將 `php.ini` 的 `upload_max_filesize` 設定為 `10M`，並將 `post_max_size` 設定為 `12M`。
7. 使用忘記密碼功能前，需要正確設定 Gmail SMTP 及 Google App Password。
8. Clone 專案後，請執行 `composer install` 即可建立 `vendor/`。

---

# 相關文件

本專案使用 CodeIgniter 4 作為 PHP Web Framework。

- [CodeIgniter 4 官方文件](https://codeigniter.com/user_guide/)

---

# 專案成員

| 姓名 | 主要負責內容 |
|---|---|
| 鄧雅云 | 首頁（公告以外的部分）、考生登入系統 |
| 簡映瑜 | 首頁（僅公告部分）、考生註冊系統、後臺管理系統 |

本專案由以上成員共同開發。