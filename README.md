# invoicing.plus-plugin

# Installation
```
composer require admin-plus/invoicing.plus-plugin:dev-master
```

# Usage

```php

<?php

use AdminPlus\InvoicingPlusPlugin\InvoicingPlus;

$invoicing = new InvoicingPlus();

$check = $invoicing->check();

if ($check->successful()) {
    var_dump($check->data());
} else {
    var_dump($check->error());
}

$token = $invoicing->newToken('demo@adminplus.fr', 'BtJ7hvCLx8yyvN4');

if ($token->successful()) {
    var_dump($token->data());
} else {
    var_dump($token->error());
}

$companies = $invoicing->companies();

if ($companies->successful()) {
    var_dump($companies->data());
    $data = $companies->data();
    if (count($data) > 0){
        $invoicing->setCompany($data[0]->id);
        $customers = $invoicing->customers();
        if ($customers->successful()) {
            var_dump($customers->data());
        } else {
            var_dump($token->error());
        }
    }
} else {
    var_dump($token->error());
}

```
