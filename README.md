# CloudFront API Tester
This is intended to be a simple tool used to test CloudFront API calls. It is built upon [Robo](https://robo.li).

# Requirements
- Composer
- For easier execution, install Robo globally through Composer, or via robo.phar. [Instructions here.](https://robo.li/)

# Setup
- `composer install`
- `robo cf:setup`
- Configure the `config.yml` with the needed AWS information.

# Configuration
The `config.yml` file contains the needed AWS information to make certain calls. Make sure it's filled out so that the calls are successful.

# Commands
```
cf:list - List all CloudFront distributions.
```