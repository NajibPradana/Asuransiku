<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini digunakan untuk seed gambar-gambar ke GeneralSettings dan SiteSettings
     * Menggunakan direct database update untuk memastikan data disimpan dengan benar
     */
    public function run(): void
    {
        $this->seedGeneralSettings();
        $this->seedSiteSettings();
    }

    /**
     * Seed GeneralSettings dengan logo dan favicon menggunakan direct database update
     */
    private function seedGeneralSettings(): void
    {
        // Brand logo (digunakan untuk normal dan dark mode)
        $brandLogoPath = $this->copyOrDownloadImage(
            'Brand Logo',
            public_path('seeders/brand-logo.png'),
            'sites/brand-logo.png'
        );

        // Brand logo square
        $brandLogoSquarePath = $this->copyOrDownloadImage(
            'Brand Logo Square',
            public_path('seeders/brand-logo-square.png'),
            'sites/brand-logo-square.png'
        );

        // Favicon
        $faviconPath = $this->copyOrDownloadImage(
            'Site Favicon',
            public_path('seeders/favicon.png'),
            'sites/favicon.png'
        );

        // Login cover image
        $loginCoverPath = $this->copyOrDownloadImage(
            'Login Cover Image',
            public_path('seeders/login-cover-image.jpg'),
            'sites/login-cover-image.jpg'
        );

        // Update database langsung untuk memastikan data disimpan
        if ($brandLogoPath) {
            DB::table('settings')
                ->where('group', 'general')
                ->where('name', 'brand_logo')
                ->update(['payload' => json_encode($brandLogoPath), 'updated_at' => now()]);
        }

        if ($brandLogoPath) {
            DB::table('settings')
                ->where('group', 'general')
                ->where('name', 'brand_logo_dark')
                ->update(['payload' => json_encode($brandLogoPath), 'updated_at' => now()]);
        }

        if ($brandLogoSquarePath) {
            DB::table('settings')
                ->where('group', 'general')
                ->where('name', 'brand_logo_square')
                ->update(['payload' => json_encode($brandLogoSquarePath), 'updated_at' => now()]);
        }

        if ($faviconPath) {
            DB::table('settings')
                ->where('group', 'general')
                ->where('name', 'site_favicon')
                ->update(['payload' => json_encode($faviconPath), 'updated_at' => now()]);
        }

        if ($loginCoverPath) {
            DB::table('settings')
                ->where('group', 'general')
                ->where('name', 'login_cover_image')
                ->update(['payload' => json_encode($loginCoverPath), 'updated_at' => now()]);
        }

        $this->command->info('✅ GeneralSettings images updated successfully!');
    }

    /**
     * Seed SiteSettings dengan logo menggunakan direct database update
     */
    private function seedSiteSettings(): void
    {
        $logoPath = $this->copyOrDownloadImage(
            'Site Logo',
            public_path('seeders/brand-logo.png'),
            'sites/site-logo.png'
        );

        // Update database langsung
        if ($logoPath) {
            DB::table('settings')
                ->where('group', 'sites')
                ->where('name', 'logo')
                ->update(['payload' => json_encode($logoPath), 'updated_at' => now()]);

            DB::table('settings')
                ->where('group', 'sites')
                ->where('name', 'logo_dark')
                ->update(['payload' => json_encode($logoPath), 'updated_at' => now()]);
        }

        $this->command->info('✅ SiteSettings images updated successfully!');
    }

    /**
     * Copy image dari folder lokal ke storage
     * 
     * @param string $name Nama image untuk display
     * @param string $localPath Path lokal file (jika ada)
     * @param string $storagePath Path di storage publik
     * @return string|null
     */
    private function copyOrDownloadImage(string $name, string $localPath, string $storagePath): ?string
    {
        try {
            // Jika file lokal ada, copy ke storage
            if (file_exists($localPath)) {
                $content = file_get_contents($localPath);
                Storage::disk('public')->put($storagePath, $content);
                $this->command->info("✓ $name copied successfully");
                return $storagePath;
            } else {
                $this->command->warn("⚠ $name not found at $localPath");
                return null;
            }
        } catch (\Exception $e) {
            $this->command->error("✗ Error seeding $name: " . $e->getMessage());
            return null;
        }
    }

    /**
     * (Opsional) Download image dari URL ke storage
     * 
     * @param string $url URL gambar
     * @param string $storagePath Path tujuan di storage
     * @return string|null
     */
    private function downloadImage(string $url, string $storagePath): ?string
    {
        try {
            $content = file_get_contents($url);
            if ($content === false) {
                throw new \Exception("Failed to download image from URL");
            }
            
            Storage::disk('public')->put($storagePath, $content);
            return $storagePath;
        } catch (\Exception $e) {
            $this->command->error("Error downloading image: " . $e->getMessage());
            return null;
        }
    }

    /**
     * (Opsional) Generate placeholder image menggunakan Faker
     * Perlu install: "php-loremipsum/php-loremipsum"
     * 
     * @param int $width Lebar gambar
     * @param int $height Tinggi gambar
     * @param string $storagePath Path penyimpanan
     * @return string|null
     */
    private function generatePlaceholderImage(int $width, int $height, string $storagePath): ?string
    {
        try {
            $imageUrl = "https://via.placeholder.com/{$width}x{$height}?text=NIMS";
            return $this->downloadImage($imageUrl, $storagePath);
        } catch (\Exception $e) {
            $this->command->error("Error generating placeholder: " . $e->getMessage());
            return null;
        }
    }
}
