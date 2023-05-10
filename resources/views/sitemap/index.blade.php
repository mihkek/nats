<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('/sitemap/pages') }}</loc>
        <lastmod>{{ $tender->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/tenders') }}</loc>
        <lastmod>{{ $tender->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/sales') }}</loc>
        <lastmod>{{ $sale->updated_at->toAtomString() }}</lastmod>
    </sitemap>    
    <sitemap>
        <loc>{{ url('sitemap/news') }}</loc>
        <lastmod>{{ $news->created_at }}</lastmod>
    </sitemap>        
</sitemapindex>