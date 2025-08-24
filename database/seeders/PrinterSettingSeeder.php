<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrinterSetting;

class PrinterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrinterSetting::create([
            'key' => 'printer_ip',
            'value' => '192.168.100.87',
        ]);
    }
}