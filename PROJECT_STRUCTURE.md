# Projektstruktur: TicTacToe Laravel

## Hauptdateien
- **`artisan`**: CLI-Skript für Laravel-Befehle.
- **`composer.json`**: PHP-Abhängigkeiten und Konfiguration.
- **`composer.lock`**: Abhängigkeits-Lock-Datei.
- **`fact_collection.md`**: Markdown-Datei (Inhalt unbekannt).
- **`package.json`**: JavaScript-Abhängigkeiten und Skripte.
- **`phpunit.xml`**: PHPUnit-Konfigurationsdatei.
- **`README.md`**: Projektbeschreibung.
- **`TODO_2.md`, `TODO.md`**: To-Do-Listen.
- **`vite.config.js`**: Vite-Konfigurationsdatei für Frontend-Bundling.

---

## Verzeichnisse

### **`app/`**
- **`Http/`**: Verarbeitet HTTP-Anfragen.
  - **`Kernel.php`**: HTTP-Kernel.
  - **`Controllers/`**: Controller für die Anwendungslogik.
  - **`Middleware/`**: Middleware für Anfragenfilterung.
- **`Models/`**: Eloquent-Modelle (z. B. `GameScore.php`, `User.php`).
- **`Providers/`**: Service-Provider für Abhängigkeitsregistrierung.

### **`bootstrap/`**
- **`app.php`**: Initialisiert die Laravel-Anwendung.
- **`providers.php`**: Provider-Registrierung.
- **`cache/`**: Vorkompilierte Dateien.

### **`config/`**
- Konfigurationsdateien (z. B. `app.php`, `auth.php`, `database.php`).

### **`database/`**
- **`factories/`**: Generiert Testdaten (z. B. `UserFactory.php`).
- **`migrations/`**: Datenbankmigrationen (z. B. `create_users_table.php`).
- **`seeders/`**: Seed-Daten (z. B. `DatabaseSeeder.php`).

### **`public/`**
- **`index.php`**: Einstiegspunkt für HTTP-Anfragen.
- **`build/`**: Gebündelte Frontend-Assets.
- **`svg/`**: SVG-Dateien.

### **`resources/`**
- **`css/`**: CSS- und SCSS-Dateien.
- **`js/`**: JavaScript-Dateien (z. B. `app.js`, `bootstrap.js`).
- **`views/`**: Blade-Templates (z. B. `welcome.blade.php`).

### **`routes/`**
- **`web.php`**: Web-Routen.
- **`api.php`**: API-Routen.
- **`console.php`**: Konsolenbefehle.

### **`storage/`**
- **`app/`**: Benutzerdefinierte Dateien.
- **`framework/`**: Framework-Daten (z. B. Cache, Sitzungen).
- **`logs/`**: Log-Dateien (z. B. `laravel.log`).

### **`tests/`**
- **`Feature/`**: Funktionstests.
- **`Unit/`**: Unit-Tests.

### **`vendor/`**
- Enthält von Composer installierte Abhängigkeiten.
