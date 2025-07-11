### TODO's and Info ###

# public/
# Einstiegspunkt der Anwendung (index.php). Leitet Anfragen weiter und lädt die Anwendung.

# bootstrap/
# Initialisiert das Framework, lädt Autoloader und Konfigurationsdateien.

# config/
# Enthält alle Konfigurationsdateien für die Anwendung (z.B. Datenbank, Mail, Cache).

# routes/
# Definiert die Routen der Anwendung (Web, API, Console).

# app/
# Hauptverzeichnis für den Anwendungscode: Controller, Models, Services, etc.

# resources/
# Enthält Views (Blade), Assets (CSS, JS), Übersetzungen und Rohdateien.

# storage/
# Zwischenspeicher für Logs, Cache, Sessions und hochgeladene Dateien.

# database/
# Migrationen, Seeders und Factories für die Datenbank.

# vendor/
# Enthält alle via Composer installierten Abhängigkeiten.

Service Container

# Zentrales Werkzeug für Dependency Injection und Verwaltung von Klasseninstanzen.

# Binding
# Verknüpft Schnittstellen mit konkreten Implementierungen oder Instanzen.

# Resolving
# Holt Instanzen aus dem Container, löst Abhängigkeiten automatisch auf.

# Automatic Injection
# Konstruktor- und Methoden-Injection werden automatisch vom Container gehandhabt.

# Service Providers
# Registrieren Bindings und initialisieren Dienste beim Start der Anwendung.

# Contextual Binding
# Ermöglicht unterschiedliche Implementierungen je nach Kontext.

# Tagging
# Gruppiert mehrere Bindings unter einem gemeinsamen Tag zur späteren Verwendung.

# Container Events
# Ermöglichen das Reagieren auf das Erstellen oder Auflösen von Instanzen.

Service Providers

# Service Provider
# Zentrale Klasse zur Registrierung von Diensten und Bindings im Service Container.

# Register-Methode
# Registriert Bindings und Abhängigkeiten, wird beim Start der Anwendung ausgeführt.

# Boot-Methode
# Initialisiert Dienste nach dem Laden aller Service Provider.

# Deferred Provider
# Lädt Provider nur bei Bedarf, um die Performance zu verbessern.

# Provider Registration
# Service Provider werden in der config/app.php registriert.

# Custom Provider
# Eigene Service Provider können mit php artisan make:provider erstellt werden.

# Lifecycle
# Erst wird register, dann boot ausgeführt.

Facades

# Facade
# Statische Schnittstelle zu Klassen im Service Container.

# Vorteile
# Einfacher Zugriff auf Services ohne direkte Instanziierung.

# Funktionsweise
# Facades lösen Methodenaufrufe dynamisch auf Instanzen im Service Container auf.

# Beispiele
# Häufig genutzte Facades sind Cache, DB, Route, Auth, Mail.

# Eigene Facades
# Eigene Facades können durch das Erstellen einer Klasse und das Erben von Illuminate\Support\Facades\Facade erstellt werden.

# Testbarkeit
# Facades unterstützen das Mocking und das Austauschen von Instanzen für Tests.

# Service Container
# Facades sind eng mit dem Service Container verbunden und greifen auf dessen Instanzen zu.

The Basics

Routing
# Definiert, wie HTTP-Anfragen an Controller und Aktionen weitergeleitet werden.

# Route Definition
# Routen werden in routes/web.php und routes/api.php festgelegt.

# HTTP Methods
# Unterstützt verschiedene Methoden wie GET, POST, PUT, DELETE, PATCH, OPTIONS.

# Route Parameters
# Ermöglicht die Übergabe von Parametern in der URL an Controller.

# Named Routes
# Routen können benannt werden, um sie einfacher zu referenzieren.

# Route Groups
# Gruppiert Routen mit gemeinsamen Eigenschaften wie Middleware oder Prefix.

# Middleware
# Middleware kann einzelnen Routen oder Gruppen zugewiesen werden.

# Route Model Binding
# Automatisches Laden von Eloquent-Modellen anhand von Parametern.

