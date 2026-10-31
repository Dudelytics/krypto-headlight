# Headlight-Lesestatistik – Einbindung aktiv seit 31.10.2026

Axel hat die Website-ID 1a820d9a-8f11-44fc-acc3-4d289b29587a bereitgestellt. Die Einbindung ist auf main aktiviert; Pages-Deployment 41186946225 war erfolgreich. Datenschutzinformationen stehen unter /lesestatistik/. Die Kontoregion wurde nicht eingesehen; die Hinweise versprechen daher keine ausschließliche EU-Verarbeitung. Es wurde kein kostenpflichtiger Tarif gebucht. Keine Schlüssel ins Repository.

Messung ist pro Seitenaufruf freiwillig: vor Zustimmung keine Anbieteranfrage. DNT/GPC verhindern Aktivierung. Keine Cookies, Local-Storage-IDs, individuellen Nutzerkennungen, Suchparameter, Fragmente oder vollständigen Referrer werden von unserem Code übermittelt. Umami verarbeitet technisch Verbindungsdaten; keine pauschale Behauptung vollständiger Anonymität.

Ein Aufruf, aktive Zeitstufen 30/120/300 Sekunden (sichtbar, fokussiert, letzte Interaktion höchstens 60 Sekunden), Texttiefe 25/50/75/90 Prozent und einmalige Quellen-/Diskussionsklicks. Stufen sind Schwellen, keine exakte durchschnittliche Lesezeit. Scrollen beweist kein Lesen. Wiederladen kann mehrfach zählen. Ablehnung, Blocker und frühes Verlassen fehlen; keine Hochrechnung auf sämtliche Besucher. Keine vollständigen Linkziele, Formulare oder Inhalte übertragen.

Test: node tests/analytics.cjs. Nach Aktivierung separat E2E: vor Zustimmung null Umami-Requests; danach im Network und privaten Dashboard korrekten Seitenpfad und Events bestätigen; Widerruf und Hintergrundtab testen. Eigene Testbesuche im Bericht ausweisen. Kein erfolgreicher Empfang behauptet, solange kein echtes Konto vorliegt.

Hobby hat laut Anbieter kein API/MCP-Zugriffsrecht: erste Auswertung im Dashboard oder mit Export, kein bezahltes Abo automatisch abschließen. Regelmäßig exportieren, da Aufbewahrung begrenzt.

## Verifizierter Stand

Live-Seite /ausgaben/2026-10-31/: vor Zustimmung nur lokales Analytics-Skript im DOM; nach Zustimmung sichtbarer Aktivstatus; Ausschalten stellt den Status zurück. Lokale Tests für Zustimmung, bereinigte Nutzlast, einmalige Schwellen, Hintergrundtab, Widerruf und DNT bestanden. Ein vollständiger Nachweis der Speicherung im privaten Umami-Dashboard steht aus. Ein synthetischer integration_test auf /__analytics-test__/ erhielt HTTP 200; dies wird ausdrücklich nicht als Speichernachweis gewertet. Zusätzlich wurde ein Browser-Testbesuch auf der Ausgabe durchgeführt; eigene Tests bei Auswertungen berücksichtigen.

Die Hauptseite auf Strato ist noch nicht umgestellt. Der aktuelle Pfadfilter ist für Headlight ausgelegt; für andere öffentliche Seiten muss er vor dem Einbau erweitert werden. Persönliche App-Bereiche bleiben ausgeschlossen.
