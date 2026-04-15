<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin role
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'], [
            'display_name' => 'Администратор',
        ]);

        // Admin user
        $admin = User::firstOrCreate(['email' => 'admin@void.local'], [
            'name'     => 'Admin',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($role);

        // Categories
        $categories = [
            ['name' => 'Апартаменты', 'slug' => 'apartments', 'position' => 1],
            ['name' => 'Лофты',       'slug' => 'lofts',      'position' => 2],
            ['name' => 'Пентхаусы',   'slug' => 'penthouses', 'position' => 3],
            ['name' => 'Студии',      'slug' => 'studios',    'position' => 4],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Sample properties
        $catIds = Category::pluck('id', 'slug');

        $properties = [
            [
                'name'              => 'Skyline Loft 404',
                'short_description' => 'Дизайнерский лофт с панорамными окнами и видом на город',
                'description'       => 'Просторный лофт с высокими потолками 4.2м, кирпичными стенами и панорамным остеклением. Авторский ремонт, встроенная кухня премиум-класса.',
                'category_id'       => $catIds['lofts'],
                'price'             => 18500000,
                'area'              => 87.5,
                'rooms'             => 2,
                'floor'             => 12,
                'floors_total'      => 18,
                'address'           => 'ул. Лесная, 42',
                'status'            => true,
                'is_featured'       => true,
                'alias'             => 'skyline-loft-404',
                'position'          => 1,
            ],
            [
                'name'              => 'Void Penthouse',
                'short_description' => 'Эксклюзивный пентхаус на последнем этаже с террасой 60м²',
                'description'       => 'Двухуровневый пентхаус с собственной террасой, джакузи и видом на весь город. Умный дом, система климат-контроля.',
                'category_id'       => $catIds['penthouses'],
                'price'             => 55000000,
                'area'              => 210.0,
                'rooms'             => 4,
                'floor'             => 24,
                'floors_total'      => 24,
                'address'           => 'Набережная ул., 1',
                'status'            => true,
                'is_featured'       => true,
                'alias'             => 'void-penthouse',
                'position'          => 2,
            ],
            [
                'name'              => 'Dark Matter Studio',
                'short_description' => 'Стильная студия в тёмных тонах для urban-жизни',
                'description'       => 'Компактная студия 38м² с продуманным зонированием. Встроенная мебель, умная подсветка, гардеробная.',
                'category_id'       => $catIds['studios'],
                'price'             => 7200000,
                'area'              => 38.0,
                'rooms'             => 1,
                'floor'             => 5,
                'floors_total'      => 16,
                'address'           => 'пр. Ленина, 88',
                'status'            => true,
                'is_featured'       => true,
                'alias'             => 'dark-matter-studio',
                'position'          => 3,
            ],
            [
                'name'              => 'Noir Apartments 7',
                'short_description' => 'Трёхкомнатные апартаменты в монохромном стиле',
                'description'       => 'Апартаменты с дизайнерским ремонтом, мраморными полами и кухней-гостиной 45м². Закрытая территория, подземный паркинг.',
                'category_id'       => $catIds['apartments'],
                'price'             => 24000000,
                'area'              => 112.0,
                'rooms'             => 3,
                'floor'             => 8,
                'floors_total'      => 20,
                'address'           => 'ул. Садовая, 15',
                'status'            => true,
                'is_featured'       => true,
                'alias'             => 'noir-apartments-7',
                'position'          => 4,
            ],
            [
                'name'              => 'Void Studio Compact',
                'short_description' => 'Минималистичная студия для стильной жизни',
                'description'       => 'Студия 28м² с умным зонированием. Всё необходимое в компактном пространстве.',
                'category_id'       => $catIds['studios'],
                'price'             => 5500000,
                'area'              => 28.0,
                'rooms'             => 1,
                'floor'             => 3,
                'floors_total'      => 12,
                'address'           => 'ул. Молодёжная, 22',
                'status'            => true,
                'is_featured'       => false,
                'alias'             => 'void-studio-compact',
                'position'          => 5,
            ],
            [
                'name'              => 'Eclipse Loft',
                'short_description' => 'Двухэтажный лофт с собственной мастерской',
                'description'       => 'Уникальный лофт на двух уровнях. Антресоль, открытые коммуникации, полированный бетон.',
                'category_id'       => $catIds['lofts'],
                'price'             => 22000000,
                'area'              => 95.0,
                'rooms'             => 2,
                'floor'             => 9,
                'floors_total'      => 14,
                'address'           => 'Заводская ул., 7',
                'status'            => true,
                'is_featured'       => false,
                'alias'             => 'eclipse-loft',
                'position'          => 6,
            ],
        ];

        foreach ($properties as $prop) {
            Property::firstOrCreate(['alias' => $prop['alias']], $prop);
        }
    }
}