# Fallback Routes
# Definiert eine Route, die bei nicht gefundenen URLs ausgeführt wird.

# Redirects
# Routen können Weiterleitungen zu anderen URLs ausführen.

# View Routes
# Routen können direkt eine View zurückgeben, ohne einen Controller zu nutzen.

Middleware
# Middleware
# Filtert und verarbeitet HTTP-Anfragen vor und nach dem Erreichen des Controllers.

# Registrierung
# Middleware wird in app/Http/Kernel.php registriert und gruppiert.

# Verwendung
# Kann einzelnen Routen oder Route-Gruppen zugewiesen werden.

# Built-in Middleware
# Laravel bietet vorgefertigte Middleware wie Authentifizierung, CSRF-Schutz, CORS.

# Eigene Middleware
# Eigene Middleware kann mit php artisan make:middleware erstellt werden.

# Parameter
# Middleware kann Parameter zur weiteren Konfiguration erhalten.

# Terminable Middleware
# Kann nach der Antwort zusätzliche Aktionen ausführen (z.B. Logging).

# Reihenfolge
# Die Reihenfolge der Middleware-Ausführung ist konfigurierbar.

CSRF
# CSRF (Cross-Site Request Forgery)
# Schutzmechanismus gegen unerwünschte Anfragen von externen Seiten.

# CSRF Token
# Einzigartiges Token wird jeder Sitzung zugewiesen und muss bei POST-, PUT-, PATCH-, DELETE-Anfragen mitgesendet werden.

# Middleware
# Die VerifyCsrfToken-Middleware prüft das Token bei eingehenden Anfragen.

# Token Einbindung
# Im Blade-Template wird das Token mit @csrf automatisch eingefügt.

# Ausnahmen
# Bestimmte URIs können von der CSRF-Prüfung ausgenommen werden (app/Http/Middleware/VerifyCsrfToken.php).

# AJAX
# CSRF-Token muss bei AJAX-Anfragen im Header mitgesendet werden.

# Fehler
# Fehlt das Token oder ist es ungültig, wird die Anfrage abgelehnt.

Controllers
# Controller
# Verwalten die Logik für HTTP-Anfragen und trennen sie von den Routen.

# Erstellung
# Controller werden mit php artisan make:controller erstellt.

# Methoden
# Enthalten Funktionen, die auf verschiedene Routen reagieren.

# Resource Controller
# Bieten vordefinierte Methoden für CRUD-Operationen.

# Single Action Controller
# Controller mit nur einer __invoke-Methode für einzelne Aktionen.

# Dependency Injection
# Abhängigkeiten können direkt in Controller-Methoden injiziert werden.

# Middleware
# Middleware kann auf Controller oder einzelne Methoden angewendet werden.

# Namespaces
# Controller liegen standardmäßig im Namespace App\Http\Controllers.

# Routing
# Routen können Controller und deren Methoden direkt referenzieren.

Requests
# Request
# Repräsentiert eine HTTP-Anfrage und bietet Zugriff auf deren Daten.

# Zugriff auf Daten
# Mit $request->input(), $request->query(), $request->all() können Eingaben abgerufen werden.

# Validierung
# Requests können direkt validiert werden, z.B. $request->validate([...]) oder über Form Requests.

# Dateien
# Hochgeladene Dateien sind über $request->file() verfügbar.

# JSON
# JSON-Daten können mit $request->json() abgerufen werden.

# Header & Cookies
# Zugriff auf Header mit $request->header(), auf Cookies mit $request->cookie().

# Pfad & URL
# Methoden wie $request->path(), $request->url(), $request->fullUrl() geben Pfad und URL zurück.

# Methoden
# $request->method() gibt die HTTP-Methode zurück, $request->isMethod('post') prüft die Methode.

# Form Requests
# Eigene Request-Klassen zur Validierung und Autorisierung mit php artisan make:request.

# Autorisierung
# Form Requests können die Autorisierung von Anfragen prüfen.

# Alte Eingaben
# Mit $request->old() können vorherige Eingaben abgerufen werden (z.B. nach Redirect).

