## Laravel Socialite in Action!

### Sample, educational TaskManager App 

- based on Laravel 5.1 
- using the built-in local authorization
- full implementation of the Laravel Socialite authorization

Configured to be used with Github, Facebook, Google, Twitter and LinkedIn aus OAuth providres.

As Twitter does not return the user's email address by default (only after you ask them to whitelist your app), a fake email address is being created by using the users's Twitter nickname and 'twitter.com', e.g. 'blahdibla@twitter.com'.

#### Installation

After cloning, simply rename the example.env to .env and enter all your provider's details!

#### Login Screen

![screenshot](https://github.com/matthiku/LaravelWithSocialite/blob/master/screenshot.png)
