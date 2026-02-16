<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function generate()
    {
        $sitemapPath = public_path('sitemap.xml');

        // Buat sitemap baru
        $sitemap = \Spatie\Sitemap\Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'))
            ->add(Url::create('/blog')) // Tambahkan halaman lain yang ada di websitemu
            ->add(Url::create('/services'));

        // Simpan ke file sitemap.xml
        $sitemap->writeToFile($sitemapPath);

        return response()->json(['message' => 'Sitemap berhasil diperbarui!']);
    }
}
