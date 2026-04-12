<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('header_cta_label')->default('Вызвать мастера');
            $table->string('header_messenger_label')->default('Написать');
            $table->string('footer_cta_label')->nullable();
            $table->text('footer_note')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->text('work_schedule')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->string('viber_url')->nullable();
            $table->timestamps();
        });

        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('robots')->default('index,follow');
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('og_type')->default('website');
            $table->string('twitter_card')->default('summary_large_image');
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('script_settings', function (Blueprint $table) {
            $table->id();
            $table->string('google_analytics_id')->nullable();
            $table->string('google_tag_manager_id')->nullable();
            $table->string('yandex_metrika_id')->nullable();
            $table->text('head_scripts')->nullable();
            $table->text('body_start_scripts')->nullable();
            $table->text('body_end_scripts')->nullable();
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->string('subheadline')->nullable();
            $table->text('offer_text')->nullable();
            $table->json('trust_badges')->nullable();
            $table->string('urgency_label')->nullable();
            $table->string('guarantee_label')->nullable();
            $table->boolean('show_lead_form')->default(true);
            $table->timestamps();
        });

        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('body');
            $table->string('image_path')->nullable();
            $table->json('stats')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->string('price_from')->nullable();
            $table->string('icon')->nullable();
            $table->string('image_path')->nullable();
            $table->string('cta_label')->default('Заказать');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('work_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->text('body');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->date('reviewed_on')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('faq_items', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('policy_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_question_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->unsignedSmallInteger('weight')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('min_score')->default(0);
            $table->unsignedSmallInteger('max_score')->default(0);
            $table->foreignId('recommended_service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->text('comment')->nullable();
            $table->string('service_type')->nullable();
            $table->string('urgency')->nullable();
            $table->string('location')->nullable();
            $table->string('form_source')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('status')->default('new');
            $table->text('manager_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('quiz_results');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('section_settings');
        Schema::dropIfExists('policy_pages');
        Schema::dropIfExists('faq_items');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('work_steps');
        Schema::dropIfExists('advantages');
        Schema::dropIfExists('services');
        Schema::dropIfExists('about_sections');
        Schema::dropIfExists('hero_sections');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('script_settings');
        Schema::dropIfExists('seo_settings');
        Schema::dropIfExists('contact_settings');
        Schema::dropIfExists('site_settings');
    }
};
