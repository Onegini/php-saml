# Onegini inline login

This demo shows how to use Inline login to authenticate with Onegini CIM.
Additionally this demo contains a second login option which authenticates through an external IDP.

## Setup

Make sure you have the following components installed:
- php (Obviously)
- php mcrypt extension (available in `homebrew/php` if you're on macOS)
- composer (`brew install composer` if you're on macOS)

Install project dependencies:
```bash
composer install
```

## Running

The easiest way to run this demo is to execute:
```bash
php -S 127.0.0.1:8080 # From the `demo-inline-login` directory.
```
