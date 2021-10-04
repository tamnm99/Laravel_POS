                                                        FUNCTION OF PROJECT: 
- Login with Google recaptcha
- Register, Forgot password, Reset password: Google recaptcha, send email.
- Update profile user, Change password, Delete user, View user, Assgin role & permissions for user.
- CRUD: Customer Groups, Tax rates, bands, Units, Categories, Deliveries Fee for Viet Nam, Quotations.
- Products: Crud, Print barcode, Import by file .csv, Validate exp & mfg of product.
- Sales: Crud with multiple row, Validate ajax, Return Sale, Print pdf detail Sale Invoice.
- Purchases: Crud with multiple row, Validate ajax, Import by file .csv, Print pdf detail.
- POS: UI POS, Curd POS Invoice, Print pdf detail.
- Other: Laravel Yajra Datatable, Export table contents to CSV, PDF or Print (chosen columns), Sweet Alert 2, Toastr.


                                                          INSTALL, SETUP, CONFIG, RUN 
- Step 1 - Clone project: https://github.com/tamnm99/Laravel_POS.git
- Step 2 - Set vhost for using google recaptcha, vhost for this project must be: pos_team3.example.com
  + 2.1, in C:\xampp\apache\conf\extra\httpd-vhosts.conf, config like example below
    <VirtualHost *:80>
    ServerAdmin tamnm1999@gmail.com
    DocumentRoot "C:\xampp\htdocs\team3\public"
    ServerName pos_team3.example.com
    ErrorLog "logs/pos_team3.example.com-error.log"
    CustomLog "logs/pos_team3.example.com.log" common
    <Directory C:\xampp\htdocs\team3\public>
    Options -Indexes +FollowSymLinks +MultiViews
    AllowOverride All
    Require all granted
    </Directory>
    </VirtualHost>
  + 2.2, in C:\Windows\System32\drivers\etc\hosts, config like example: 127.0.0.1 pos_team3.example.com
- Step 3 - Install composer: composer install.
- Step 4 - create file .env, copy paste content in .env.example to file .env : cp .env.example .env.
- Step 5 - Create new Database. Chang information about DB_DATABASE, DB_USERNAME, DB_PASSWORD, MAIL_USERNAME, MAIL_FROM_ADDRESS in file .env for your's develope enviroment.
- Step 6 - Import data to DB: php artisan migrate--> php artisan vietnam-map:download --> php artisan db:seed.
- Step 7 - Mix css, js: npm run production.
- Step 8 - Link file storage: php artisan storage:link.
- Step 9 - Now, login system withusername: admin@sample.com, password: admin-password.

                                                        IMAGE DEMO OF PROJECT
![image](https://user-images.githubusercontent.com/63133151/135856587-cd8a6e4d-917b-4882-b8f9-93944884918e.png)
![image](https://user-images.githubusercontent.com/63133151/135856606-e02f5fa8-be18-4b7a-98a1-137d51762cce.png)
![image](https://user-images.githubusercontent.com/63133151/135856625-2c799528-d290-4997-8ed3-2a791b09565c.png)
![image](https://user-images.githubusercontent.com/63133151/135856637-951a2c98-0772-4344-82fa-baf729e5450b.png)




	
	
