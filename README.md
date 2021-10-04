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



	
	
