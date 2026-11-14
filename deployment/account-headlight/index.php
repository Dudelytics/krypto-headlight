<?php
declare(strict_types=1);
define('DUDE_PAGE_EXTRA_CSS', '/assets/css/headlight-r1.css?v=20261010-r1');
require dirname(__DIR__, 2) . '/private/dudelytics-app/page.php';
$user = dude_require_user();
$english = dude_page_language() !== 'de';
if (session_status() === PHP_SESSION_ACTIVE) session_write_close();

function hl_escape(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function hl_route(string $path): ?string {
    if (in_array($path, ['', 'archiv/', 'ueber/', 'en/', 'en/archive/', 'en/about/', 'en/privacy/'], true)) return $path;
    if (preg_match('~^(?:ausgaben|en/editions)/\d{4}-\d{2}-\d{2}/$~D', $path)) return $path;
    return null;
}
function hl_link(string $href): ?array {
    if (str_starts_with($href, '#')) return [$href, false];
    $u = parse_url($href);
    if ($u === false || isset($u['user']) || isset($u['pass'])) return null;
    $host = strtolower((string)($u['host'] ?? ''));
    $path = (string)($u['path'] ?? '');
    if ($host === 'dudelytics.github.io' || $host === 'headlight.dudelytics.com' || ($host === '' && (str_starts_with($path, '/krypto-headlight/') || str_starts_with($path, '/')))) {
        if ($host === 'dudelytics.github.io' && !str_starts_with($path, '/krypto-headlight/')) return null;
        $rel = str_starts_with($path, '/krypto-headlight/') ? substr($path, strlen('/krypto-headlight/')) : ltrim($path, '/');
        if (hl_route($rel) !== null) return [dude_page_href('/headlight/' . ('?page=' . rawurlencode($rel))) . (isset($u['fragment']) ? '#' . rawurlencode($u['fragment']) : ''), false];
        if (($u['scheme'] ?? '') === 'https') return [$href, true];
        return null;
    }
    if (($u['scheme'] ?? '') === 'https' && $host !== '') return [$href, true];
    return null;
}
function hl_image(DOMElement $node): string {
    $src = $node->getAttribute('src');
    if (str_starts_with($src, '/assets/images/')) $src = 'https://headlight.dudelytics.com'.$src;
    $u = parse_url($src);
    if ($u === false || ($u['scheme'] ?? '') !== 'https' || strtolower((string)($u['host'] ?? '')) !== 'headlight.dudelytics.com') return '';
    if (isset($u['user']) || isset($u['pass']) || isset($u['port']) || isset($u['query']) || isset($u['fragment'])) return '';
    if (!preg_match('~^/assets/images/(?:headlight-masthead(?:-en)?\.webp|[0-9]{4}-[0-9]{2}-[0-9]{2}/[a-zA-Z0-9_-]+\.(?:svg|png|webp|jpe?g))$~D', (string)($u['path'] ?? ''))) return '';
    $local = dude_page_href('/headlight/?image='.rawurlencode((string)$u['path']));
    $dimensions = '';
    foreach (['width','height'] as $dimension) {
        $value = $node->getAttribute($dimension);
        if (preg_match('/^[1-9][0-9]{0,3}$/D', $value) && (int)$value <= 6000) $dimensions .= ' '.$dimension.'="'.$value.'"';
    }
    return '<img src="'.hl_escape($local).'" alt="'.hl_escape($node->getAttribute('alt')).'"'.$dimensions.' loading="lazy" decoding="async" style="display:block;width:100%;height:auto">';
}
function hl_node(DOMNode $node): string {
    if ($node instanceof DOMText) return htmlspecialchars($node->textContent, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    if (!($node instanceof DOMElement)) return '';
    $tag = strtolower($node->tagName);
    if ($tag === 'img') return hl_image($node);
    if (in_array($tag, ['script','style','iframe','object','embed','form','input','button','svg','math','img','link','meta'], true)) return '';
    $body = ''; foreach ($node->childNodes as $child) $body .= hl_node($child);
    if (!in_array($tag, ['article','section','div','p','h1','h2','h3','h4','h5','h6','ul','ol','li','dl','dt','dd','strong','em','b','i','blockquote','pre','code','a','table','thead','tbody','tr','th','td','caption','br','hr','time','span','details','summary','figure','figcaption','nav'], true)) return $body;
    $attrs = '';
    if (in_array($node->getAttribute('lang'), ['de','en'], true)) $attrs .= ' lang="'.hl_escape($node->getAttribute('lang')).'"';
    if ($tag === 'nav' && in_array('language-switch', preg_split('/\s+/', $node->getAttribute('class')), true)) $attrs .= ' class="hl-tabs" aria-label="Language / Sprache"';
    if ($node->getAttribute('aria-current') === 'page') $attrs .= ' aria-current="page"';
    if ($tag === 'th' && in_array($node->getAttribute('scope'), ['col','row','colgroup','rowgroup'], true)) $attrs .= ' scope="'.hl_escape($node->getAttribute('scope')).'"';
    if ($tag === 'caption') $attrs .= ' style="text-align:left;font-size:14px;line-height:1.5;padding-bottom:10px"';
    if ($tag === 'figure') $attrs .= ' style="margin:28px 0"';
    if ($tag === 'figcaption') $attrs .= ' style="font-size:14px;line-height:1.5;margin-top:8px"';
    if ($tag === 'div' && in_array('source-notes', preg_split('/\s+/', $node->getAttribute('class')), true)) $attrs .= ' class="source-notes" style="font-size:14px;line-height:1.55;margin-top:40px;padding-top:16px;border-top:1px solid #C7BDB4"';
    if ($node->hasAttribute('id') && preg_match('/^[a-zA-Z][a-zA-Z0-9_-]{0,100}$/D', $node->getAttribute('id'))) $attrs .= ' id="'.htmlspecialchars($node->getAttribute('id'), ENT_QUOTES, 'UTF-8').'"';
    if ($tag === 'a') {
        $link = hl_link($node->getAttribute('href'));
        if ($link === null) return $body;
        $attrs .= ' href="'.htmlspecialchars($link[0], ENT_QUOTES, 'UTF-8').'"';
        if ($link[1]) $attrs .= ' target="_blank" rel="noopener noreferrer"';
    }
    return '<'.$tag.$attrs.'>'.(in_array($tag,['br','hr'],true) ? '' : $body.'</'.$tag.'>');
}
function hl_html(string $raw): string {
    $previous = libxml_use_internal_errors(true);
    try {
        $dom = new DOMDocument();
        if (!$dom->loadHTML('<?xml encoding="UTF-8">'.$raw, LIBXML_NONET)) throw new RuntimeException('HTML konnte nicht gelesen werden.');
        $main = $dom->getElementsByTagName('main')->item(0);
        if (!$main) throw new RuntimeException('Headlight-Inhalt fehlt.');
        $html='';
        foreach ($dom->getElementsByTagName('nav') as $nav) {
            if (in_array('language-switch', preg_split('/\s+/', $nav->getAttribute('class')), true)) { $html .= hl_node($nav); break; }
        }
        foreach ($main->childNodes as $child) $html .= hl_node($child);
        if (trim(strip_tags($html)) === '') throw new RuntimeException('Headlight-Inhalt ist leer.');
        return $html;
    } finally { libxml_clear_errors(); libxml_use_internal_errors($previous); }
}
function hl_fetch(string $path): string {
    if (hl_route($path) === null) throw new RuntimeException('Unzulässiger Berichtspfad.');
    $legacy = 'https://dudelytics.github.io/krypto-headlight/'.$path;
    $canonical = 'https://headlight.dudelytics.com/'.$path;
    $url = $canonical;
    for ($attempt=0; $attempt<2; $attempt++) {
        $ch = curl_init($url); $data='';
        curl_setopt_array($ch,[CURLOPT_CONNECTTIMEOUT=>12,CURLOPT_TIMEOUT=>20,CURLOPT_FOLLOWLOCATION=>false,CURLOPT_PROTOCOLS=>CURLPROTO_HTTPS,CURLOPT_SSL_VERIFYPEER=>true,CURLOPT_SSL_VERIFYHOST=>2,CURLOPT_USERAGENT=>'Dudelytics-Headlight-Reader/3.0',CURLOPT_WRITEFUNCTION=>static function($c,string $chunk) use (&$data): int { if (strlen($data)+strlen($chunk)>2000000) return 0; $data.=$chunk; return strlen($chunk); }]);
        $ok=curl_exec($ch);$status=(int)curl_getinfo($ch,CURLINFO_HTTP_CODE);$next=(string)curl_getinfo($ch,CURLINFO_REDIRECT_URL);curl_close($ch);
        if ($ok!==false && $status===200) return hl_html($data);
        if ($url===$legacy && $ok!==false && in_array($status,[301,302,303,307,308],true) && $next===$canonical) { $url=$canonical; continue; }
        throw new RuntimeException('Headlight ist derzeit nicht erreichbar.');
    }
    throw new RuntimeException('Headlight ist derzeit nicht erreichbar.');
}

// Serve only public Headlight artwork through the authenticated same-origin reader.
// One cache entry per published asset; never one file per page view.
if (isset($_GET['image'])) {
    $asset = is_string($_GET['image']) ? $_GET['image'] : '';
    if (!preg_match('~^/assets/images/(?:headlight-masthead(?:-en)?\.webp|[0-9]{4}-[0-9]{2}-[0-9]{2}/[a-zA-Z0-9_-]+\.(?:svg|png|webp|jpe?g))$~D', $asset)) {
        http_response_code(404); exit;
    }
    $ext = strtolower(pathinfo($asset, PATHINFO_EXTENSION));
    $types = ['webp'=>'image/webp','png'=>'image/png','svg'=>'image/svg+xml','jpg'=>'image/jpeg','jpeg'=>'image/jpeg'];
    $dir = dirname(__DIR__,2).'/private/dudelytics-app/headlight-image-cache-r1';
    $file = $dir.'/'.hash('sha256',$asset).'.'.$ext;
    $bytes = is_file($file) && time()-(int)filemtime($file)<3600 ? @file_get_contents($file) : false;
    if ($bytes === false && function_exists('curl_init')) {
        $ch = curl_init('https://headlight.dudelytics.com'.$asset); $data = '';
        curl_setopt_array($ch,[CURLOPT_CONNECTTIMEOUT=>8,CURLOPT_TIMEOUT=>15,CURLOPT_FOLLOWLOCATION=>false,CURLOPT_PROTOCOLS=>CURLPROTO_HTTPS,CURLOPT_SSL_VERIFYPEER=>true,CURLOPT_SSL_VERIFYHOST=>2,CURLOPT_USERAGENT=>'Dudelytics-Headlight-Artwork/1.0',CURLOPT_WRITEFUNCTION=>static function($c,string $chunk) use (&$data): int { if (strlen($data)+strlen($chunk)>2000000) return 0; $data.=$chunk; return strlen($chunk); }]);
        $ok=curl_exec($ch); $code=(int)curl_getinfo($ch,CURLINFO_HTTP_CODE); $type=strtolower(trim(explode(';',(string)curl_getinfo($ch,CURLINFO_CONTENT_TYPE))[0])); curl_close($ch);
        if ($ok!==false && $code===200 && $type===$types[$ext] && $data!=='') {
            $bytes = $data;
            if (!is_dir($dir)) @mkdir($dir,0700,true);
            if (is_dir($dir) && is_writable($dir)) {
                $tmp=@tempnam($dir,'.img-');
                if ($tmp!==false) { if (@file_put_contents($tmp,$bytes)!==false) { @chmod($tmp,0600); @rename($tmp,$file); } if (is_file($tmp)) @unlink($tmp); }
            }
        }
    }
    if ($bytes===false && is_file($file)) $bytes=@file_get_contents($file);
    if ($bytes===false || $bytes==='') { http_response_code(502); exit; }
    header('Content-Type: '.$types[$ext]);
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, max-age=300');
    echo $bytes; exit;
}

$page = is_string($_GET['page'] ?? null) ? $_GET['page'] : ($english ? 'en/' : '');
$readerEnglish = str_starts_with($page, 'en/');
if (hl_route($page) === null) { http_response_code(404); $page=null; }
$html=''; $error=''; $stale=false; $fetchedAt=null;
if ($page === null) $error='Diese Ausgabe ist nicht verfügbar.';
else {
    $cacheDir=dirname(__DIR__,2).'/private/dudelytics-app/headlight-cache-r7';
    $cachePath=$cacheDir.'/'.hash('sha256',$page).'.json';
    $cached = is_file($cachePath) ? json_decode((string)@file_get_contents($cachePath),true) : null;
    if (!is_array($cached) || !is_string($cached['html'] ?? null) || !is_int($cached['at'] ?? null)) $cached=null;
    if ($cached && time()-$cached['at']<300) { $html=$cached['html']; $fetchedAt=$cached['at']; }
    else {
        try {
            if (!function_exists('curl_init') || !class_exists('DOMDocument')) throw new RuntimeException('Der Headlight-Reader benötigt cURL und DOM.');
            $html=hl_fetch($page);$fetchedAt=time();
            if (!is_dir($cacheDir)) @mkdir($cacheDir,0700,true);
            if (is_dir($cacheDir) && is_writable($cacheDir)) {
                $temp=@tempnam($cacheDir,'.hl-');
                if ($temp !== false) { if (@file_put_contents($temp,json_encode(['html'=>$html,'at'=>$fetchedAt],JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR))!==false) { @chmod($temp,0600); @rename($temp,$cachePath); } if (is_file($temp)) @unlink($temp); }
            }
        } catch (Throwable $e) {
            if ($cached) { $html=$cached['html'];$fetchedAt=$cached['at'];$stale=true; }
            else $error=$readerEnglish?'Headlight cannot be loaded right now. Please try again later.':'Headlight kann gerade nicht geladen werden. Bitte später erneut versuchen.';
        }
    }
}
dude_page_start($readerEnglish ? 'Crypto-Headlight' : 'Krypto-Headlight', $readerEnglish ? 'The weekly briefing · directly in your account' : 'Die Wochenlage · direkt im Account');
?>
<div id="hl-account" lang="<?= $readerEnglish ? 'en' : 'de' ?>">
<div class="hl-masthead" style="margin:0 0 24px;background:#070605"><img src="<?= hl_escape(dude_page_href('/headlight/?image='.rawurlencode('/assets/images/headlight-masthead'.($readerEnglish?'-en':'').'.webp'))) ?>" width="2172" height="724" alt="<?= $readerEnglish?'Dudelytics Crypto-Headlight – The weekly briefing on the productive crypto market':'Dudelytics Krypto-Headlight – Die Wochenlage des produktiven Kryptomarkts' ?>" fetchpriority="high" decoding="async" style="display:block;width:100%;height:auto"></div>
<nav class="hl-tabs" aria-label="Headlight">
<a href="<?= hl_escape(dude_page_href('/headlight/?page='.($readerEnglish?'en%2F':''))) ?>"<?= in_array($page,['','en/'],true)?' aria-current="page"':'' ?>><?= $readerEnglish?'Latest':'Aktuell' ?></a>
<a href="<?= hl_escape(dude_page_href('/headlight/?page='.($readerEnglish?'en%2Farchive%2F':'archiv%2F'))) ?>"<?= in_array($page,['archiv/','en/archive/'],true)?' aria-current="page"':'' ?>><?= $readerEnglish?'Archive':'Archiv' ?></a>
<a href="<?= hl_escape(dude_page_href('/headlight/?page='.($readerEnglish?'en%2Fabout%2F':'ueber%2F'))) ?>"<?= in_array($page,['ueber/','en/about/'],true)?' aria-current="page"':'' ?>><?= $readerEnglish?'About':'Über den Bericht' ?></a>
</nav>
<?php if ($stale): ?><div class="auth-alert bad" role="status"><?= $readerEnglish?'Retrieval is temporarily unavailable. Showing the last saved version.':'Der Abruf ist momentan gestört. Angezeigt wird die zuletzt gespeicherte Fassung.' ?></div><?php endif; ?>
<?php if ($error!==''): ?><div class="auth-alert bad" role="alert"><?= hl_escape($error) ?></div><?php else: ?><div class="hl-reader"><?= $html ?></div><?php endif; ?>
<?php if ($fetchedAt): ?><p class="help"><?= $readerEnglish?'Report page retrieved:':'Berichtsseite abgerufen:' ?> <?= hl_escape(gmdate('d.m.Y H:i',$fetchedAt)) ?> UTC. <?= $readerEnglish?'The analysis timestamps are recorded in each edition.':'Die Datenstände der Analyse stehen im jeweiligen Bericht.' ?></p><?php endif; ?>
<p class="help"><?= $readerEnglish?'Editions and archives stay in your account. Sources and GitHub discussions open in a new tab.':'Ausgaben und Archiv bleiben im Account. Quellen und GitHub-Kommentare öffnen in einem neuen Tab.' ?></p>
</div>
<?php dude_page_end(); ?>
