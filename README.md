# SmartMeal

Aplikácia, ktorá slúži na správu receptov (tvorenie, prezeranie, upravovanie, mazanie).
Ponúka tvorbu jedálneho plánu z receptov na každý deň, ktoré sa na stránke nachádzajú.
Z vytvoreného jedálneho plánu sa automaticky generuje nákupný zoznam surovín z jedál, ktoré sa v ňom nachádzajú.

## Použité technológie

- Framework Vaííčko
- PHP (MVC architektúra)
- MySQL / MariaDB
- JavaScript (AJAX)
- HTML, CSS (Bootstrap)
- Docker

## Docker configuration

Projekt obsahuje Docker konfiguráciu v adresári docker.

Po spustení sa vytvoria tieto služby:
- Apache web server s PHP minimálnou verziou 8
- MariaDB databázový server
- Adminer pre správu databázy

## Návod na inštaláciu

1. Naklonovať repozitár do priečinka cez command line -> git clone <URL_REPOZITÁRA>
2. Otvoriť naklonovaný repozitár v PHP Storme
3. Spustiť aplikáciu Docker Desktop
4. V projekte kliknúť na docker directory a spustiť súbor docker-compose.yml
5. V aplikácii Docker Desktop kliknúť na port 80:80
6. Vitajte na webe