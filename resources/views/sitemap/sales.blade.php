<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($tenders as $tender)
        <url>
            <loc>{{url("/sales")}}/{{ $tender->id }}-{{ $tender->slug }}</loc>
            <lastmod>{{ $tender->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>