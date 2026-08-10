# Release-Anleitung: Veröffentlichung auf wordpress.org

Schritt-für-Schritt-Anleitung, um eine neue Plugin-Version im WordPress-Plugin-Verzeichnis
(https://wordpress.org/plugins/bookingtime-appointment/) zu veröffentlichen.

Das Verzeichnis wird **nicht** über GitHub gespeist, sondern über das wordpress.org-SVN:
`https://plugins.svn.wordpress.org/bookingtime-appointment/`. Struktur:

- `trunk/` — aktueller Entwicklungsstand (Spiegel dieses Git-Repos)
- `tags/<version>/` — ein Ordner pro veröffentlichter Version; wordpress.org baut das
  Download-ZIP aus dem Tag, auf den `Stable tag:` in `trunk/README.txt` zeigt
- `assets/` (SVN-Top-Level) — Banner, Icon und Screenshots der Plugin-Seite
  (nicht zu verwechseln mit dem `assets/`-Ordner **im** Plugin, der Laufzeit-CSS/JS enthält
  und mit in `trunk/` gehört)

## Voraussetzungen (einmalig)

1. **wordpress.org-Account** `bookingtime` mit Commit-Rechten auf dem Plugin.
2. **SVN-Passwort**: Bei aktivierter 2FA akzeptiert das SVN das normale Web-Passwort nicht —
   unter https://profiles.wordpress.org/ → eigenes Profil → *Account & Security* ein
   SVN-Passwort generieren und im bokonetmgm-Passwort-Tool ablegen.
3. **SVN-Client installieren** (fehlt in der WSL-Umgebung):
   ```bash
   apt-get install -y subversion
   ```

## Schritt 1: Release im Git-Repo fertigstellen

1. Offene Änderungen klären (`git status`) — committen oder verwerfen.
2. `README.txt` aktualisieren:
   - `Tested up to:` auf die aktuelle WordPress-Hauptversion heben (getestet wird im
     cms-environment auf `wordpress/v7`) — sonst bleibt das Warnbanner
     "hasn't been tested with the latest 3 major releases" auf der Plugin-Seite.
   - `== Changelog ==` und `== Upgrade Notice ==` um die neue Version ergänzen
     (Stand 08/2026 steht dort noch 1.0.0).
   - Gelegenheit für Kosmetik: `Tags:`-Zeile enthält "appointment" doppelt,
     "Worpress"-Tippfehler in der Kurzbeschreibung.
3. Versionsnummer an **drei** Stellen prüfen (müssen übereinstimmen):
   - `bt_appointment.php` → Header `Version:`
   - `bt_appointment.php` → `define( 'APPOINTMENT_VERSION', ... )`
   - `README.txt` → `Stable tag:`
4. Gutenberg-Block-Bundle frisch bauen (im cms-environment-Container, Node 22):
   ```bash
   cd blocks && npm ci && npx wp-scripts build
   ```
   `blocks/build/` ist im Git getrackt und wird mit ausgeliefert; `blocks/node_modules`
   niemals.
5. Alles committen, Git-Tag setzen und pushen:
   ```bash
   git tag <version> && git push origin master --tags
   ```

## Schritt 2: SVN-Arbeitskopie holen

```bash
cd /development
svn checkout https://plugins.svn.wordpress.org/bookingtime-appointment/ svn-bookingtime-appointment
```

Die Arbeitskopie liegt bewusst **außerhalb** dieses Git-Repos. Einmalig auschecken,
später reicht `svn update`.

## Schritt 3: trunk/ aus dem Git-Stand aktualisieren

```bash
rsync -av --delete \
  --exclude .git --exclude .svn --exclude .claude --exclude .omc \
  --exclude .gitignore --exclude blocks/node_modules --exclude RELEASE.md \
  /development/app-wp-appointment/ /development/svn-bookingtime-appointment/trunk/
```

Danach in der Arbeitskopie neue/gelöschte Dateien bei SVN registrieren (SVN erkennt das
im Gegensatz zu Git nicht selbst):

```bash
cd /development/svn-bookingtime-appointment
svn add --force trunk
svn status trunk | grep '^!' | awk '{print $2}' | xargs -r svn delete
svn status        # Kontrolle: A = neu, D = gelöscht, M = geändert
```

**Achtung:** Der Plugin-Ordner `assets/` (Bootstrap/Lightbox-CSS/JS, `icon.png` fürs
Admin-Menü) gehört mit in `trunk/` — er fehlte dort zuletzt (im Tag 6.0.8 war er noch
enthalten). Nach dem rsync prüfen, dass `trunk/assets/` existiert.

## Schritt 4 (nur bei Bedarf): Listing-Grafiken aktualisieren

Banner (`banner-772x250.jpg`), Icon (`icon-128x128.jpg`) und `screenshot-*.jpg` liegen im
SVN-Top-Level-`assets/`. Nur anfassen, wenn sich die Grafiken oder die
Screenshot-Beschreibungen in `README.txt` geändert haben.

## Schritt 5: Vor dem Commit testen

Der SVN-Commit geht **sofort live** — es gibt kein Rückgängig und keinen Review davor.
Deshalb vorher den trunk-Stand testinstallieren:

1. ZIP aus dem trunk bauen: `cd /development/svn-bookingtime-appointment/trunk && zip -r /tmp/bookingtime-appointment.zip . -x '.svn/*'`
2. Im cms-environment (`wordpress/v7`) über *Plugins → Installieren → Plugin hochladen*
   einspielen und Backend + Shortcode/Block im Frontend prüfen.
   Wichtig: Bei Installationen von wordpress.org heißt der Plugin-Ordner
   `bookingtime-appointment/`, nicht `bt_appointment/` — der Test sollte das nachstellen,
   damit hartcodierte Pfade auffallen.
3. Optional: das offizielle **Plugin Check**-Plugin (wp.org-Review-Kriterien) laufen lassen.

## Schritt 6: Tag anlegen und committen (= Veröffentlichung)

```bash
cd /development/svn-bookingtime-appointment
svn copy trunk tags/<version>
svn commit -m "Release <version>" --username bookingtime
```

Ein Commit reicht für trunk + tag. Sobald `tags/<version>` existiert und
`trunk/README.txt` per `Stable tag:` darauf zeigt, baut wordpress.org daraus das neue
Download-ZIP.

## Schritt 7: Verifizieren

- Ein paar Minuten warten (Verzeichnis-Cache), dann
  https://wordpress.org/plugins/bookingtime-appointment/ prüfen:
  neue Versionsnummer, aktualisiertes "Tested up to", Warnbanner verschwunden.
- Download-ZIP ziehen und stichprobenartig prüfen (Version im Plugin-Header,
  `blocks/build/` und `assets/` enthalten).
- In einer bestehenden Installation muss unter *Dashboard → Aktualisierungen* das
  Update angeboten werden.
