<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">   
        <url>
            <loc>{{url("/")}}</loc>
            <lastmod></lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{url("/about_service")}}</loc>
            <lastmod></lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{url("/tenders")}}</loc>
            <lastmod>{{ $tender->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{url("/sales")}}</loc>
            <lastmod>{{ $sale->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{url("/news")}}</loc>
            <lastmod>{{ $news->created_at }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
</urlset>