Responses
# Response
# Stellt HTTP-Antworten für Anfragen bereit.

# String & Array
# Controller können Strings, Arrays oder Views als Antwort zurückgeben.

# Response-Objekt
# Mit response() können komplexe Antworten erstellt werden (Status, Header, Cookies).

# JSON
# Mit response()->json() werden Daten als JSON zurückgegeben.

# Redirects
# Mit response()->redirect() oder redirect() wird eine Weiterleitung ausgeführt.

# Datei-Download
# Mit response()->download() können Dateien zum Download angeboten werden.

# Streamed Responses
# Mit response()->stream() können große Datenmengen gestreamt werden.

# Views
# Mit view() werden Blade-Templates als Antwort zurückgegeben.

# Header & Cookies
# Header und Cookies können der Antwort hinzugefügt werden.

# Status Codes
# Der HTTP-Statuscode kann individuell gesetzt werden (z.B. response('', 404)).

Views
# Views
# Präsentationsschicht der Anwendung, meist mit Blade-Templates.

# Blade
# Laravel-eigene Template-Engine mit einfacher Syntax und Vererbung.

# View Rendering
# Mit view() werden Templates gerendert und Daten übergeben.

# Template-Vererbung
# Layouts und Sections ermöglichen wiederverwendbare Strukturen.

# Komponenten
# Blade-Komponenten und -Includes für modulare Templates.

# Datenübergabe
# Daten werden als Array an die View übergeben.

# View Composer
# Bindet Daten oder Logik an bestimmte Views.

# Caching
# Blade-Templates werden kompiliert und gecacht für bessere Performance.

# Pfade
# Views liegen im Verzeichnis resources/views.

# Sicherheit
# Blade escaped Variablen standardmäßig, um XSS zu verhindern.

Blade Templates
# Blade
# Laravel-eigene Template-Engine für Views mit einfacher und ausdrucksstarker Syntax.

# Syntax
# Blade verwendet Direktiven wie @if, @foreach, @include, @csrf.

# Template-Vererbung
# Mit @extends und @section können Layouts und Bereiche definiert und vererbt werden.

# Komponenten
# Blade-Komponenten und -Includes ermöglichen modulare und wiederverwendbare Templates.

# Datenübergabe
# Variablen werden mit {{ $variable }} ausgegeben und automatisch escaped.

# Unescaped Output
# Mit {!! $variable !!} kann unescaped HTML ausgegeben werden.

# Control Structures
# Bedingungen und Schleifen werden mit Blade-Direktiven geschrieben.

# Kommentare
# Blade-Kommentare mit {{-- Kommentar --}} sind im HTML nicht sichtbar.

# Service Injection
# Services können mit @inject in Views eingebunden werden.

# Stack & Push
# Mit @stack und @push können Inhalte dynamisch in Layouts eingefügt werden.

# Includes
# Mit @include werden andere Templates eingebunden.

# Sicherheit
# Blade escaped Variablen standardmäßig, um XSS zu verhindern.

# Caching
# Blade-Templates werden kompiliert und gecacht für bessere Performance.

# Pfade
# Blade-Dateien liegen im Verzeichnis resources/views.

Vite
# Vite
# Moderner Build-Tool für Frontend-Assets in Laravel.

# Integration
# Laravel integriert Vite für schnelles Entwickeln und effizientes Bundling von CSS und JS.

# Konfiguration
# Einstellungen in vite.config.js, z.B. Pfade, Plugins, Aliase.

# Entwicklung
# Mit npm run dev werden Assets im Entwicklungsmodus bereitgestellt (Hot Module Replacement).

# Produktion
# Mit npm run build werden Assets für die Produktion kompiliert und optimiert.

# Blade Integration
# Assets werden mit @vite(['resources/js/app.js', 'resources/css/app.css']) in Blade eingebunden.

# Environment
# .env-Datei steuert Vite-Server-URL und weitere Optionen.

# Erweiterbarkeit
# Vite kann mit Plugins und eigenen Konfigurationen erweitert werden.

