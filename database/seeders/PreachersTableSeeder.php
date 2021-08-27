<?php

namespace Database\Seeders;

use App\Models\Preacher;
use Illuminate\Database\Seeder;

class PreachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preacher::truncate();

        \DB::statement("INSERT INTO `preachers` (`id`, `name`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
        (1, 'Rev. Arome E. Tokula', 'rev-arome-e-tokula', NULL, '2019-09-14 19:56:58', '2019-09-14 19:56:58'),
        (2, 'Pastor Avese Tokula', 'pastor-avese-tokula', NULL, '2019-09-14 19:57:16', '2019-09-14 19:57:16'),
        (3, 'Rev. Arome E. Adah', 'rev-arome-e-adah', NULL, '2019-09-14 19:57:40', '2019-09-14 19:57:40'),
        (4, 'Rev. Joshua Tende', 'rev-joshua-tende', NULL, '2019-09-14 19:58:16', '2019-09-14 19:58:16'),
        (5, 'Rev. Dunka Gomwalk', 'rev-dunka-gomwalk', NULL, '2019-09-14 19:58:40', '2019-09-14 19:58:40'),
        (6, 'Rev. Emma Opara', 'rev-emma-opara', NULL, '2019-09-14 19:58:55', '2019-09-14 19:58:55'),
        (7, 'Rev. Tibidabo Peters', 'rev-tibidabo-peters', NULL, '2019-09-14 19:59:23', '2019-09-14 19:59:23'),
        (8, 'Rev. Tunde Phillips', 'rev-tunde-phillips', NULL, '2019-09-14 20:00:43', '2019-09-14 20:00:43'),
        (9, 'Rev. David Amuneni', 'rev-david-amuneni', NULL, '2019-09-14 20:01:02', '2019-09-14 20:01:02'),
        (10, 'Rev. Moyo Akin-Ojo', 'rev-moyo-akin-ojo', NULL, '2019-09-14 20:01:23', '2019-09-14 20:01:23')");

    }
}
