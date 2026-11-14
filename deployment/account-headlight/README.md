# Bilingual account reader

Target: `/dudelytics-app/headlight/index.php` on STRATO. This is the authenticated account reader, separate from the older public redirect in `deployment/headlight/`.

English route: `/headlight/?page=en%2F`; default follows the account interface language. The explicit `?page=` route selects German even when the surrounding account interface is English. The current edition, archive, about page, charts and language switch are imported from the public Headlight site. Translation links come from the public renderer, so future editions do not require hard-coded dates in PHP.

Authentication and the account CSP remain in place. Images are served through the authenticated same-origin reader, using only the fixed public Headlight asset origin and validated paths. HTML is sanitised, with safe image dimensions, figure captions, table captions and header scopes retained. The report cache has a five-minute lifetime; the image cache holds one item per published asset, not per visit.

The live pre-English file was downloaded and SHA-256 checked before replacement:
`c117bc83a880ea7ef8a7d515bdab969163b5e476908c0290f473627727432dea`.

Rollback: restore that verified pre-English account file. Revert the bilingual website commit separately if required. Do not overwrite the authenticated account reader with the public redirect component.

Validation: PHP syntax check and routing, sanitisation, image, language-navigation and accessibility regression checks. Public and account rendering must also be checked after the Pages build succeeds.
