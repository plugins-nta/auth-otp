# Laravel OTP AUTH
This package allows you to authenticate with one time password access (OTP). <br>
Example Usage:
```php
Route::get("/notify", function(){
    return App\Models\User::find(1)->notify(new \App\Notifications\Otp());
});

Route::get("/auth-otp/{otp}", function(){
    return App\Models\User::find(1)->checkOtp(request()->otp);
});
```
# Contents
- [Installation](#installation)
- [Run command](#run-command)
- [Configs](#configs)
- [Usage](#usage)
    - [Generate OTP](#generate-otp)
    - [Verify OTP](#verify-otp)
- [Special Thanks](#special-thanks)    
## Installation
1. Add packages to your project <br>
   Add the following code to composer
   ```php
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/plugins-nta/auth-otp.git",
            "no-api": true
        }
    ]
   ```
   ```php
    "require": {
        "nta/otp-auth": "dev-master"
    }
   ```
2. Run the command
   ```
   composer update
   ```
## Run command
```php
php artisan nta:otp {ClassName}
```
Example:
```php
php artisan nta:otp Otp
```
_`Otp` class is auto-generate at `app/Notifications` directory._ <br>
_`HasOtpAuth` trait is auto-generate at `app/Traits` directory._ <br>
_`CreateNotificationsTable` class is auto-generate at `app/databases/migrations` directory (If `CreateNotificationsTable` was created before, it will not be created and will use the existing one)._<br>

Apply migrations:<br>
_It will create a table called `notifications` to store generated OTP information._
```php
php artisan migrate
```
Please ignore the above command if table notifications have been created before.
## Configs
1. publish configs <br>
    Once done, publish the config to your config folder using:
    ```php
    php artisan vendor:publish --tag=otp-config
    ```
    This command will create a `config/otp.php` file.
2. Email configs <br>
   The default configuration will perform OTP authentication via mail. <br>
   So from the `.env` file the email configs are setup. No other changes required.
3. SMS configs <br>
   Please change the `app/config.php` file to perform authentication with SMS
   ```php
   'channels' => 'SMS',
   ```
   OTP authentication with SMS is supported with the following channels: `twilio`, `nexmo`.<br>
   You can change the SMS sending channel at `app/config.php`:
   ```php
   'sms_driver' => 'twilio',
   ```
4. Configuration `.env` to send OTP via SMS <br>
    Via twilio:
    ```php
    TWILIO_ACCOUNT_SID=
    TWILIO_AUTH_TOKEN=
    TWILIO_SMS_FROM=
   ```
   Via nexmo:
    ```php
    NEXMO_KEY=
    NEXMO_SECRET=
    NEXMO_SMS_FROM=
   ```
## Usage
### Generate OTP
You can generate OTP via email or SMS
```php
Route::get("/notify", function(){
    return App\Models\User::find(1)->notify(new \App\Notifications\Otp());
});
```
This package allows you to alter channels, OTP length and lifetime
```php
Route::get("/notify", function(){
    $channel = 'SMS';
    $length = 4;
    $liftime = 10; //minutes
    return App\Models\User::find(1)->notify(new App\Notifications\Otp($channel, $length, $liftime));
});
```
Or change in `app/config.php`
```php
'channels' => 'mail',
'lifeTime' => 3,
'length' => 6,
```
**OTP default length**: The default length is `6`. <br>
**OTP default lifetime**: The default lifetime is `3` minute.
### Verify OTP
After sent OTP via your configed methods, you call `checkOtp` to authenticate. <br>

```php
Route::get("/auth-otp/{otp}", function(){
    return App\Models\User::find(1)->checkOtp(request()->otp);
});
```
In this case, you can apply User model which must use `HasOtpAuth` trait
```php
...

use App\Traits\HasOtpAuth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasOtpAuth;
...
```
## Special Thanks
- Lê Nghĩa
- nghial.nta@gmail.com
