# Flip Disbursement Service

### Installation
- Make sure you have PHP 7.x installed with PDO MySQL extension enabled
- MySQL server
- Clone this repository `$ git clone https://github.com/agoes/flip-disbursement.git`

#### Database & API Configurationn
Check at these config files :
- config/database.php
- config/apis.php

You can use env for set the config value or change it directly in the config file.

#### Database migrations & seeds
- Make sure you created the database
- Run `$ php migrations.php` and then `$ php seeds.php`

#### Disbursement
- Run `$ php disburse.php`