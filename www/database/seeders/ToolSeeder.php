<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;

class ToolSeeder extends Seeder
{
    public function run()
    {

        Tool::updateOrCreate(
            ['kode_alat' => 'BB400'],
            [
                'nama_alat' => 'BreadBoard 400 point',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'BreadBoard 400 point',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_1.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-UUFX'],
            [
                'nama_alat' => '40x kabel Jumper 20CM (20 M T M 20 F T F)',
                'kategori' => 'Arduino Kit',
                'deskripsi' => '40x kabel Jumper 20CM (20 M T M 20 F T F)',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_2.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SHC'],
            [
                'nama_alat' => 'Sensor Jarak (Ultra sonicHCSR 04)',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Sensor Jarak (Ultra sonicHCSR 04)',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_3.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'USBBA'],
            [
                'nama_alat' => 'Kabel USB tipe B to A',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Kabel USB tipe B to A',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_4.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-S8PV'],
            [
                'nama_alat' => 'Header Pin  uk 8, 2, 10',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Header Pin  uk 8, 2, 10',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_5.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-00IH'],
            [
                'nama_alat' => 'LED 5MM',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'LED 5MM',
                'stok_total' => 35,
                'stok_tersedia' => 35,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_6.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-6CSX'],
            [
                'nama_alat' => 'Resistor',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Resistor',
                'stok_total' => 30,
                'stok_tersedia' => 30,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_7.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PTM'],
            [
                'nama_alat' => 'Potensio Meter',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Potensio Meter',
                'stok_total' => 11,
                'stok_tersedia' => 11,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_8.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PASBUZZ'],
            [
                'nama_alat' => 'Passive Buzzer',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Passive Buzzer',
                'stok_total' => 14,
                'stok_tersedia' => 14,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_9.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-QHIX'],
            [
                'nama_alat' => 'LED RGB',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'LED RGB',
                'stok_total' => 12,
                'stok_tersedia' => 12,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_10.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-WU90'],
            [
                'nama_alat' => 'Sensor cahaya ( PHoto Resistor/ LDR)',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Sensor cahaya ( PHoto Resistor/ LDR)',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_11.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-MWUA'],
            [
                'nama_alat' => 'Sensor Suhu dan kelembapan (DHT 11)',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Sensor Suhu dan kelembapan (DHT 11)',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_12.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-GI7K'],
            [
                'nama_alat' => '3 Kabel Jumper F T M 20 CM',
                'kategori' => 'Arduino Kit',
                'deskripsi' => '3 Kabel Jumper F T M 20 CM',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_13.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'LCD1602'],
            [
                'nama_alat' => 'LCD 1602 (16x2)',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'LCD 1602 (16x2)',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_14.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'RLY'],
            [
                'nama_alat' => 'Modul Relay 1 Chanel',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Modul Relay 1 Chanel',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_15.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'UNO.PB'],
            [
                'nama_alat' => 'Arduino Uno R3 Tipe SMD/ DIP',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Arduino Uno R3 Tipe SMD/ DIP',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_16.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SG90'],
            [
                'nama_alat' => 'Motor servo (SG900)',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'Motor servo (SG900)',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_17.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-OHTJ'],
            [
                'nama_alat' => 'DVD tutorial',
                'kategori' => 'Arduino Kit',
                'deskripsi' => 'DVD tutorial',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Arduino_Kit_18.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-GLL9'],
            [
                'nama_alat' => 'CAT Connector Plug',
                'kategori' => 'Jaringan',
                'deskripsi' => 'CAT Connector Plug',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_19.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-MA7Q'],
            [
                'nama_alat' => 'Crimping tool',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Crimping tool',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_23.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-K0F0'],
            [
                'nama_alat' => 'tp-link Wifi Range Extender 300Mbps 2.4Ghz',
                'kategori' => 'Jaringan',
                'deskripsi' => 'tp-link Wifi Range Extender 300Mbps 2.4Ghz',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-WIY8'],
            [
                'nama_alat' => 'Network Cable Tester',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Network Cable Tester',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_24.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-CT2Y'],
            [
                'nama_alat' => '⁠2pcs Tenda 500m Outdoor Point to Point CPE',
                'kategori' => 'Jaringan',
                'deskripsi' => '⁠2pcs Tenda 500m Outdoor Point to Point CPE',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_25.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-LJEB'],
            [
                'nama_alat' => 'Set Crimping tool',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Set Crimping tool',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_26.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-RS6C'],
            [
                'nama_alat' => 'Adaptor Rasberry5',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Adaptor Rasberry5',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_27.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-IPOD'],
            [
                'nama_alat' => 'Rasberry Pi',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Rasberry Pi',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Jaringan_28.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-YH6V'],
            [
                'nama_alat' => 'Kabel Micro HDMI (MICRO HDTV M/M',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Kabel Micro HDMI (MICRO HDTV M/M',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'OB241'],
            [
                'nama_alat' => 'Obeng 24 in 1',
                'kategori' => 'Jaringan',
                'deskripsi' => 'Obeng 24 in 1',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'CARARC'],
            [
                'nama_alat' => 'Smart Car Acrylic Chassis',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'Smart Car Acrylic Chassis',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robot_Avoidance_Car_30.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'BAN'],
            [
                'nama_alat' => 'Wheels',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'Wheels',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robot_Avoidance_Car_35.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'UNO.PB'],
            [
                'nama_alat' => 'Arduino Uno R3 Tipe SMD/ DIP + pin header',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'Arduino Uno R3 Tipe SMD/ DIP + pin header',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robot_Avoidance_Car_36.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SSHD'],
            [
                'nama_alat' => 'sensor shield v5.0',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'sensor shield v5.0',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-CIVJ'],
            [
                'nama_alat' => 'Baterai Holder',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'Baterai Holder',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robot_Avoidance_Car_38.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MRDC'],
            [
                'nama_alat' => '2 Motor DC',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => '2 Motor DC',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-MJT5'],
            [
                'nama_alat' => 'Swivel Wheel',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'Swivel Wheel',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robot_Avoidance_Car_40.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-L7J5'],
            [
                'nama_alat' => 'L298N driver',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'L298N driver',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'OB21'],
            [
                'nama_alat' => 'Obeng',
                'kategori' => 'Robot Avoidance Car',
                'deskripsi' => 'Obeng',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'BPAK'],
            [
                'nama_alat' => 'Base Plate Arm Kit',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Base Plate Arm Kit',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_44.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MG90'],
            [
                'nama_alat' => 'Motor Servo MG90',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Motor Servo MG90',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_46.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SAK'],
            [
                'nama_alat' => 'Shoulder',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Shoulder',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_47.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'EAK'],
            [
                'nama_alat' => 'Elbow',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Elbow',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_48.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-BUFP'],
            [
                'nama_alat' => 'Arduino Nano + Shield',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Arduino Nano + Shield',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'BAK'],
            [
                'nama_alat' => 'Base',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Base',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'OB1'],
            [
                'nama_alat' => 'Obeng Kembang',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Obeng Kembang',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_49.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'TPC'],
            [
                'nama_alat' => 'USB Type C',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'USB Type C',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_50.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-NON3'],
            [
                'nama_alat' => 'Grip Left & Right',
                'kategori' => 'ARM Full Kit',
                'deskripsi' => 'Grip Left & Right',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_ARM_Full_Kit_51.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'RESK01'],
            [
                'nama_alat' => 'Resistor 68 OHM 1/4 WATT TOLERANCE 1 %',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Resistor 68 OHM 1/4 WATT TOLERANCE 1 %',
                'stok_total' => 40,
                'stok_tersedia' => 40,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_53.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'LEDMM41'],
            [
                'nama_alat' => 'LED DOT Matrix Module 8x8 4 in 1',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'LED DOT Matrix Module 8x8 4 in 1',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_55.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'TMS'],
            [
                'nama_alat' => 'Timah Solder',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Timah Solder',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_56.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MSKEY16'],
            [
                'nama_alat' => 'Membran Switch Keypad 4x4 16 Key',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Membran Switch Keypad 4x4 16 Key',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_57.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'JMTM30'],
            [
                'nama_alat' => 'Kabel Jumper 30cm M to M',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Kabel Jumper 30cm M to M',
                'stok_total' => 40,
                'stok_tersedia' => 40,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_58.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'JFTM30'],
            [
                'nama_alat' => 'Kabel Jumper 30cm F to M',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Kabel Jumper 30cm F to M',
                'stok_total' => 40,
                'stok_tersedia' => 40,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'JFTF30'],
            [
                'nama_alat' => 'Kabel Jumper 30cm F to F',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Kabel Jumper 30cm F to F',
                'stok_total' => 40,
                'stok_tersedia' => 40,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_60.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'DGMTR'],
            [
                'nama_alat' => 'Digital Multimeter',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Digital Multimeter',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_61.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'LED05 & LED03'],
            [
                'nama_alat' => '1 Set Lampu LED berisi 20LED 5mm 5 Warna & 20 LED 3mm 5 warna',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => '1 Set Lampu LED berisi 20LED 5mm 5 Warna & 20 LED 3mm 5 warna',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_62.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'DSPM4D'],
            [
                'nama_alat' => '4 Digit Display Module',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => '4 Digit Display Module',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_63.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-BAEX'],
            [
                'nama_alat' => '1 Set Kit ESP-32',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => '1 Set Kit ESP-32',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_64.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-BR7R'],
            [
                'nama_alat' => 'Isi 1 Set Kit ESP-32',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Isi 1 Set Kit ESP-32',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_65.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ESP-32'],
            [
                'nama_alat' => 'ESP-32',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'ESP-32',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PIRA346'],
            [
                'nama_alat' => 'Sensor gerak PIR A346',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Sensor gerak PIR A346',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_66.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'OLEDM66'],
            [
                'nama_alat' => 'Oled Mini',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Oled Mini',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_67.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SDH11'],
            [
                'nama_alat' => 'Sensor Suhu dan Kelembapan',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Sensor Suhu dan Kelembapan',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_68.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'RLY2C'],
            [
                'nama_alat' => 'Modul Relay 2 Channel',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Modul Relay 2 Channel',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_69.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MSLDR'],
            [
                'nama_alat' => 'Modul Sensor Cahaya',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Modul Sensor Cahaya',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_70.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MSIFRM'],
            [
                'nama_alat' => 'Modul Sensor Inframerah',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Modul Sensor Inframerah',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_71.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'BB800'],
            [
                'nama_alat' => 'BreadBoard 800 point',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'BreadBoard 800 point',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_72.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'JMTM20, JMTF20,'],
            [
                'nama_alat' => 'Kabel Jumper 20 cm M to M, M to F, F to F',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Kabel Jumper 20 cm M to M, M to F, F to F',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_73.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'USBATM'],
            [
                'nama_alat' => 'Kabel USB Tipe A to Mini',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Kabel USB Tipe A to Mini',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_74.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'RESK10'],
            [
                'nama_alat' => 'Resistor 220. 1k. 10k OHM',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Resistor 220. 1k. 10k OHM',
                'stok_total' => 30,
                'stok_tersedia' => 30,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_75.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-6HM9'],
            [
                'nama_alat' => 'Tactile Push Button',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Tactile Push Button',
                'stok_total' => 6,
                'stok_tersedia' => 6,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_77.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-5HR0'],
            [
                'nama_alat' => 'Passive Buzzer & Active Buzzer',
                'kategori' => 'Robotika Pak Maul',
                'deskripsi' => 'Passive Buzzer & Active Buzzer',
                'stok_total' => 1,
                'stok_tersedia' => 1,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul_80.jpg'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-GQJC'],
            [
                'nama_alat' => 'Modul Expansion Shield Board ESP32',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Modul Expansion Shield Board ESP32',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_81.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-0RDL'],
            [
                'nama_alat' => 'Modul Expansion Board ESP8266',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Modul Expansion Board ESP8266',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_90.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ESP8266'],
            [
                'nama_alat' => 'ESP8266',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'ESP8266',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_83.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'LCMUT'],
            [
                'nama_alat' => 'LC Mini Ultrasonic Tester',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'LC Mini Ultrasonic Tester',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_85.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MQ2GS'],
            [
                'nama_alat' => 'Modul Sensor Gas',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Modul Sensor Gas',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_86.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'RFID'],
            [
                'nama_alat' => 'RFID-RC255',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'RFID-RC255',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_91.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SWSNSR'],
            [
                'nama_alat' => 'Modul Sweep Hand Scan Sensor',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Modul Sweep Hand Scan Sensor',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_97.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'SKTM'],
            [
                'nama_alat' => 'Sakelar Toggle Mini',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Sakelar Toggle Mini',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_96.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'HW006'],
            [
                'nama_alat' => 'Sensor Tracking Inframerah',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Sensor Tracking Inframerah',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Robotika_Pak_Maul19nov_93.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'TTP223B'],
            [
                'nama_alat' => 'Modul Sensor Sentuh',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Modul Sensor Sentuh',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'OLEDM66'],
            [
                'nama_alat' => 'OLED Mini 0,66mm',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'OLED Mini 0,66mm',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'OLEDM91'],
            [
                'nama_alat' => 'OLED Mini 0,91 mm',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'OLED Mini 0,91 mm',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'ALAT-IL4I'],
            [
                'nama_alat' => 'Kabel USB',
                'kategori' => 'Robotika Pak Maul19nov',
                'deskripsi' => 'Kabel USB',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PCBHS'],
            [
                'nama_alat' => 'Ragum Pcb Pcb Ragum Pcb Holder Pcb Stand Series',
                'kategori' => 'Tools20nov',
                'deskripsi' => 'Ragum Pcb Pcb Ragum Pcb Holder Pcb Stand Series',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Tools20nov_98.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PTS-T11'],
            [
                'nama_alat' => 'Pinset Antistatic 3 In 1 Profess ional Anti-Static Tweezers Kit Repair Tool',
                'kategori' => 'Tools20nov',
                'deskripsi' => 'Pinset Antistatic 3 In 1 Profess ional Anti-Static Tweezers Kit Repair Tool',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PNS-EBH'],
            [
                'nama_alat' => 'Pinset Static Elbow Tweeze rs With Replacing Elbow Head',
                'kategori' => 'Tools20nov',
                'deskripsi' => 'Pinset Static Elbow Tweeze rs With Replacing Elbow Head',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/alat_Tools20nov_102.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'FLX-SD'],
            [
                'nama_alat' => 'Flux Solder Solder Soldering Paste',
                'kategori' => 'Tools20nov',
                'deskripsi' => 'Flux Solder Solder Soldering Paste',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/flux_solder.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'PNY-TH'],
            [
                'nama_alat' => 'Sedot timah  Sedot Timah Penyedot Timah Aluminium',
                'kategori' => 'Tools20nov',
                'deskripsi' => 'Sedot timah  Sedot Timah Penyedot Timah Aluminium',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => 'alat/sedot_timah.png'
            ]
        );

        Tool::updateOrCreate(
            ['kode_alat' => 'MTRSLDR'],
            [
                'nama_alat' => 'Matras Solder',
                'kategori' => 'Tools20nov',
                'deskripsi' => 'Matras Solder',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'status_alat' => 'Tersedia',
                'lokasi' => 'Workshop IT',
                'foto_alat' => null
            ]
        );
    }
}