# Asset-Versionierung
# Automatische Versionierung und Cache-Busting für Produktions-Assets.

# CSS & JS
# Unterstützt moderne JavaScript- und CSS-Features (z.B. ES Modules, PostCSS).

# Hot Reload
# Änderungen an Assets werden sofort im Browser aktualisiert.

# Migration
# Bestehende Mix-Konfigurationen können zu Vite migriert werden.

URL Generation
# URLs
# Verwaltung und Generierung von URLs innerhalb der Anwendung.

# url()-Helper
# Mit url() können absolute URLs generiert werden.

# route()-Helper
# Mit route('name') werden URLs zu benannten Routen erstellt.

# action()-Helper
# Erstellt URLs zu Controller-Aktionen.

# Asset-URLs
# Mit asset() werden URLs zu öffentlichen Assets (z\.B\. CSS, JS) generiert.

# Signed URLs
# Mit URL::signedRoute() können signierte URLs für sichere Aktionen erstellt werden.

# Temporary Signed URLs
# Mit URL::temporarySignedRoute() werden zeitlich begrenzte signierte URLs erstellt.

# Current URL
# Mit url()->current() kann die aktuelle URL abgerufen werden.

# Previous URL
# Mit url()->previous() wird die vorherige URL zurückgegeben.

# Custom URL Generation
# Eigene URL-Generatoren können über die URL-Facade genutzt werden.

# HTTPS
# URLs können mit https generiert werden, z\.B\. url()->secure().

# Localized URLs
# Unterstützung für mehrsprachige URLs durch Packages oder eigene Logik.

# Redirects
# Mit redirect()->to() oder redirect()->route() wird eine Weiterleitung ausgeführt.

HTTP Sessions
# Session
# Speichert benutzerspezifische Daten zwischen HTTP-Anfragen.

# Treiber
# Unterstützt verschiedene Treiber: file, cookie, database, redis, array.

# Konfiguration
# Einstellungen in config/session.php (Lebensdauer, Treiber, Verschlüsselung).

# Zugriff
# Mit session() oder $request->session() kann auf die Session zugegriffen werden.

# Daten speichern
# session(['key' => 'value']) oder $request->session()->put('key', 'value').

# Daten abrufen
# session('key') oder $request->session()->get('key').

# Daten entfernen
# session()->forget('key') oder $request->session()->pull('key').

# Flash-Daten
# Temporäre Daten mit session()->flash('key', 'value'), nur für die nächste Anfrage verfügbar.

# Existenz prüfen
# session()->has('key') prüft, ob ein Wert existiert.

# Alle Daten
# session()->all() gibt alle Session-Daten zurück.

# Löschen
# session()->flush() entfernt alle Daten aus der Session.

# Regenerieren
# session()->regenerate() erstellt eine neue Session-ID.

# Middleware
# Die Session-Middleware aktiviert die Session für Web-Routen.

# Sicherheit
# Session-Daten werden verschlüsselt und sind vor Manipulation geschützt.

# Authentifizierung
# Authentifizierungsdaten werden in der Session gespeichert.

# CSRF
# CSRF-Token werden in der Session abgelegt.

# API
# Für APIs wird meist kein Session-Handling verwendet.

Validation
# Validation
# Validierung von Benutzereingaben und Daten in Laravel.

# Form Request
# Eigene Request-Klassen mit Validierungsregeln und Autorisierung (php artisan make:request).

# Inline Validation
# Direkt im Controller mit $request->validate([...]) oder Validator::make([...]) möglich.

# Regeln
# Umfangreiche Validierungsregeln wie required, email, min, max, unique, exists, regex.

# Custom Rules
# Eigene Validierungsregeln können mit Rule-Klassen erstellt werden.

# Fehlerausgabe
# Fehler werden automatisch an die View übergeben und können mit @error angezeigt werden.

# Fehlerobjekt
# $errors-Objekt enthält alle Validierungsfehler.

# Attribute & Messages
# Eigene Attributnamen und Fehlermeldungen können definiert werden.

