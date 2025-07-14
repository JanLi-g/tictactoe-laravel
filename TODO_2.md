Hier ist dein Blueprint für die Auslagerung der Spielstände in MySQL, übersichtlich als Schritt-für-Schritt-Anleitung im Markdown-Format für `TODO_2.md`:

```markdown
# Blueprint: Spielstände (X, O) in MySQL speichern mit Laravel

## 1. Migration erstellen

```bash
php artisan make:migration create_game_scores_table
```

**Migration anpassen:**

```php
// database/migrations/xxxx_xx_xx_create_game_scores_table.php
public function up()
{
    Schema::create('game_scores', function (Blueprint $table) {
        $table->id();
        $table->integer('x_score')->default(0);
        $table->integer('o_score')->default(0);
        $table->timestamps();
    });
}
```

**Migration ausführen:**

```bash
php artisan migrate
```

---

## 2. Model erstellen

```bash
php artisan make:model GameScore
```

---

## 3. API-Controller erstellen

```bash
php artisan make:controller GameScoreController
```

**Controller Methoden:**
- `show`: Spielstände abrufen
- `increment`: Spielstand erhöhen
- `reset`: Spielstände zurücksetzen

---

## 4. API-Routen anlegen

In `routes/api.php`:

```php
use App\Http\Controllers\GameScoreController;

Route::get('/score', [GameScoreController::class, 'show']);
Route::post('/score/increment', [GameScoreController::class, 'increment']);
Route::post('/score/reset', [GameScoreController::class, 'reset']);
```

---

## 5. AJAX im Frontend

Ersetze die lokale Speicherung in JS durch API-Calls (z\.B\. mit `fetch` oder `axios`) zu den Laravel-Endpunkten.

---

## Erklärung

Damit werden die Spielstände persistent in MySQL gespeichert und können von PHP und JS synchron genutzt werden.  
Die Kommunikation erfolgt über HTTP-Requests zwischen Frontend und Backend.
```

So kannst du die einzelnen Schritte als Blueprint abarbeiten und hast alles übersichtlich dokumentiert.
