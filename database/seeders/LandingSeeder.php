<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\Advantage;
use App\Models\ContactSetting;
use App\Models\FaqItem;
use App\Models\GalleryItem;
use App\Models\HeroSection;
use App\Models\PolicyPage;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\Review;
use App\Models\ScriptSetting;
use App\Models\SectionSetting;
use App\Models\SeoSetting;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\WorkStep;
use App\Support\SectionKey;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->create([
            'site_name' => 'АкваПро — ремонт санузлов под ключ · Минск',
            'header_cta_label' => 'Смета под ключ',
            'header_messenger_label' => 'Написать',
            'footer_cta_label' => 'Заявка на ремонт под ключ',
            'footer_note' => 'Ремонт санузла, ванной и туалета под ключ в Минске: смета с ценой по этапам, работа с вашим материалом или закупка нами, выезд плиточника на дом. Минский район и Минская область — по договору и гарантии.',
        ]);

        ContactSetting::query()->create([
            'phone' => '+375 (29) 000-00-00',
            'email' => 'info@example.by',
            'address' => 'г. Минск, выезд по городу и области',
            'work_schedule' => "Пн–Вс: 8:00–22:00\nВыезд на замер и оценку — по записи",
            'telegram_url' => 'https://t.me/',
            'whatsapp_url' => 'https://wa.me/',
            'viber_url' => 'viber://chat?number=%2B375290000000',
        ]);

        SeoSetting::query()->create([
            'meta_title' => 'Ремонт санузла под ключ в Минске — цена, ванная, плитка, плиточник',
            'meta_description' => 'Ремонт санузла и ванной под ключ в Минске: стоимость по смете, укладка плитки и плиточные работы, отделка с материалом или по вашему списку. Плиточник на дом, Минский район и область.',
            'canonical_url' => config('app.url'),
            'robots' => 'index,follow',
            'og_title' => 'Ремонт санузла под ключ в Минске — АкваПро',
            'og_description' => 'Санузел и ванная под ключ: цена после замера, гидроизоляция, демонтаж плитки, инсталляция, керамогранит и мозаика. Частный плиточник и бригада.',
            'og_type' => 'website',
            'twitter_card' => 'summary_large_image',
        ]);

        ScriptSetting::query()->create([]);

        HeroSection::query()->create([
            'background_image_path' => null,
            'gradient_preset' => null,
            'headline' => 'Ремонт санузла под ключ в Минске — ванная, туалет, плитка',
            'subheadline' => 'Один подрядчик на весь цикл: демонтаж, гидроизоляция, укладка плитки и керамогранита, монтаж инсталляции и сантехники, отделка санузла. Выезд частного плиточника и бригады на дом — Минск, Минский район, Минская область.',
            'offer_text' => 'Формат «под ключ»: фиксируем объём в договоре, называем стоимость ремонта санузла и ванной по этапам до старта. Ремонт с материалом (закупка нами) или работа по вашему списку — как удобнее.',
            'trust_badges' => [
                'Санузел и ванная под ключ — одна ответственность',
                'Стоимость укладки плитки и работ — в открытой смете',
                'Маленький санузел, душевой поддон из плитки, мозаика',
            ],
            'urgency_label' => 'Старт работ после согласования сметы',
            'guarantee_label' => 'Гарантия на работы по договору',
            'show_lead_form' => true,
        ]);

        AboutSection::query()->create([
            'title' => 'Ремонт ванной и санузла под ключ — быстро, качественно недорого',
            'subtitle' => 'Плиточник на дом для замера, смета на ремонт санузла и ванной до начала, отделка с материалом или по вашей закупке.',
            'body' => '<p>Берём ремонт ванной и санузла под ключ с понятной сметой и фиксированными этапами: вы заранее видите объём работ, сроки и ориентир по бюджету.</p><ul class="mt-3 list-disc space-y-2 pl-5"><li>полный цикл работ: демонтаж, подготовка оснований, гидроизоляция, облицовка, сантехника;</li><li>аккуратная укладка плитки и керамогранита с ровной геометрией и чистыми швами;</li><li>работаем с вашим материалом или берём закупку на себя — как удобнее и выгоднее;</li><li>чёткая коммуникация: отчёт по этапам, согласование изменений до выполнения;</li><li>гарантия на выполненные работы по договору.</li></ul><p class="mt-4">Оставьте заявку — подскажем ориентир по стоимости и предложим удобное время выезда на замер.</p>',
            'stats' => [
                'Формат' => 'Под ключ и по смете',
                'Средняя оценка' => '4.9 / 5',
                'География' => 'Минск · Минский р-н · область',
            ],
            'is_published' => true,
        ]);

        $order = 0;
        $sectionGradients = [
            SectionKey::Gallery => 'brand_soft',
            SectionKey::Quiz => 'quiz_panel',
        ];
        foreach (SectionKey::ordered() as $key) {
            SectionSetting::query()->create([
                'section_key' => $key,
                'is_enabled' => true,
                'sort_order' => $order++,
                'gradient_preset' => $sectionGradients[$key] ?? null,
            ]);
        }

        // Каталог услуг заполняется миграцией replace_services_with_renovation_catalog
        // из database/seeders/data/renovation_services.php — здесь не дублируем.

        $advantages = [
            ['title' => 'Под ключ в одном договоре', 'description' => 'Ремонт санузла и ванной от демонтажа до сдачи — не собираем подрядчиков с улицы.', 'icon' => '✓'],
            ['title' => 'Цена и стоимость в смете', 'description' => 'Ремонт санузла цена, стоимость укладки плитки за м² и этапы — до начала работ, правки только по согласованию.', 'icon' => '✓'],
            ['title' => 'С материалом или ваш список', 'description' => 'Ремонт санузла с материалом под ключ или работа по вашей закупке — как удобнее по бюджету.', 'icon' => '✓'],
        ];
        $sort = 0;
        foreach ($advantages as $a) {
            Advantage::query()->create([...$a, 'sort_order' => $sort++, 'is_published' => true]);
        }

        $steps = [
            ['title' => 'Заявка: санузел под ключ', 'description' => 'Кратко опишите задачу — ремонт ванной под ключ, только плитка или ванная под ключ цена после осмотра.'],
            ['title' => 'Замер и смета с ценой', 'description' => 'Плиточник на дом в Минске или в области: замер, смета на ремонт санузла, стоимость плиточных работ и сроки.'],
            ['title' => 'Работы под ключ', 'description' => 'Демонтаж плитки в ванной при необходимости, гидроизоляция, укладка керамогранита и мозаики, монтаж инсталляции, сдача этапов.'],
            ['title' => 'Сдача и гарантия', 'description' => 'Акт, фиксация выполненного объёма под ключ, гарантия по договору.'],
        ];
        $sort = 0;
        foreach ($steps as $st) {
            WorkStep::query()->create([...$st, 'sort_order' => $sort++, 'is_published' => true]);
        }

        Review::query()->create([
            'author' => 'Марина К.',
            'body' => 'Санузел под ключ сделали за короткий срок: идеальная укладка плитки, ровные швы и аккуратная отделка ванной. Качество работ выше ожиданий, всё сдали точно по графику.',
            'rating' => 5,
            'reviewed_on' => now()->subDays(12),
            'sort_order' => 0,
            'is_published' => true,
        ]);
        Review::query()->create([
            'author' => 'Андрей Л.',
            'body' => 'Заказывали отделочные работы в ванной под ключ: плитку уложили идеально, геометрия и примыкания без замечаний. Бригада уложилась в сжатые сроки и сохранила высокий уровень качества на каждом этапе.',
            'rating' => 5,
            'reviewed_on' => now()->subDays(40),
            'sort_order' => 1,
            'is_published' => true,
        ]);
        Review::query()->create([
            'author' => 'Ольга В.',
            'body' => 'В маленьком санузле выполнили полный ремонт и чистовую отделку ванной очень быстро. Плитка уложена безупречно, всё сделано аккуратно и качественно, результат выглядит как в проекте.',
            'rating' => 5,
            'reviewed_on' => now()->subDays(5),
            'sort_order' => 2,
            'is_published' => true,
        ]);

        FaqItem::query()->create([
            'question' => 'Что входит в ремонт санузла под ключ в Минске?',
            'answer' => 'Обычно: демонтаж старой отделки при необходимости, подготовка оснований, гидроизоляция ванной комнаты, укладка плитки, монтаж инсталляции и сантехники, затирка, сдача. Точный перечень фиксируем в смете и договоре.',
            'sort_order' => 0,
            'is_published' => true,
        ]);
        FaqItem::query()->create([
            'question' => 'Как узнать стоимость ремонта санузла и цену укладки плитки?',
            'answer' => 'После замера или детальных фото считаем стоимость ремонта санузла и ванной по этапам, отдельно — укладку плитки (м²) и материалы. Ориентир по телефону возможен, итог — в смете.',
            'sort_order' => 1,
            'is_published' => true,
        ]);
        FaqItem::query()->create([
            'question' => 'Делаете ли ремонт санузла с материалом и ванную под ключ с ценой?',
            'answer' => 'Да: можем взять закупку на себя по согласованной смете или работать по вашему списку. Ванная под ключ цена и санузел под ключ Минск — прописываются до старта.',
            'sort_order' => 2,
            'is_published' => true,
        ]);
        FaqItem::query()->create([
            'question' => 'Есть ли плиточник на дом и частный плиточник в команде?',
            'answer' => 'Выезд на объект в Минске, Минском районе и по области — для замера и работ. Состав бригады согласуем под объём: от частного мастера до полной бригады под ключ.',
            'sort_order' => 3,
            'is_published' => true,
        ]);
        FaqItem::query()->create([
            'question' => 'Сколько длятся ремонт ванной и туалета под ключ?',
            'answer' => 'Зависит от площади и объёма: типичный санузел 4–6 м² — порядка 2–4 недель с учётом высыхания стяжек и гидроизоляции. Маленький санузел может быть быстрее при простом сценарии.',
            'sort_order' => 4,
            'is_published' => true,
        ]);
        FaqItem::query()->create([
            'question' => 'Работаете ли по Минскому району и Минской области?',
            'answer' => 'Да, выезжаем по Минску, Минскому району и точечно по Минской области. Сроки и логистику закладываем в смету заранее.',
            'sort_order' => 5,
            'is_published' => true,
        ]);

        PolicyPage::query()->create([
            'slug' => 'privacy',
            'title' => 'Политика конфиденциальности',
            'content' => '<p>Мы обрабатываем персональные данные в соответствии с законодательством. Контакт для запросов: указанный на сайте email.</p>',
            'is_published' => true,
        ]);
        PolicyPage::query()->create([
            'slug' => 'terms',
            'title' => 'Публичная оферта',
            'content' => '<p>Текст оферты размещается для ознакомления. Актуальные условия предоставляет диспетчер при подтверждении заказа.</p>',
            'is_published' => true,
        ]);

        SocialLink::query()->create([
            'label' => 'Instagram',
            'url' => 'https://instagram.com/',
            'icon' => 'heroicon-o-camera',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $q1 = QuizQuestion::query()->create(['question' => 'Какой формат ремонта нужен?', 'sort_order' => 0, 'is_published' => true]);
        QuizOption::query()->create(['quiz_question_id' => $q1->id, 'label' => 'Ремонт санузла или ванной под ключ с ценой в смете', 'weight' => 3, 'sort_order' => 0]);
        QuizOption::query()->create(['quiz_question_id' => $q1->id, 'label' => 'Плиточные работы / укладка плитки и отделка', 'weight' => 2, 'sort_order' => 1]);
        QuizOption::query()->create(['quiz_question_id' => $q1->id, 'label' => 'Замер, консультация или точечные работы', 'weight' => 0, 'sort_order' => 2]);

        $q2 = QuizQuestion::query()->create(['question' => 'Когда хотите начать?', 'sort_order' => 1, 'is_published' => true]);
        QuizOption::query()->create(['quiz_question_id' => $q2->id, 'label' => 'В ближайшие 1–2 недели', 'weight' => 3, 'sort_order' => 0]);
        QuizOption::query()->create(['quiz_question_id' => $q2->id, 'label' => 'В течение месяца', 'weight' => 1, 'sort_order' => 1]);
        QuizOption::query()->create(['quiz_question_id' => $q2->id, 'label' => 'Пока только оценка и смета', 'weight' => 0, 'sort_order' => 2]);

        QuizResult::query()->create([
            'title' => 'Ремонт санузла под ключ',
            'description' => 'Комплексный сценарий — смета на ремонт санузла и ванной под ключ, стоимость этапов и сроки до старта.',
            'min_score' => 5,
            'max_score' => 6,
            'recommended_service_id' => Service::query()->where('slug', 'remont-sanuzla-pod-klyuch')->value('id'),
            'sort_order' => 0,
            'is_published' => true,
        ]);
        QuizResult::query()->create([
            'title' => 'Плиточные работы под ключ',
            'description' => 'Укладка плитки, керамогранита и мозаики с подготовкой основания и гидроизоляцией — оценим стоимость плиточных работ за м² и объём.',
            'min_score' => 2,
            'max_score' => 4,
            'recommended_service_id' => Service::query()->where('slug', 'plitochnye-raboty')->value('id'),
            'sort_order' => 1,
            'is_published' => true,
        ]);
        QuizResult::query()->create([
            'title' => 'Выезд плиточника и консультация',
            'description' => 'Запишем выезд на замер: ориентир по ремонту ванной цена, укладке плитки и санузлу под ключ без обязательства сразу начинать.',
            'min_score' => 0,
            'max_score' => 1,
            'recommended_service_id' => Service::query()->where('slug', 'srochnyj-vyezd')->value('id'),
            'sort_order' => 2,
            'is_published' => true,
        ]);
    }
}
