<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Hafif Markdown -> HTML dönüştürücü (başlık, liste, kalın, italik,
 * link, kod, paragraf ve içindekiler için başlık id'leri).
 */
class Markdown
{
    protected static array $headings = [];

    public static function toHtml(string $md): string
    {
        static::$headings = [];
        $md = str_replace(["\r\n", "\r"], "\n", $md);
        $lines = explode("\n", $md);
        $html = '';
        $inList = false;
        $inOrdered = false;
        $inCode = false;

        $closeList = function () use (&$html, &$inList, &$inOrdered) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            if ($inOrdered) { $html .= "</ol>\n"; $inOrdered = false; }
        };

        $tableRows = [];
        $tableSeparatorSeen = false;
        $flushTable = function () use (&$html, &$tableRows, &$tableSeparatorSeen) {
            if ($tableRows) {
                $html .= static::renderTable($tableRows, $tableSeparatorSeen);
                $tableRows = [];
                $tableSeparatorSeen = false;
            }
        };

        foreach ($lines as $line) {
            $trim = trim($line);

            if (str_starts_with($trim, '```')) {
                $flushTable();
                if ($inCode) { $html .= "</code></pre>\n"; $inCode = false; }
                else { $closeList(); $html .= "<pre><code>"; $inCode = true; }
                continue;
            }
            if ($inCode) { $html .= e($line) . "\n"; continue; }

            // Tablo satırı: | Hücre | Hücre |
            if (str_starts_with($trim, '|') && substr_count($trim, '|') >= 2) {
                $closeList();
                if (preg_match('/^\|[\s:\-|]+\|$/', $trim)) {
                    $tableSeparatorSeen = true;
                    continue;
                }
                $tableRows[] = array_map('trim', explode('|', trim($trim, '|')));
                continue;
            }
            $flushTable();

            if ($trim === '') { $closeList(); continue; }

            if (preg_match('/^(#{1,4})\s+(.*)$/', $trim, $m)) {
                $closeList();
                $level = strlen($m[1]);
                $text = static::inline($m[2]);
                $id = slugify(strip_tags($m[2]));
                static::$headings[] = ['level' => $level, 'text' => strip_tags($text), 'id' => $id];
                $html .= "<h{$level} id=\"{$id}\">{$text}</h{$level}>\n";
                continue;
            }

            if (preg_match('/^[-*+]\s+(.*)$/', $trim, $m)) {
                if (!$inList) { $closeList(); $html .= "<ul>\n"; $inList = true; }
                $html .= '<li>' . static::inline($m[1]) . "</li>\n";
                continue;
            }
            if (preg_match('/^\d+\.\s+(.*)$/', $trim, $m)) {
                if (!$inOrdered) { $closeList(); $html .= "<ol>\n"; $inOrdered = true; }
                $html .= '<li>' . static::inline($m[1]) . "</li>\n";
                continue;
            }
            if (preg_match('/^>\s?(.*)$/', $trim, $m)) {
                $closeList();
                $html .= '<blockquote>' . static::inline($m[1]) . "</blockquote>\n";
                continue;
            }

            // Tek başına görsel satırı -> figure
            if (preg_match('/^!\[(.*?)\]\((\S+?)(?:\s+"(.*?)")?\)$/', $trim, $m)) {
                $closeList();
                $alt = e($m[1]);
                $src = e($m[2]);
                $ttl = e($m[3] ?? '');
                $html .= '<figure><img src="' . $src . '" alt="' . $alt . '"' . ($ttl !== '' ? ' title="' . $ttl . '"' : '') . ' loading="lazy"></figure>' . "\n";
                continue;
            }

            $closeList();
            $html .= '<p>' . static::inline($trim) . "</p>\n";
        }
        $flushTable();
        if ($inCode) { $html .= "</code></pre>\n"; }
        $closeList();

        return $html;
    }

    protected static function renderTable(array $rows, bool $hasHeader): string
    {
        $html = "<div class=\"table-wrap\"><table>\n";
        foreach ($rows as $i => $cells) {
            $tag = ($hasHeader && $i === 0) ? 'th' : 'td';
            $html .= '<tr>';
            foreach ($cells as $cell) {
                $html .= "<$tag>" . static::inline($cell) . "</$tag>";
            }
            $html .= "</tr>\n";
        }
        return $html . "</table></div>\n";
    }

    public static function headings(): array
    {
        return static::$headings;
    }

    protected static function inline(string $text): string
    {
        $text = e($text);
        // Görsel: ![alt](url "title") — linklerden ÖNCE işlenmeli
        $text = preg_replace_callback('/!\[(.*?)\]\((\S+?)(?:\s+&quot;(.*?)&quot;)?\)/', function ($m) {
            $ttl = $m[3] ?? '';
            return '<img src="' . $m[2] . '" alt="' . $m[1] . '"' . ($ttl !== '' ? ' title="' . $ttl . '"' : '') . ' loading="lazy">';
        }, $text);
        $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
        $text = preg_replace('/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s', '<em>$1</em>', $text);
        $text = preg_replace('/`(.+?)`/s', '<code>$1</code>', $text);
        $text = preg_replace_callback('/\[(.+?)\]\((.+?)\)/', function ($m) {
            $url = $m[2];
            $ext = preg_match('#^https?://#', $url) ? ' target="_blank" rel="noopener"' : '';
            return '<a href="' . $url . '"' . $ext . '>' . $m[1] . '</a>';
        }, $text);
        return $text;
    }
}