# Array Validation
# Validierung von Array-Daten und verschachtelten Feldern möglich.

# Datei-Validierung
# Regeln für Dateitypen, Größe und Dimensionen (z.B. image, mimes, max).

# Conditional Validation
# Regeln können abhängig von anderen Feldern angewendet werden.

# After Validation Hook
# Mit after() können nachträgliche Prüfungen durchgeführt werden.

# Stop on First Failure
# Mit stopOnFirstFailure() wird die Validierung beim ersten Fehler abgebrochen.

# Localization
# Fehlermeldungen können lokalisiert werden (resources/lang).

# Client-Side
# Keine automatische Client-Side-Validierung, aber Integration mit JS möglich.

Error Handling
# Fehlerbehandlung
# Verwaltung und Anzeige von Fehlern und Ausnahmen in Laravel.

# Exception Handler
# Zentrale Fehlerbehandlung in app/Exceptions/Handler.php.

# Reporting
# Fehler werden geloggt und können an externe Dienste gemeldet werden (z\.B\. Bugsnag, Sentry).

# Rendering
# Fehler werden als HTTP-Response oder View ausgegeben.

# Custom Exceptions
# Eigene Exception-Klassen können erstellt und behandelt werden.

# HTTP Exceptions
# Mit abort(404) oder throw new HttpException() können HTTP-Fehler ausgelöst werden.

# Fehlerseiten
# Individuelle Fehlerseiten im Verzeichnis resources/views/errors (z\.B\. 404.blade.php).

# Validierungsfehler
# Validierungsfehler werden automatisch an die View übergeben und können mit @error angezeigt werden.

# Logging
# Fehler werden im storage/logs-Verzeichnis gespeichert, konfigurierbar in config/logging.php.

# Debug-Modus
# Im .env-File mit APP_DEBUG=true werden detaillierte Fehler angezeigt.

# Fehler-Reporting
# Mit report() können Fehler manuell gemeldet werden.

# Fehler unterdrücken
# Mit try-catch können Fehler abgefangen und eigene Logik ausgeführt werden.

# Fehler-Handler anpassen
# Die Handler-Klasse kann für individuelles Reporting und Rendering erweitert werden.

# API-Fehler
# Fehler für APIs werden als JSON ausgegeben.

# Maintenance Mode
# Eigene Fehlerseite für Wartungsmodus möglich (503.blade.php).

Logging
# Logging
# Verwaltung und Speicherung von Log-Nachrichten in Laravel.

# Treiber
# Unterstützt verschiedene Treiber: single, daily, syslog, errorlog, stack, custom.

# Konfiguration
# Einstellungen in config/logging.php (Kanäle, Treiber, Level, Pfade).

# Kanäle
# Kanäle bündeln verschiedene Log-Treiber und -Einstellungen.

# Stack-Kanal
# Kombiniert mehrere Kanäle für paralleles Logging.

# Log Levels
# Unterstützt verschiedene Level: emergency, alert, critical, error, warning, notice, info, debug.

# Log-Nachrichten
# Mit Log::info(), Log::error(), Log::debug() werden Nachrichten geschrieben.

# Kontext
# Zusätzliche Daten können als Kontext übergeben werden (z.B. Log::info('Message', ['user_id' => 1])).

# Monolog
# Laravel verwendet Monolog als Logging-Bibliothek.

# Custom Channels
# Eigene Kanäle und Treiber können erstellt werden.

# Exception Logging
# Fehler und Ausnahmen werden automatisch geloggt.

# Logging für Wartungsmodus
# Wartungsmodus-Aktionen werden ebenfalls geloggt.

# Externe Dienste
# Unterstützung für Logging an externe Dienste wie Slack, Papertrail, Sentry.

# Log Rotation
# Automatische Rotation und Archivierung von Log-Dateien (z.B. daily).

# Zugriff
# Logs liegen im storage/logs-Verzeichnis.

# Fehlerbehandlung
# Fehler beim Logging werden im Exception-Handler behandelt.

# Testbarkeit
# Log-Ausgaben können im Test gemockt und geprüft werden.
