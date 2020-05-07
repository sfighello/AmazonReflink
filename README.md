# AmazonReflink
Benvenuti nella versione beta di AmazonReflinkBot. Il mio compito è quello di shortare e reffare tutti i link amazon!
> N.B Questa versione shorta tutti i link amazon in un messaggio!
Adesso il bot referra anche i link modificati su telegram e quelli sotto le immagini.
## Requisiti
Hosting web o vps. Il bot è leggero e veloce :)
Consigliato php 7.4
> Se può interessarvi uscirà una versione per hostare il bot su Termux o su un normale PC con Linux
## Installazione
Copiare o scaricare i file `index.php`, `functions.php`, `settings.php`. Modificate solo il file `settings.php` inserendo il vostro tag amazon, l'api token del vostro bot e il vostro <a href="https://bitly.is/2Wc4hDs">token Bitly</a>. Se volete modificate anche i parametri true o false. Per settare il webhook scrivete nella barra di ricerca del vostro browser questo link:
```
https://api.telegram.org/bot{TOKEN}/setWebhook?url=https://{SITO}/cartella/index.php
```
Ovviamente cambiate `{TOKEN}` e `{SITO}` con il token del bot e il vostro sito.

---
## Iniziamo!
Ora che il bot è pronto non ti resta altro che aggiungerlo al tuo gruppo o usarlo in privato!
> Attenzione: ricordati di mettere il tuo bot admin in modo da poter eliminare i messaggi!!
## Rendere privato il bot
Se vuoi utilizzare il tuo bot solo nel tui gruppi e/o in privato puoi farlo modificanto l'array `$chats` in `settings.php`. Inserisci i chatID dei tuoi gruppi e togli le due `//` all'inizio della riga 4. Adesso il tuo bot funzionerà solo nelle chat specificate da te :)
```php
$chats = [12345678, -10012345678, 87654321];
//////
$chats = [-100123456];
```
## Coming Soon
Questa è solo una versione beta del bot, usciranno altre release

Se vuoi contribuire al progetto sei libero di farlo rispettando la licenza!

**Se il bot ti è piaciuto lasciami una star e un follow :)**
