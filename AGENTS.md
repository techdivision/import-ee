# AGENTS.md - import-ee

## Zweck & Verantwortung

Das `import-ee` Modul bietet **EE-spezifische Import-Funktionalität** für das Pacemaker Import-System. Es ist ein **Tier 4 Modul** und dient als Basis für alle EE-Extensions.

**Hauptverantwortung:**
- EE-spezifische Utilities und Funktionen
- Staging Table Management
- Sequence Management für EE
- Repository Pattern für EE-Daten
- Observer Pattern für EE-Hooks
- 4 Dependents (category-ee, product-ee, converter-ee)

## Architektur & Design Patterns

### Kern-Klassen
- **EeRepository**: Persistierung von EE-Daten
- **StagingRepository**: Verwaltung von Staging-Tabellen
- **SequenceRepository**: Verwaltung von Sequences
- **EeObserver**: Observer für EE-Hooks

### Verwendete Patterns
- **Observer Pattern**: Für EE-Hooks
- **Repository Pattern**: Für Daten-Persistierung
- **Factory Pattern**: Für Object-Erstellung

## Abhängigkeiten

### Externe Pakete
- **Keine** - Nur EE-Implementierungen

### TechDivision Dependencies
- **import** ^18.0.0 - Core Framework

### Abhängig von diesem Modul (4 Reverse Dependencies)
1. **import-category-ee** - EE Category Extensions
2. **import-product-ee** - EE Product Extensions
3. **import-converter-ee** - EE Converter
4. **import-cli-simple** - Master CLI

## Wichtige Entry Points

### Repository Klassen
```php
// EE Repository
EeRepository::create($row): void
EeRepository::update($row): void

// Staging Repository
StagingRepository::create($row): void
StagingRepository::findByEntityId($entityId): array

// Sequence Repository
SequenceRepository::create($row): void
SequenceRepository::findByEntityId($entityId): array
```

### Observer Klassen
```php
// EE Observer
EeObserver::handle($row): void
```

## Events & Extension Points

**Keine Events** - Tier 4 EE-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 4 Modul**: Basis für EE-Extensions
2. **EE-fokussiert**: Spezialisiert auf Magento EE Features
3. **Staging & Sequence**: Zentral für EE-Funktionalität
4. **Observer Pattern**: Für EE-Hooks
5. **Repository Pattern**: Für Daten-Persistierung
6. **4 Dependents**: Basis für spezialisierte EE-Module

### Bei Änderungen
- **EE-Kompatibilität**: Beachte EE-Struktur
- **Observer-Kompatibilität**: Neue Observers sollten optional sein
- **Backward Compatibility**: Alte Imports sollten noch funktionieren

### Implementierungs-Hinweise
- Nutze Observer Pattern für Custom EE-Processing
- Beachte Staging-Tabellen bei EE-Imports
- Erwäge Sequence-Management

## Häufige Use Cases

### CSV-Beispiel: EE Product Import mit Staging
```csv
sku,name,staging_date,sequence_value
PRODUCT-EE-1,EE Product 1,2026-01-01,100
PRODUCT-EE-2,EE Product 2,2026-02-01,101
PRODUCT-EE-3,EE Product 3,2026-03-01,102
```

### Szenarien
1. **Staging Import**: Products in Staging-Tabellen importieren für spätere Veröffentlichung
2. **Sequence Management**: Automatische Sequence-Verwaltung für EE-Entities
3. **Bulk EE Updates**: Mehrere Staging-Importe parallel

## Performance-Überlegungen

- **Staging-Overhead**: Staging-Tabellen verursachen ~10-15% zusätzliche Schreiboperationen
- **Sequence-Lookups**: Sequence-Abfragen können mit vielen Entities langsam werden
- **Memory-Usage**: Staging-Data im Memory kann bei 100k+ Produkten zu >500MB führen
- **Empfehlung**: Nutze Batch-Size von 1000-5000 für optimale Performance

## Verwandte Module

- **import-product-ee**: Nutzt `import-ee` für Product-Staging
- **import-category-ee**: Nutzt `import-ee` für Category-Staging  
- **import-converter-ee**: Nutzt `import-ee` für Converter-Staging
- **import-ee** ← **diese Datei**

## Troubleshooting & FAQ

**Q: Staging-Tabellen werden nicht erstellt**
- A: Prüfe ob EE Staging-Module korrekt installiert sind: `bin/magento module:status | grep Staging`

**Q: Sequence-Werte sind falsch**
- A: Leere Sequence-Tabellen und re-starte Import: `TRUNCATE table sequence_product`

**Q: "EE-Only" Fehler beim CE-Import**
- A: Dieses Modul ist nur für Magento EE. Für CE nutze normale Product-Import Module.

## Bekannte Einschränkungen

- **EE-Only**: Nur für Magento EE Deployments
- **Keine CE-Features**: CE-Features sind in anderen Modulen
- **Staging-Abhängig**: Erfordert EE Staging-Funktionalität

## Zusammenfassung

`import-ee` ist ein **Tier 4 Modul**, das EE-spezifische Import-Funktionalität für das Pacemaker-System bietet. Es ist die Basis für alle EE-Extensions und unterstützt Staging und Sequence Management.

**Für Agenten:** Verstehe dieses Modul als **EE Import-Basis** mit Staging und Sequence Support.
