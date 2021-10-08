BEGIN TRANSACTION;
/* SPLIT */
CREATE TABLE [language] (
[id] INTEGER  PRIMARY KEY NOT NULL,
[de] TEXT  UNIQUE NOT NULL,
[en] TEXT  NULL
);
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Menü','Menu');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannerübersicht','Banner overview');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Banner eintragen','Add banner');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannercode','Bannercode');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Update','Update');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Abmelden','Logout');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Erweitern Sie Ihre Kategorien um ein weiteres Format.','Add a new format to your existing categories.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Format eintragen','Add format');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Format-Name','Format-name');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Breite','Width');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('in Pixel','in pixels');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Höhe','Height');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Soll der Status dieses Banners wirklich geändert werden?','Do you really want to change the status of this banner?');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Soll der Banner wirklich unwiderruflich gelöscht werden?','Do you really want to delete this banner permanently?');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Soll das Format und alle enthaltenen Banner wirklich unwiderruflich gelöscht werden?','Do you really want to delete this format and all included banners permanently?');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Das Standardformat darf nicht gelöscht werden!','The default format may not be deleted!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Optionen','Options');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Name','Name');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Banner','Banner');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Views','Views');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Klicks','Clicks');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Ratio','Ratio');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Tragen Sie einen Banner in die Rotation mit dem ausgewählten Format ein. Bitte füllen Sie dabei alle Felder aus. Wenn Sie einen Bannercode direkt eintragen möchten, nutzen Sie bitte das','Add a banner in the rotation with the selected format. Please fill out all fields. If you want to add a bannercode directly, please use the');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannercode Formular','bannercode form');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Banner-Name','Banner-name');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Link-URL','Link-URL');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Grafik-Adresse','Image-URL');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Kurzbeschreibung','Description');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Format','Format');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Formate','Formats');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Kategorie','Category');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Kategorien','Categories');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('absenden','send');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Hier können Sie einen beliebigen Bannercode auswählen. Jeder beinhaltet eine eigenständige Zufallsrotation und kann mehrfach auf einer Seite eingesetzt werden.','On this page you can choose any bannercode. Each includes an independent random rotation and can be used multiple times per webpage.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannercode - HTML Iframe','Bannercode - HTML Iframe');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannercode - HTML Image','Bannercode - HTML Image');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Mit HTML-Image kann ein dynamischer Bannercode in jede HTML Seite integriert werden.','HTML-Image is a dynamic banner code that can be used in every HTML site.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Der klassische Iframe Code lässt sich in jeder HTML Seite unterbringen.','The classic Iframe Code can be used in every HTML site.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannercode - PHP Include','Bannercode - PHP Include');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Dieses PHP Script lässt sich in bestehende PHP-Programme integrieren und erzeugt so beim Aufruf einen Banner.','This PHP script can be integrated into existing PHP applications and generates a banner when the page is loaded.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Wenn Sie nach Updates suchen, wird eine Verbindung zum Updateserver hergestellt. Dies dient lediglich der Versionsprüfung und es werden dabei keine Benutzer-Informationen übermittelt oder gespeichert.','If you want to search for updates, a connection to our update server is established. This is only used for the version check and there will be no user information transmitted or stored.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Updates suchen','Update check');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Es wurden noch keine Banner in diesem Format eingetragen.','No banners entered in this format yet.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Willkommen bei AdRotator!','Welcome to AdRotator!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Allgemeine Informationen','General Information');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bei Fragen, Anregungen und Problemen können Sie das','For questions, suggestions or problems, you can visit the');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Support-Forum besuchen','Support-Forums');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Nach Updates suchen','Check for updates');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Option','Option');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Wert','Value');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Daten Schreibrechte','Data write access');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Datenbank','Database');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Sie besitzen bereits die aktuelle Version! Es ist kein Update notwendig.','You already have the latest version! There is no update needed.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('AdRotator Zugang','AdRotator Access');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Administrator Name','Administrator name');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Administrator Passwort','Administrator password');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('anmelden','login');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Fehler','Error');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('In Ihrem Browser ist JavaScript deaktiviert. Arlight ist somit nicht voll funktionsfähig.','Your JavaScript is disabled. Arlight is therefore not fully functional.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bitte aktivieren Sie JavaScript dauerhaft für diese Seite und versuchen es erneut.','Please enable JavaScript permanently for this page and try again.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Das Format muss einen Namen haben!','The format must have a name!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Es ist online eine neuere Version verfügbar!','There is a newer version available online!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Jetzt herunterladen!','Download now!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Ein Format mit diesen Maßen existiert bereits!','A format with these measurements already exists!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Tragen Sie einen Bannercode in die Rotation mit dem ausgewählten Format ein. Bitte füllen Sie dabei alle Felder aus.','Enter a code in the banner rotation with the selected format. Please fill out all fields.');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bitte überprüfen Sie jeden Bannercode vor dem Eintragen, da dieser ungefiltert ausgegeben wird und Sicherheitsrisiken mit sich bringen kann. Wenn Sie nicht sicher sind, nutzen Sie bitte die','Please check each bannercode before entering, since it is displayed unfiltered and can bring security risks with it. If you are unsure, please use the');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('sichere Variante','safe version');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('oder erkundigen sich beim Betreiber des Bannercodes','or contact the owner of the bannercode');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bannercode eintragen','Add bannercode');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Bitte alle Felder ausfüllen','Please fill all fields');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('löschen','delete');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Status','Status');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Details','Details');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Legende','Legend');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Banner mit Bannercode','Banner with Bannercode');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Banner mit rotem Namen sind inaktiv','Banner with red names are inactive');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Hier können Sie die Daten des Banners anpassen','In this dialog you can edit the banner data');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Banner Detailansicht','Banner Details');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('verschieben','move');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Home','Home');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Einstellungen','Settings');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Einstellung','Setting');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Einstellungen speichern','Save settings');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Benutzerverwaltung','User control');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Nach Software-Aktualisierungen suchen','Check for software updates');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('weiter','next');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Soll der Benutzerstatus wirklich geändert werden?','Do you really want to change the user status?');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Der Hauptbenutzer darf nicht deaktiviert werden!','The main user cannot be deactivated!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Soll der Benutzer wirklich unwiderruflich gelöscht werden?','Do you really want to permanently delete the user?');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Der Hauptbenutzer darf nicht gelöscht werden!','The main user cannot be deleted!');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Benutzer','User');
/* SPLIT */
INSERT INTO [language] ([de],[en]) VALUES ('Benutzer hinzufügen','Add user');
/* SPLIT */
COMMIT TRANSACTION;