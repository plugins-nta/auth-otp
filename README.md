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
