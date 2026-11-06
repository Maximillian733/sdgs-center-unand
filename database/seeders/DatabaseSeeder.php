<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin awal -> GANTI password lewat .env (ADMIN_PASSWORD) sebelum seed di server.
        DB::table('admins')->insert([
            'username' => env('ADMIN_USERNAME', 'admin'),
            'email' => env('ADMIN_EMAIL', 'unand.hsdg@gmail.com'),
            'password_hash' => Hash::make(env('ADMIN_PASSWORD', 'GantiPassword#2026')),
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $sdg = [
            ['Tanpa Kemiskinan', 'No Poverty', '#E5243B'], ['Tanpa Kelaparan', 'Zero Hunger', '#B8860B'],
            ['Kehidupan Sehat dan Sejahtera', 'Good Health and Well-being', '#2E8B3D'], ['Pendidikan Berkualitas', 'Quality Education', '#C5192D'],
            ['Kesetaraan Gender', 'Gender Equality', '#FF3A21'], ['Air Bersih dan Sanitasi Layak', 'Clean Water and Sanitation', '#0F87B5'],
            ['Energi Bersih dan Terjangkau', 'Affordable and Clean Energy', '#8A6A00'], ['Pekerjaan Layak dan Pertumbuhan Ekonomi', 'Decent Work and Economic Growth', '#A21942'],
            ['Industri, Inovasi, dan Infrastruktur', 'Industry, Innovation and Infrastructure', '#C2571A'], ['Berkurangnya Kesenjangan', 'Reduced Inequalities', '#DD1367'],
            ['Kota dan Permukiman yang Berkelanjutan', 'Sustainable Cities and Communities', '#B8620E'], ['Konsumsi dan Produksi yang Bertanggung Jawab', 'Responsible Consumption and Production', '#8B6914'],
            ['Penanganan Perubahan Iklim', 'Climate Action', '#3F7E44'], ['Ekosistem Lautan', 'Life Below Water', '#0A97D9'],
            ['Ekosistem Daratan', 'Life on Land', '#3C8A1F'], ['Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 'Peace, Justice and Strong Institutions', '#00689D'],
            ['Kemitraan untuk Mencapai Tujuan', 'Partnerships for the Goals', '#19486A'],
        ];
        foreach ($sdg as $i => [$id, $en, $color]) {
            DB::table('sdgs')->insert(['id' => $i + 1, 'name_id' => $id, 'name_en' => $en, 'icon' => (string) ($i + 1), 'color' => $color]);
        }

        DB::table('org_profile')->insert([
            'vision_id' => 'Menjadi pusat kajian dan pelatihan yang terkemuka dan unggul dalam berperan nyata untuk mewujudkan masyarakat Indonesia yang berkualitas dan sejahtera melalui pencapaian tujuan SDGs tahun 2030.',
            'vision_en' => 'To become a leading and outstanding center for studies and training that plays a real role in realizing a high-quality and prosperous Indonesian society through the achievement of the SDGs by 2030.',
            'mission_id' => "Melaksanakan dan menghasilkan penelitian yang responsif terhadap dinamika lingkungan dalam rangka mencapai tujuan SDGs.\nMenyelenggarakan program pendampingan dan pengabdian kepada masyarakat yang berlandaskan IPTEK dalam rangka mencapai tujuan SDGs.\nMembangun kerja sama antara pemangku kepentingan di dalam maupun di luar negeri dalam rangka mencapai tujuan SDGs.\nMenghasilkan inovasi, rekomendasi, dan strategi dalam rangka mencapai tujuan SDGs.",
            'mission_en' => "Conduct and produce research that is responsive to environmental dynamics in order to achieve the SDGs.\nOrganize mentoring and community service programs based on science and technology in order to achieve the SDGs.\nBuild cooperation among stakeholders at home and abroad in order to achieve the SDGs.\nProduce innovations, recommendations, and strategies in order to achieve the SDGs.",
            'address' => 'Gedung Fakultas Ekonomi, Kampus Limau Manih, Padang 25163',
            'phone' => '+62 751 71088', 'fax' => '+62 751 71089', 'email' => 'unand.hsdg@gmail.com',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        foreach ([['Dewan Pengarah', 'Prof. Dr. Elfindri, SE, MA'], ['Ketua', 'Dr. Sri Maryati, SE, M.Si'], ['Sekretaris', 'Dr. Edi Ariyanto, SE, M.Si'],
                  ['Bendahara', 'Besti Novianda, SE, M.SE'], ['Kesekretariatan', 'Lindawati, SE'], ['Kesekretariatan', 'Muhammad Kivlan, SE']] as $i => [$p, $n]) {
            DB::table('board_members')->insert(['position' => $p, 'name' => $n, 'sort_order' => $i + 1, 'created_at' => now(), 'updated_at' => now()]);
        }

        $partners = ['BRIN', 'RSUD Mandau', 'RSUD Bengkalis', 'RSGM UNAND', 'GIZ Jerman', 'Pemerintah Provinsi Sumatera Barat', 'Pemerintah Nagari/Desa'];
        foreach ($partners as $p) {
            DB::table('partners')->insert(['name' => $p, 'created_at' => now(), 'updated_at' => now()]);
        }
        $pid = fn ($names) => DB::table('partners')->whereIn('name', $names)->pluck('id')->all();

        // Portofolio awal dari dokumen Profile SDGs Center (tag SDG = usulan, ubah lewat dashboard).
        $projects = [
            ['Penghitungan Pembagian Jasa Layanan Umum RSGM UNAND', 'studi', 2025, [3, 8], ['RSGM UNAND']],
            ['Pengukuran Prevalensi Penyalahgunaan Narkoba Provinsi Sumatera Barat (22–24 Juli 2025)', 'studi', 2025, [3, 16], ['BRIN']],
            ['Perhitungan Pola Tarif (Unit Cost) RSUD Mandau', 'studi', 2023, [3], ['RSUD Mandau']],
            ['Perhitungan Pola Tarif (Unit Cost) RSUD Bengkalis', 'studi', 2023, [3], ['RSUD Bengkalis']],
            ['Pendampingan Penyusunan RPJM Nagari Sinuruik Berbasis SDGs', 'pendampingan', 2023, [11, 17], ['Pemerintah Nagari/Desa']],
            ['Pendampingan Pendataan SDGs Desa', 'pendampingan', 2023, [11, 17], ['Pemerintah Nagari/Desa']],
            ['Advocacy SDGs for NSA on West Sumatra', 'advokasi', 2022, [17], ['GIZ Jerman']],
            ['Monitoring The Implementation of New Distance Learning', 'pendampingan', 2021, [4], ['GIZ Jerman']],
            ['Forum SDGs Sumatera Barat 2021', 'workshop', 2021, [17], ['Pemerintah Provinsi Sumatera Barat', 'GIZ Jerman']],
        ];
        foreach ($projects as [$title, $type, $year, $sdgs, $pn]) {
            $id = DB::table('projects')->insertGetId(['title' => $title, 'type' => $type, 'year' => $year, 'created_at' => now(), 'updated_at' => now()]);
            foreach ($sdgs as $s) { DB::table('project_sdgs')->insert(['project_id' => $id, 'sdg_id' => $s]); }
            foreach ($pid($pn) as $p) { DB::table('project_partner')->insert(['project_id' => $id, 'partner_id' => $p]); }
        }

        $news = [
            ['workshop-nsa-region-action-plans-sdgs-sumbar-2022-2026', 'Workshop NSA Assistance Region Action Plans SDGs Sumatera Barat 2022–2026',
             'Workshop for NSA Assistance in Preparation of Region Action Plans SDGs for West Sumatra 2022–2026', '2022-11-01', 'workshop', true, [17],
             'Workshop pendampingan Non State Actors (NSA) dalam penyusunan Region Action Plans SDGs Sumatera Barat 2022–2026, diselenggarakan 1–2 November 2022 bekerja sama dengan GIZ Jerman.',
             'A workshop assisting Non State Actors (NSA) in preparing the Region Action Plans for SDGs in West Sumatra 2022–2026, held on 1–2 November 2022 in cooperation with GIZ Germany.'],
            ['forum-sdgs-sumatera-barat-2021', 'Forum SDGs Sumatera Barat 2021', 'West Sumatra SDGs Forum 2021', '2021-11-01', 'berita', true, [17],
             'Forum SDGs Sumatera Barat 2021 diselenggarakan bekerja sama dengan Pemerintah Provinsi Sumatera Barat dan didukung oleh GIZ Jerman.',
             'The West Sumatra SDGs Forum 2021 was held in cooperation with the West Sumatra Provincial Government and supported by GIZ Germany.'],
            ['workshop-pendampingan-project-management-2022', 'Workshop Pendampingan Project Management, Administrasi, Monitoring dan Evaluasi Proyek',
             'Workshop on Project Management, Administration, Monitoring and Evaluation', '2022-02-01', 'pelatihan', false, [17, 4],
             'Workshop pendampingan project management, administrasi, serta monitoring dan evaluasi proyek oleh Tim Konsultan SustaIN, bekerja sama dengan GIZ Jerman (Februari 2022).',
             'A workshop on project management, administration, and project monitoring and evaluation by the SustaIN consultant team, in cooperation with GIZ Germany (February 2022).'],
        ];
        foreach ($news as [$slug, $tid, $ten, $date, $type, $feat, $sdgs, $bid, $ben]) {
            $id = DB::table('news')->insertGetId([
                'title_id' => $tid, 'title_en' => $ten, 'slug' => $slug, 'body_id' => '<p>'.e($bid).'</p>', 'body_en' => '<p>'.e($ben).'</p>',
                'event_date' => $date, 'type' => $type, 'status' => 'published', 'is_featured' => $feat, 'author_id' => 1,
                'published_at' => now(), 'created_at' => now(), 'updated_at' => now(),
            ]);
            foreach ($sdgs as $s) { DB::table('news_sdgs')->insert(['news_id' => $id, 'sdg_id' => $s]); }
        }
    }
}
