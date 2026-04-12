<?php

namespace App\Support;

final class SectionKey
{
    public const Hero = 'hero';

    public const Services = 'services';

    public const Advantages = 'advantages';

    public const HowWeWork = 'how_we_work';

    public const Quiz = 'quiz';

    public const Gallery = 'gallery';

    public const Reviews = 'reviews';

    public const Faq = 'faq';

    public const About = 'about';

    public const Contacts = 'contacts';

    /**
     * @return list<string>
     */
    public static function ordered(): array
    {
        return [
            self::Hero,
            self::Services,
            self::Advantages,
            self::HowWeWork,
            self::Quiz,
            self::Gallery,
            self::Reviews,
            self::Faq,
            self::About,
            self::Contacts,
        ];
    }
}
