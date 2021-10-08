# arlight
AdRotator Light (kurz: "Arlight") ist ein kostenloser AdServer in PHP. Hiermit ist es möglich, spielend einfach unterschiedliche Werbebanner (z.B. Google AdSense, Affilinet, etc.) auf jeder Homepage in einen frei definierbaren Bereich zu platzieren, die abwechselnd beim Seitenaufruf angezeigt werden. Im passwortgeschützten Administrationsbereich können alle Banner mitsamt ihrer Einblendungen ("Views"), Klicks und der Klickrate einfach und übersichtlich überblickt und verwaltet werden. Durch eine eingebaute "Reloadsperre" wird nur sauber generierter Traffic gezählt. Die Banner lassen sich per Iframe-Bannercode, Image oder PHP-Include in jede Webseite bzw. CMS einbinden.

Dies ist eine komplette Neuentwicklung der AdRotator Technologie und kommt, anders als bei der Classic Variante, mit einer SQLite-Datenbank aus. Genau richtig, wenn Sie nicht viele Datenbank-Resourcen zur Verfügung haben oder einfach auf eine sparsame und leicht portable Anwendung setzen möchten. Bei höheren Ansprüchen kann optional auch eine MySQL-Datenbank verwendet werden. Lesen Sie bei Fragen die beiliegende readme-Datei oder besuchen Sie das Support-Forum.

Features:
* Geschützter Administrationsbereich mit Benutzer- und Passworteingabe.
* Werbebanner können in unterschiedlichen Formaten (z.B. 468x60) gespeichert und administriert werden.
* Die Banner können auf jeder Webseite je nach Bedarf durch drei verschiedene Bannercodes eingebunden werden.
* Es wird keine externe Datenbank benötigt, wodurch nun auch kleine Webseiten ohne Datenbank Server oder mit wenigen Ressourcen Ihre Werbeflächen verwalten können.
* Die SQLite Datenbank ist einfach, portabel und kann leicht gesichert werden.
* Einfache Integration in bestehende Webseiten oder CMS/Template Systeme.

Systemanforderung:
PHP Version: 5.3.3 bis 7.3.x
Datenbank: SQLite 3.6+ oder MySQL 5.0+
