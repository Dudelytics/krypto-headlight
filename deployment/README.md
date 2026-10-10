# STRATO integration — prepared, NOT installed
Status: 2026-10-10. GitHub Pages is live at https://dudelytics.github.io/krypto-headlight/.
The runtime failed before STRATO navigation: native credential state cannot be safely resumed.
No STRATO upload, source modification, or DNS change has been performed.

## Intended scope
1. Add a stable /headlight/ entry on the existing public Dudelytics site.
2. Add the supplied card to the German Research Hub.
3. Add a Krypto-Headlight link to the public menu, preserving the existing language and account behaviour.
4. Enable GitHub Discussions and confirm anonymous reading and account-required commenting.
5. Configure headlight.dudelytics.com after GitHub domain reservation, DNS, and HTTPS verification.

## Files ready for installation
- headlight/index.php: maps to the public webroot /headlight/index.php. Temporary 302 redirect to the currently working GitHub Pages site. No external data requests or dynamic redirect input.
- research-card.html: insert once inside the German Research Hub main element. Uses the existing public site classes and the stable /headlight/ entry.

These are integration components, not an unattended installer. Do not overwrite a live file using them without inspecting the current source.
PHP lint must run before installation; PHP was unavailable in the preparation environment.

## One-session STRATO procedure
Before opening STRATO, retain this package locally and verify the live GitHub Pages target.
Use a genuinely fresh, working browser runtime. If native credential protection blocks initialization, stop and report the runtime error; do not retry old protected tabs.
Use secure browser authentication if required; never request or expose credentials in chat.

In the authenticated session:
- Read the actual public webroot and current Research Hub and shared navigation source.
- Prior history identifies private/site/site.php as a shared public renderer; confirm the current implementation before patching.
- Capture original bytes, SHA-256 hashes, file modes, and a private backup manifest. Verify backups cannot be downloaded publicly.
- Inspect exact insertion anchors and require unique matches; abort on unknown structure, unexpected existing /headlight/ content, or concurrent source changes.
- Add the gateway and card; add one public navigation entry using the existing locale-aware mechanism. Link label: Krypto-Headlight. Do not add another language version or alter auth logic.
- PHP lint all modified PHP sources. Apply atomically with a check of expected original hashes.
- Verify /headlight/ returns 302 to the working Headlight URL; verify the Research Hub and menu link, homepage and EN navigation, stylesheet loading, and no duplicate cards.
- On failure, restore original bytes and modes and remove only newly created files. Verify the previous page responses again.
- Keep a private rollback record. Remove any temporary installer after verified success.

## GitHub address check
The main website and Research Hub are referenced in README and the public Headlight pages.
Repository metadata homepage was null when checked; it is optional and can later point to the live Headlight URL.
The main STRATO domain dudelytics.com must not be entered as the Pages custom domain.

## Custom subdomain sequence
- First reserve headlight.dudelytics.com in GitHub repository Settings > Pages > Custom domain; preferably verify domain ownership with GitHub's TXT record.
- Then add the precise STRATO CNAME: headlight -> dudelytics.github.io (no repository path, no wildcard).
- Keep existing apex, www, mail, and app DNS untouched.
- Check DNS and wait for the certificate; enforce HTTPS when available.
- Change docs/_config.yml to url: https://headlight.dudelytics.com and baseurl: ""; update the /headlight/ redirect target only after the new endpoint works.
- Check canonical, CSS, archive, feed, sitemap, 404, and GitHub's old-URL redirect. Preserve a rollback for both DNS and Pages settings.
- Do not upload a CNAME file alone as a substitute for the Pages custom-domain setting.

## Comments and publishing
GitHub has_discussions was false at the address check. Enable the repository feature using administrative access.
Do not report comments ready before a public discussion and a signed-in comment have been tested.
Weekly drafts are already scheduled for Saturdays from 2026-10-17. Publication remains after Axel's editorial approval.
