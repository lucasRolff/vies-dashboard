## Requirements

- A working [puppeteer](https://github.com/GoogleChrome/puppeteer) setup (`apt install libpangocairo-1.0-0 libx11-xcb1 libxcomposite1 libxcursor1 libxdamage1 libxi6 libxtst6 libnss3 libcups2 libxss1 libxrandr2 libgconf2-4 libasound2 libatk1.0-0 libgtk-3-0` would be a good start before pulling in puppeteer).
- PHP 7.2 should be fine
- MySQL/MariaDB

## Installation

1: Clone repo
2: composer install
3: mv `.env.example .env`
4: Fill out the .env settings:
- `NODE_BINARY_PATH` is the path to your node binary
- `NPM_BINARY_PATH` is the path to your npm binary
- `VIES_ACCESS_TOKEN` should be a set of random characters
- `VIES_REQUESTER_CC` should be the two letter country code of your country
- `VIES_REQUESTER_NUMBER` should be your VAT number (without country code)

5: Run database migrations: `php artisan migrate`

To add VAT numbers you can do the call:

```
/add?vat_number=$client_vat_with_country_code&client_id=$client_id&invoice_id=$invoice_id&token=$token
```

The above call will contact VIES database using their SOAP API as well as using browsershot to make another call to screenshot the VIES page and save the info to the database.
