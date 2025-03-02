<?php

function generate_data_rights($order) {
    $name = $order->get_billing_first_name();
    $surname = $order->get_billing_last_name();
    $customer_email = $order->get_billing_email();
    $shop_name = "templateshop.com";
    $support_email = "support@templateshop.com";

    $text =
    "Táto elektronická kniha bola zakúpená v internetovom kníhkupectve "
    . "$shop_name .\n\n"
    . "Meno a priezvisko kupujúceho: $name $surname \n"
    . "E-mail: $customer_email \n\n"

    . "Upozorňujeme, že elektronická kniha je dielom chráneným podľa autorského "
    . "zákona a je určená len pre osobnú potrebu kupujúceho. Kniha ako celok "
    . "ani žiadna jej časť nesmie byť voľne šírená na internete, ani inak ďalej "
    . "zverejňovaná. V prípade ďalšieho šírenia neoprávnene zasiahnete do "
    . "autorského práva s dôsledkami podľa platného autorského zákona a trestného "
    . "zákonníku. Automatizovaná analýza textu alebo údajov v zmysle čl. 4 "
    . "smernice 2019/790/EU a použitie tejto knihy k trénovaniu AI sú bez súhlasu "
    . "majiteľa práv zakázané. \n\n"
    . "Ak máte akékoľvek otázky ohľadom použitia e-knihy, neváhajte nás prosím "
    . "kontaktovať na adrese \n"
    . "$support_email .";

    return $text;
}