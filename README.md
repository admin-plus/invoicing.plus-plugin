# invoicing.plus-plugin

# Installation
```
composer require admin-plus/invoicing.plus-plugin:dev-master
```

# Usage

```php

<?php

use AdminPlus\InvoicingPlusPlugin\InvoicingPlus;

// création de l'objet
$invoicing = new InvoicingPlus();

// test du service
$check = $invoicing->check();
if ($check->successful()) {
    // service API ok, affichage de la data descriptive
    var_dump($check->data());

    // je n'ai pas encore de token, j'en obtient un avec mon email et mon mot de passe (J'ai bien sur une société de créée sur Invoicing.plus, sinon j'en crée une https://invoicing.plus/trial?a=5)
    $token = $invoicing->newToken('de**@**us.fr', 'xxxxxx');    
    if ($token->successful()) {
        var_dump($token->data());
    } else {
        var_dump($token->error());
    }

    // je connais mon token, je le récupère depuis un fichier d'environnement, on travaille bien hein !
    $mytoken = env('invoicingplus.token')
    $invoicing->setCompany($mytoken);
    
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




} else {
    var_dump($check->error());
}



```
