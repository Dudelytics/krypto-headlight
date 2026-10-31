# Headlight E-Mail-Abo
Stand: 31.10.2026. Brevo eingerichtet; öffentlicher Website-CTA auf ausdrückliche Freigabe Axels nach erfolgreichem Empfang und DOI-Klick aktiviert.

## Verifiziert
- Versanddomain news.dudelytics.com bei Brevo authentifiziert; bestehende DNS-Einträge erhalten.
- Verifizierter Absender Dude · Dudelytics <headlight@news.dudelytics.com>.
- DOI-Vorlage #4 aktiv, deutscher Inhalt und Betreff, unveränderter Brevo-Platzhalter {{ doubleoptin }}. Antwortadresse webmaster@dudelytics.com gesetzt.
- Liste Krypto-Headlight (#3); keine Bestandskontakte importiert.
- Deutsches Formular mit Pflicht-Einwilligung ohne Vorauswahl, Double-Opt-in, deutscher Rückmeldung und Datenschutzlink.
- Öffentliche Formularansicht geprüft. Datenschutzhinweis live unter /lesestatistik/.
- Signup-URL in docs/_config.yml; Abo-Komponente an Startseite und Artikeln aktiviert, enabled=true.

## Offene Nachprüfungen
1. Empfang der DOI-Mail und erfolgreiche Bestätigung am 31.10.2026 durch Axels Screenshots belegt. Im Brevo-Konto geprüft: genau ein Kontakt in Liste #3, E-Mail abonniert, keine Blocklist-Markierung.
2. Doppelte Anmeldung und Abmeldung anhand einer autorisierten Testmail; weitere Zustellung muss unterdrückt werden.
3. Personenbezogenes Öffnungs-/Klicktracking für Newsletter deaktivieren und Versandvorlage mit Abmeldelink prüfen. UTM-Tracking der DOI-Vorlage ist aus; das belegt nicht sämtliche Tracking-Einstellungen.
4. Zusätzlicher CAPTCHA-Schutz noch nicht eingerichtet. Brevo empfiehlt ihn; DOI ist bereits aktiv.
5. Freischaltung ausdrücklich von Axel autorisiert; offene Nachprüfungen bleiben dokumentiert.

## Deutsche Abschlussseite
Unter /abo/bestaetigt/ bereitgestellt. In Brevo gespeichert und nach erneutem Öffnen verifiziert: „Confirmation page after clicking on the validation link in the email“ aktiv, Ziel https://headlight.dudelytics.com/abo/bestaetigt/. Weiterleitung unmittelbar nach Formulareingabe bleibt aus; Double-Opt-in unverändert aktiv.

## Versandregeln
Nur nach Axels Freigabe der jeweiligen Ausgabe. Kein automatischer Versand allein durch Änderungen am Feed. Nur bestätigte, nicht abgemeldete Empfänger. Jede Mail enthält Abmeldelink und Absenderangaben. Kontakte, Einwilligungsnachweise und Secrets niemals im öffentlichen Repository speichern. Keine kostenpflichtigen Upgrades ohne Freigabe.

Die automatisch erstellten Morgen- und Abendbriefings des Mitgliederbereichs werden separat migriert; sie wurden hier nicht verändert.

## Wiederverwendbare Versandvorlage
Brevo-Vorlage #5: „Krypto-Headlight – Neue Ausgabe (Versandvorlage)“, gespeichert und aktiv. Beige/Terracotta-Design, deutsch, Absender headlight@news.dudelytics.com, Name Dude · Dudelytics, Reply-to webmaster@dudelytics.com. UTM-Tracking aus. Native Abmeldung über `{{ unsubscribe }}`, Datenschutz und öffentliche Absenderangaben enthalten. Desktop-/Empfängervorschau geprüft. Die Vorschau liefert keinen echten Abmeldetoken; ein vollständiger Abmelde- und Unterdrückungstest ist noch offen. Es wurde keine Testmail und keine Kampagne versendet.

Vor jeder Ausgabe: Vorlage in einer E-Mail-Kampagne verwenden, individuellen Teaser und Betreff einsetzen, Button auf die dauerhafte URL der konkreten Ausgabe ändern (Vorlage verweist auf die Startseite), ausschließlich bestätigte/nicht gesperrte Empfänger der Liste #3 auswählen, Tracking-Einstellungen prüfen, Test und Freigabe, danach einmalig versenden. Aktivierung der Vorlage ist keine Versandautomatisierung.
