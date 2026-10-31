# Headlight E-Mail-Abo — Vorbereitung, noch nicht aktiv
Stand: 31.10.2026. Anbieterentscheidung Axel: Brevo, kostenloser Einstieg.
Branch: newsletter/brevo-setup-20261031. Keine Adressen erfasst, keine Mail versendet.

## Einrichtung im Konto
1. Axel eröffnet/bestätigt das Brevo-Konto und akzeptiert die Vertragsbedingungen selbst.
2. Absenderadresse unter dudelytics.com mit Axel bestimmen und verifizieren; vorhandene Adresse nicht ohne Verifikation als Absender einsetzen.
3. Versanddomain anhand der von Brevo tatsächlich gelieferten DNS-Einträge authentifizieren. Vorhandene MX/SPF/DMARC-Einträge erhalten; keine geratenen Schlüssel oder doppelten SPF-Records.
4. Liste „Krypto-Headlight“ anlegen. Keine Bestandskontakte ohne Abo-Bestätigung importieren.
5. Brevo-Anmeldeformular: nur E-Mail, deutsche Texte, Double-Opt-in, Missbrauchsschutz und Datenschutzhinweis. Erst bestätigte Kontakte in die Versandliste aufnehmen.
6. DOI-Vorlage mit dem von Brevo vorgeschriebenen Bestätigungslink konfigurieren. Platzhalter in newsletter/TEXTE.md sind redaktionell, keine fertige Brevo-Template-Syntax.
7. Anbieterangaben/Auftragsverarbeitung und konkrete Verarbeitung für den Newsletter in der Datenschutzerklärung ergänzen. Keine pauschale Aussage „keine personenbezogenen Daten“ für E-Mail-Abos.
8. Öffentliches HTTPS-Formular prüfen, URL in headlight_newsletter.signup_url eintragen; enabled erst nach erfolgreichem Test aktivieren.
9. Ein echter Test mit Axels freigegebener Testadresse: Anmeldung → ausstehend → Bestätigung → genau eine aktive Anmeldung → Testausgabe → Abmeldung → weitere Zustellung unterdrückt. Doppelte Anmeldung prüfen.
10. Erst dann den vorbereiteten Abo-Bereich veröffentlichen. Die Hauptseite kann auf das verifizierte Formular oder den Headlight-Abo-Bereich verlinken.

## Versand
- Nur nach Axels ausdrücklicher Freigabe der jeweiligen Ausgabe.
- Entwurf und Vorschau erstellen, Veröffentlichungs-URL prüfen, erst dann Versand.
- Ausschließlich bestätigte und nicht abgemeldete Empfänger der Liste.
- Keine unkontrollierte RSS-Automatik: Korrekturen oder Feed-Neubauten dürfen keinen Doppelversand auslösen.
- Pro Ausgabe Versandstatus/Kampagnen-ID privat dokumentieren; erneuter Versuch nach unklarem Ergebnis zuerst Status prüfen.
- Abmeldelink und Absender/Impressumsangaben in jeder Mail.
- Personenbezogenes Öffnungs-/Klicktracking zunächst deaktivieren.
- Adressen, Einwilligungsnachweise, API-Schlüssel und Zugangsdaten niemals in dieses öffentliche Repository.
- Free-Tarif: 300 E-Mail-Versendungen täglich laut Brevo (31.10.2026); Bestätigungsmails beanspruchen ebenfalls Versandkontingent. Vor Überschreitung planen, keinen kostenpflichtigen Tarif ohne Axel buchen.

## Referenzen
https://help.brevo.com/hc/en-us/articles/208580669-FAQs-What-are-the-limits-of-the-Free-plan
https://help.brevo.com/hc/en-us/articles/208771869-Create-a-sign-up-form-in-Brevo
