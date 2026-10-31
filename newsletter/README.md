# Headlight E-Mail-Abo
Stand: 31.10.2026. Brevo eingerichtet; öffentlicher Website-CTA noch deaktiviert bis zum vollständigen Test.

## Verifiziert
- Versanddomain news.dudelytics.com bei Brevo authentifiziert; bestehende DNS-Einträge erhalten.
- Verifizierter Absender Dude · Dudelytics <headlight@news.dudelytics.com>.
- DOI-Vorlage #4 aktiv, deutscher Inhalt und Betreff, unveränderter Brevo-Platzhalter {{ doubleoptin }}. Antwortadresse webmaster@dudelytics.com gesetzt.
- Liste Krypto-Headlight (#3); keine Bestandskontakte importiert.
- Deutsches Formular mit Pflicht-Einwilligung ohne Vorauswahl, Double-Opt-in, deutscher Rückmeldung und Datenschutzlink.
- Öffentliche Formularansicht geprüft. Datenschutzhinweis live unter /lesestatistik/.
- Signup-URL in docs/_config.yml; Abo-Komponente an Startseite und Artikeln vorbereitet, enabled=false.

## Vor Freischaltung noch prüfen
1. Empfang der DOI-Mail und erfolgreiche Bestätigung am 31.10.2026 durch Axels Screenshots belegt. Noch im Brevo-Konto prüfen: genau ein aktiver Kontakt, korrekte Listenzuordnung.
2. Doppelte Anmeldung und Abmeldung anhand einer autorisierten Testmail; weitere Zustellung muss unterdrückt werden.
3. Personenbezogenes Öffnungs-/Klicktracking für Newsletter deaktivieren und Versandvorlage mit Abmeldelink prüfen. UTM-Tracking der DOI-Vorlage ist aus; das belegt nicht sämtliche Tracking-Einstellungen.
4. Zusätzlicher CAPTCHA-Schutz noch nicht eingerichtet. Brevo empfiehlt ihn; DOI ist bereits aktiv.
5. Erst nach bestandenen Tests enabled=true setzen und Live-CTA prüfen.

## Deutsche Abschlussseite
Vorbereitet unter /abo/bestaetigt/. In Brevo beim Formular unter Settings die Option „Confirmation page after clicking on the validation link in the email“ aktivieren und https://headlight.dudelytics.com/abo/bestaetigt/ hinterlegen. Noch nicht im Brevo-Konto verbunden. Nur nach erfolgreicher DOI-Bestätigung weiterleiten, nicht unmittelbar nach Formulareingabe.

## Versandregeln
Nur nach Axels Freigabe der jeweiligen Ausgabe. Kein automatischer Versand allein durch Änderungen am Feed. Nur bestätigte, nicht abgemeldete Empfänger. Jede Mail enthält Abmeldelink und Absenderangaben. Kontakte, Einwilligungsnachweise und Secrets niemals im öffentlichen Repository speichern. Keine kostenpflichtigen Upgrades ohne Freigabe.

Die automatisch erstellten Morgen- und Abendbriefings des Mitgliederbereichs werden separat migriert; sie wurden hier nicht verändert.
