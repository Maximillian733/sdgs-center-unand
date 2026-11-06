<?php

namespace App\Support;

// Sanitasi isi berita (XSS): hanya tag dasar, semua atribut dibuang kecuali href aman.
class Html
{
    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }
        if ($html === strip_tags($html)) { // teks biasa -> paragraf
            return collect(preg_split('/\R{2,}/', $html))
                ->map(fn ($p) => '<p>'.nl2br(e($p)).'</p>')->implode('');
        }
        $html = strip_tags($html, '<p><br><strong><b><em><i><u><ul><ol><li><a><h2><h3><h4><blockquote>');
        $d = new \DOMDocument();
        libxml_use_internal_errors(true);
        $d->loadHTML('<?xml encoding="utf-8"?><div id="r">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $root = $d->getElementById('r');
        foreach ((new \DOMXPath($d))->query('//*[@*]') as $n) {
            foreach (iterator_to_array($n->attributes) as $a) {
                $ok = $n->nodeName === 'a' && $a->name === 'href' && preg_match('#^(https?:|mailto:|/)#i', trim($a->value));
                if (! $ok) {
                    $n->removeAttribute($a->name);
                }
            }
            if ($n->nodeName === 'a') {
                $n->setAttribute('rel', 'noopener noreferrer');
            }
        }
        $out = '';
        foreach ($root->childNodes as $c) {
            $out .= $d->saveHTML($c);
        }
        return $out;
    }
}
