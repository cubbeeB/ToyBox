<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ToyBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@toybox.test'],
            [
                'name' => 'Администратор ToyBox',
                'password' => Hash::make('password'),
                'phone' => '+7 900 555-35-35',
                'is_admin' => true,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'parent@example.com'],
            [
                'name' => 'Мария Иванова',
                'password' => Hash::make('password'),
                'phone' => '+7 900 100-20-30',
            ],
        );

        $categories = collect([
            ['name' => 'Мягкие игрушки', 'slug' => 'soft-toys', 'description' => 'Плюшевые друзья для малышей и уютных подарков.'],
            ['name' => 'Конструкторы', 'slug' => 'constructors', 'description' => 'Наборы для фантазии, логики и мелкой моторики.'],
            ['name' => 'Настольные игры', 'slug' => 'board-games', 'description' => 'Игры для семейных вечеров и детских компаний.'],
            ['name' => 'Развивающие игрушки', 'slug' => 'educational-toys', 'description' => 'Игрушки для речи, памяти, внимания и первых открытий.'],
        ])->mapWithKeys(fn (array $category) => [
            $category['slug'] => Category::query()->updateOrCreate(['slug' => $category['slug']], $category),
        ]);

        $brands = collect([
            ['name' => 'ToyBox Kids', 'slug' => 'toybox-kids', 'country' => 'Россия'],
            ['name' => 'Happy Blocks', 'slug' => 'happy-blocks', 'country' => 'Германия'],
            ['name' => 'Smart Play', 'slug' => 'smart-play', 'country' => 'Польша'],
        ])->mapWithKeys(fn (array $brand) => [
            $brand['slug'] => Brand::query()->updateOrCreate(['slug' => $brand['slug']], $brand),
        ]);

        collect([
            [
                'category' => 'soft-toys',
                'brand' => 'toybox-kids',
                'name' => 'Мишка Соня',
                'slug' => 'mishka-sonya',
                'sku' => 'TB-SOFT-001',
                'description' => 'Мягкий гипоаллергенный мишка для сна, объятий и первых игр.',
                'price' => 1490,
                'old_price' => 1890,
                'stock' => 24,
                'age_group' => '1-3',
                'gender' => 'unisex',
                'image_url' => 'https://images.unsplash.com/photo-1559454403-b8fb88521f11?auto=format&fit=crop&w=900&q=80',
                'features' => ['гипоаллергенный материал', 'можно стирать', 'сертификат ЕАС'],
                'rating' => 4.8,
                'reviews_count' => 18,
                'popularity' => 95,
                'is_new' => true,
                'is_hit' => true,
            ],
            [
                'category' => 'constructors',
                'brand' => 'happy-blocks',
                'name' => 'Город мечты',
                'slug' => 'gorod-mechty',
                'sku' => 'TB-BLOCK-014',
                'description' => 'Большой конструктор с домиками, машинками и фигурками для сюжетной игры.',
                'price' => 3290,
                'old_price' => null,
                'stock' => 12,
                'age_group' => '3-6',
                'gender' => 'unisex',
                'image_url' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=900&q=80',
                'features' => ['145 деталей', 'совместим с крупными блоками', 'развивает пространственное мышление'],
                'rating' => 4.9,
                'reviews_count' => 31,
                'popularity' => 120,
                'is_new' => false,
                'is_hit' => true,
            ],
            [
                'category' => 'board-games',
                'brand' => 'smart-play',
                'name' => 'Лесные приключения',
                'slug' => 'lesnye-priklyucheniya',
                'sku' => 'TB-BOARD-008',
                'description' => 'Кооперативная настольная игра, где дети учатся договариваться и планировать.',
                'price' => 1790,
                'old_price' => 2190,
                'stock' => 18,
                'age_group' => '6-12',
                'gender' => 'unisex',
                'image_url' => 'https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?auto=format&fit=crop&w=900&q=80',
                'features' => ['2-5 игроков', 'партия 25 минут', 'семейный формат'],
                'rating' => 4.7,
                'reviews_count' => 14,
                'popularity' => 82,
                'is_new' => true,
                'is_hit' => false,
            ],
            [
                'category' => 'educational-toys',
                'brand' => 'toybox-kids',
                'name' => 'Первый сортер',
                'slug' => 'pervyj-sorter',
                'sku' => 'TB-EDU-003',
                'description' => 'Деревянный сортер с безопасными красками для изучения форм и цветов.',
                'price' => 1190,
                'old_price' => null,
                'stock' => 30,
                'age_group' => '0-1',
                'gender' => 'unisex',
                'image_url' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=900&q=80',
                'features' => ['натуральное дерево', 'безопасные краски', 'крупные детали'],
                'rating' => 4.6,
                'reviews_count' => 9,
                'popularity' => 76,
                'is_new' => false,
                'is_hit' => false,
            ],
        ])->each(function (array $product) use ($categories, $brands): void {
            $categorySlug = $product['category'];
            $brandSlug = $product['brand'];
            unset($product['category'], $product['brand']);

            Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                [
                    ...$product,
                    'category_id' => $categories[$categorySlug]->id,
                    'brand_id' => $brands[$brandSlug]->id,
                    'published_at' => now(),
                ],
            );
        });

        collect([
            [
                'slug' => 'kak-vybrat-igrushku-po-vozrastu',
                'title' => 'Как выбрать игрушку по возрасту ребёнка',
                'excerpt' => 'Короткий гид для родителей: безопасность, интересы и польза игры.',
                'body' => 'Для малышей важны крупные детали и тактильные материалы, дошкольникам нужны сюжетные наборы, а школьникам полезны конструкторы и настольные игры.',
                'image_url' => 'https://images.unsplash.com/photo-1503454537845-7e8b5b2374ea?auto=format&fit=crop&w=900&q=80',
                'tags' => ['возраст', 'развитие'],
            ],
            [
                'slug' => 'milye-igrushki-dlya-sna',
                'title' => 'Мягкие игрушки для спокойного сна',
                'excerpt' => 'На что смотреть при выборе плюшевого друга: материалы, размер и уход.',
                'body' => 'Выбирайте гипоаллергенные ткани, проверяйте надёжность швов и стирайте игрушку по инструкции производителя.',
                'image_url' => 'https://images.unsplash.com/photo-1559454403-b8fb88521f11?auto=format&fit=crop&w=900&q=80',
                'tags' => ['мягкие игрушки', 'сон'],
            ],
            [
                'slug' => 'konstruktory-i-melkaya-motorika',
                'title' => 'Конструкторы и мелкая моторика',
                'excerpt' => 'Почему блоки полезны с 2 лет и как не перегрузить ребёнка деталями.',
                'body' => 'Начинайте с крупных элементов, постепенно усложняйте наборы и играйте вместе, чтобы ребёнок видел пример.',
                'image_url' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=900&q=80',
                'tags' => ['конструкторы', 'развитие'],
            ],
            [
                'slug' => 'nastolnye-igry-dlya-semi',
                'title' => 'Настольные игры для всей семьи',
                'excerpt' => 'Подборка форматов на 20–40 минут: от кооперативных до соревновательных.',
                'body' => 'Семейные игры учат договариваться, ждать очереди и радоваться общему результату.',
                'image_url' => 'https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?auto=format&fit=crop&w=900&q=80',
                'tags' => ['настольные игры', 'семья'],
            ],
            [
                'slug' => 'razvivayushchie-igrushki-0-1',
                'title' => 'Развивающие игрушки для малышей 0–1 год',
                'excerpt' => 'Сортеры, погремушки и тактильные коврики для первых открытий.',
                'body' => 'В этом возрасте важны контрастные цвета, безопасные материалы и простые механики без мелких деталей.',
                'image_url' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=900&q=80',
                'tags' => ['0-1 год', 'развитие'],
            ],
            [
                'slug' => 'podarki-dlya-devochek-i-malchikov',
                'title' => 'Подарки: стереотипы и реальные интересы',
                'excerpt' => 'Как выбирать игрушку по увлечениям, а не только по полу.',
                'body' => 'Конструкторы подходят всем, а сюжетные наборы стоит подбирать под любимые темы ребёнка.',
                'image_url' => 'https://images.unsplash.com/photo-1515488042361-ee00e17ddd4f?auto=format&fit=crop&w=900&q=80',
                'tags' => ['подарки', 'советы'],
            ],
            [
                'slug' => 'bezopasnost-materialov',
                'title' => 'Безопасность материалов: на что смотреть',
                'excerpt' => 'Сертификаты, маркировка возраста и проверка качества перед покупкой.',
                'body' => 'Ищите маркировку CE или ЕАС, избегайте резкого запаха пластика и проверяйте отсутствие острых элементов.',
                'image_url' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=900&q=80',
                'tags' => ['безопасность', 'родителям'],
            ],
            [
                'slug' => 'igrushki-dlya-tvorchestva',
                'title' => 'Игрушки для творчества и воображения',
                'excerpt' => 'Наборы для рисования, лепки и сюжетных игр без экранов.',
                'body' => 'Творческие занятия развивают самовыражение и помогают ребёнку проживать эмоции через игру.',
                'image_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=80',
                'tags' => ['творчество', 'развитие'],
            ],
            [
                'slug' => 'novinki-sezona-v-toybox',
                'title' => 'Новинки сезона в ToyBox',
                'excerpt' => 'Обзор свежих поступлений: от семейных игр до развивающих наборов.',
                'body' => 'Каждый месяц мы обновляем витрину и отмечаем товары, которые особенно нравятся родителям.',
                'image_url' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?auto=format&fit=crop&w=900&q=80',
                'tags' => ['новинки', 'обзор'],
            ],
            [
                'slug' => 'kak-organizovat-igrovuyu-zonu',
                'title' => 'Как организовать игровую зону дома',
                'excerpt' => 'Хранение, зонирование и ротация игрушек без лишнего хаоса.',
                'body' => 'Оставляйте на виду 5–7 любимых игрушек, остальное убирайте в коробки и меняйте набор раз в две недели.',
                'image_url' => 'https://images.unsplash.com/photo-1515488042361-ee00e17ddd4f?auto=format&fit=crop&w=900&q=80',
                'tags' => ['дом', 'организация'],
            ],
            [
                'slug' => 'igrushki-dlya-dvizheniya',
                'title' => 'Игрушки для активных игр на улице',
                'excerpt' => 'Мячи, каталки и игры, которые помогают выплеснуть энергию.',
                'body' => 'Движение укрепляет координацию и настроение — выбирайте игрушки по возрасту и площадке.',
                'image_url' => 'https://images.unsplash.com/photo-1503454537845-7e8b5b2374ea?auto=format&fit=crop&w=900&q=80',
                'tags' => ['активность', 'улица'],
            ],
            [
                'slug' => 'ekonomiya-na-igrushkah-bez-potery-kachestva',
                'title' => 'Как экономить на игрушках без потери качества',
                'excerpt' => 'Акции, промокоды и выбор универсальных наборов на несколько лет.',
                'body' => 'Следите за распродажами, покупайте базовые наборы и дополняйте их тематическими фигурками по мере роста ребёнка.',
                'image_url' => 'https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?auto=format&fit=crop&w=900&q=80',
                'tags' => ['акции', 'советы'],
            ],
        ])->each(fn (array $article) => Article::query()->updateOrCreate(
            ['slug' => $article['slug']],
            [
                ...$article,
                'is_published' => true,
                'published_at' => now()->subDays(random_int(1, 30)),
            ],
        ));

        Promotion::query()->updateOrCreate(
            ['slug' => 'spring-family-sale'],
            [
                'title' => 'Семейная распродажа',
                'discount_label' => 'до -30%',
                'description' => 'Скидки на хиты продаж и развивающие игрушки для разных возрастов.',
                'is_active' => true,
                'starts_at' => now()->subDays(3),
                'ends_at' => now()->addDays(14),
            ],
        );

        PromoCode::query()->updateOrCreate(
            ['code' => 'TOYBOX10'],
            [
                'type' => 'percent',
                'value' => 10,
                'min_order_amount' => 1500,
                'usage_limit' => 500,
                'is_active' => true,
                'expires_at' => now()->addMonth(),
            ],
        );

        Review::query()->updateOrCreate(
            ['email' => 'parent@example.com', 'product_id' => Product::query()->where('slug', 'mishka-sonya')->value('id')],
            [
                'user_id' => null,
                'author_name' => 'Мария',
                'rating' => 5,
                'body' => 'Очень мягкий мишка, ребёнок быстро к нему привык. Доставка аккуратная.',
                'status' => 'approved',
                'approved_at' => now(),
            ],
        );

        collect([
            'store_name' => ['value' => 'ToyBox', 'group' => 'general'],
            'manager_phone' => ['value' => '+79005553535', 'group' => 'contacts'],
            'display_phone' => ['value' => '+7 900 555-35-35', 'group' => 'contacts'],
            'email' => ['value' => 'hello@toybox.test', 'group' => 'contacts'],
            'address' => ['value' => 'Москва, ул. Игрушечная, 12', 'group' => 'contacts'],
            'work_hours' => ['value' => 'Пн-Вс 10:00-21:00', 'group' => 'contacts'],
            'mission' => ['value' => 'Помогаем родителям выбирать безопасные игрушки, которые радуют детей и развивают навыки через игру.', 'group' => 'about'],
        ])->each(fn (array $setting, string $key) => StoreSetting::query()->updateOrCreate(['key' => $key], $setting));
    }
}
