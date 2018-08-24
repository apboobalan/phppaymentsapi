# PHP Payments API
Create simple payments api using lumen, mysql.

### Starting the app
#### Using docker(_running in apache docker_)
1. App is started using start.sh script.
2. API can be accessed via localhost 8080 port.
3. API tests are run using _npm test_ command inside apiTests folder.
4. App is stopped using stop.sh script.

#### Using host machine(_running in php built in server_)
1. Start sql container using _docker-compose up -f docker-compose-sql.yml_ .
2. Create tables using _php artisan migrate_.
3. Start server using _php -S localhost:8080 -t public_.

### Scenarios
* Adding payments.
  * Adding payment with same id throws 409 data conflict error.
  * Adding payment with invalid parameters throw 400 error.
* Adding charges.
  * Adding charges with same id throws 409 data conflict error.
  * Adding charges for unknown payment id throws 404 error.
  * Adding charges with invalid parameters throw 400 error.
* Getting all charges.
  * Return empty array initially.
* Getting charge by id.
  * Return 404 if id is not found.

### Notes
* Validators are used to check inputs.
* PHP unit tests are written for payments objects.
* For api testing icedfrisby is used.(_API test runs the above mentioned scenarios_)
* Two Payment types(_Debit,Credit_) exists separately and each implements create(_stored in two different tables for normalization_), delete, and charge methods from the PaymentInterface.