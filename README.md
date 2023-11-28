# invoicing.plus-plugin

# Librairie PHP pour interfacer le logiciel de facturation Invoicing.plus

## Installation
```
composer require admin-plus/invoicing.plus-plugin:dev-master
```

## Usage

```php

<?php

use AdminPlus\InvoicingPlusPlugin\InvoicingPlus;

// création de l'objet
$invoicing = new InvoicingPlus();

// test du service
$check = $invoicing->check();
if ($check->successful()) {
    // service API OK, affichage de la data descriptive
    var_dump($check->data());

    // je n'ai pas encore de token
    // j'en obtiens un avec mon email et mon mot de passe (j'ai bien sur une société de créée sur Invoicing.plus)
    // sinon j'en crée une ici https://invoicing.plus/trial?a=5
    $token = $invoicing->newToken('de**@**us.fr', 'xxxxxx');    
    if ($token->successful()) {
        var_dump($token->data());
    } else {
        var_dump($token->error());
    }

    // ou alors je connais déjà mon token, je le récupère depuis un fichier d'environnement, on travaille bien hein !
    $mytoken = env('invoicing.token')
    // et je l'affecte à mon objet
    $invoicing->setToken($mytoken);

    // je requête mes sociétés auxquelles j'ai accès
    $companies = $invoicing->companies();
    if ($companies->successful()) {
        // affichage de la liste des sociétés
        var_dump($companies->data());
        $data = $companies->data();
        if (count($data) > 0){
            // je veux travailler sur la première, je l'affecte à mon objet
            $invoicing->setCompany($data[0]->id);

            // je requête les clients de cette société
            $customers = $invoicing->customers();
            if ($customers->successful()) {
                // affichage de la liste des clients
                var_dump($customers->data());
            } else {
                var_dump($token->error());
            }
        }
    } else {
        var_dump($token->error());
    }

    // je veux faire autre chose, créer des clients, des produits, des factures
    // je consulte la doc https://api.invoicing.plus
    // je demande des infos à Jean-Didier (joignable par tous les moyens 😁) le développeur https://invoicing.plus/contact 

} else {
    var_dump($check->error());
}



```
