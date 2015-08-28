# Herbie Smartypants Plugin

`Smartypants` ist ein [Herbie](http://github.com/getherbie/herbie) Plugin, mit dem mit Hilfe des Smartypants-Parsers
von Michel Fortin typografische Anpassungen am Inhalt und am Seitentitel vorgenommen werden.

Die Smartypants-Library kümmert sich um die folgenden Konvertierungen:

- Gerade Hochkommas (" und ') in "korrekte" Anführungszeichen
- Rückwärts geneigte Hochkommas (wie diese '') in "korrekte" Anführungszeichen
- Zwei oder drei Bindestriche (-- und ---) in Quer- und Gedankenstriche
- Drei nacheinander folgende Punkte (...) in Auslassungspunkte

Mehr Infos zur Library und deren Optionen findest du unter <https://github.com/michelf/php-smartypants>.


## Installation

Das Plugin installierst du via Composer.

	$ composer require getherbie/plugin-smartypants

Danach aktivierst du das Plugin in der Konfigurationsdatei.

    plugins:
        enable:
            - smartypants


## Konfiguration

Unter `plugins.config.smartypants` stehen dir die folgenden Optionen zur Verfügung:

    # Add a twig filter
    twig_filter: false

    # Enable processing on page title
    process_title: false

    # Enable processing on page content    
    process_content: true

    # Smartypants-specific configuration options
    options: "qDew"

Mehr zu den möglichen Optionen von Smartypants findest du unter 
<https://github.com/michelf/php-smartypants#options-and-configuration>.


## Seiteneigenschaften

Die globale Konfiguration ausser für `twig_filter` kannst du in den Seiteneigenschaften einer Seite übersteuern.

    ---
    title: 'Meine "Seite"'
    smartypants:
        process_title: true
        process_content: true
        options: qd
    ---

Die Seiteneigenschaften haben Vorrang gegenüber den globalen Einstellungen.


## Twig-Filter

Falls der Twig-Filter aktiviert ist, kannst du Smartypants auch in Layoutdateien nutzen: 

    {{ page.title | smartypants }}
    
Du kanst dem Filter auch eigene SmartyPants-Optionen mitgeben:

    {{ page.title | smartypants('qew') }}
