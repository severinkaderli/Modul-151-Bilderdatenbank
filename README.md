# Modul-151-Bilderdatenbank
PHP-Bilderdatenbank, die als Projekt im Rahmen des Moduls 151 an der gibb erstellt wurde. Die Benutzer können jeweils eigene Galerien erstellen und dort dann beliebig viele Bilder hochladen. Die Daten werden dabei in einer MySQL-Datenbank gespeichert.

## Systemanforderungen
* PHP-Version 5.5+
* MySQL (MariaDB)
* mod_rewrite

## Funktionen
### Authentifizierung:
- Registrierung von Benutzern
- Login für Benutzer
- Logout

### Benutzereinstellungen (Zusatz):
- Passwortänderung
- Konto löschen

### Benutzerverwaltung (Für Administrator) (Zusatz):
- Benutzer löschen
- Benutzer zu Administrator hochstufen

### Galerien
- Erstellen von Galerien
- Galerie-Übersicht (Eigene & Öffentliche) mit Thumbnails
- Einzelne Galerie anschauen
- Galerien bearbeiten (Name) (Zusatz)
- Galerien löschen (inklusive dazugehöriger Bilder) (Zusatz)
- Galerien teilen (Zusatz)

### Bilder
- Bilderupload zu einer Galerie
- Mehrfachupload möglich (Zusatz)
- Bild wird auf Server gespeichert (Keine doppelten Namen)
- Thumbnail wird generiert (100x100px)
- Anzeigen der Thumbnails einer Galerie
- Orignalbild bei Klick wird angezeigt
- Bilder können beim Upload mit mehreren Tags versehen werden
- Bilder löschen (Inklusive Dateien)
- Tags der Bilder können bearbeitet werden
- Metadaten zu Bildern anzeigen (Zusatz)

### Suche
- Suche nach getaggten Bildern
- Dropdown Liste mit vorhandenen Tags (Zusatz)
- Suche nach mehreren Tags gleichzeitig (Zusatz)

## Weitere Informationen
Weitere Informationen zum Projekt kann man in der Datei
Projektdokumentation.docx nachlesen.

## Verwendete Frontend-Bibliotheken
* jQuery
* Bootstrap CSS

## Standard-Benutzer
Benutzername (E-Mail) |  Passwort      |  Ist Admin
----------------------|----------------| -----------
root@example.com      | root           | Ja
john.doe@example.com  | user           | Nein
benutzer@exmaple.com  | qwertzuiopP1$ | Nein
admin@example.com     | qwertzuiopP1$ | Ja

## Aufbau / Struktur
Nachfolgend ist die Ordnerstruktur der Bilderdatenbank erklärt:

* Assets/
  * Dateien für das Frontend (CSS, JS, Fonts)
* Core/
  * Hauptbestandteil des Codes. Hier befinden sich die Hauptklassen die den Blog antreiben.
* upload/
  * Hier werden die hochgeladenen Bilder gespeichert.
* Views/
  * Hier befinden sich die Views die dann für den Benutzer sichtbar sind.
  * 
## Installation
1. Das Repository klonen
2. Einstellungen in config.php anpassen.
3. Datenbank von imagedb.sql importieren
