<?php


namespace App\Posting\Infrastructure\File\Caption;


use App\Posting\Domain\Model\Caption\Caption;
use App\Posting\Domain\Model\Caption\CaptionRepository;
use App\Posting\Domain\Model\Caption\LocaleNotFoundException;

class FileCaptionRepository implements CaptionRepository
{
    const MAIN_LOCALE = 'en_US';

    private array $en_US = [
        "City of stars, are you shining just for me?",
        "I fell in love, her name is Barcelona.",
        "Wanderlust and city dust.",
        "My kind of town.",
        "A concrete version of paradise.",
        "These streets will make you feel brand new.",
        "Hello city, your lights are fireflies in my heart.",
        "It's the rule of life that everything you have always wanted comes the very second you stop looking for it.",
        "I love places that make you realize how tiny you and your problems are.",
        "I'm just a small town girl with big city dreams.",
        "I'd like a cheeseburger, please, large fries, and a cosmopolitan.",
        "We are the dreamers of dreams.",
        "The dream is free. The hustle is sold separately.",
        "Go where you feel most alive.",
        "Nothing beautiful asks for attention.",
        "There's no time to be bored in a world as beautiful as this.",
        "Wherever you are, be all there.",
        "Fall in love with as many things as possible.",
        "But first, coffee.",
        "Walking through a concrete jungle.",
        "All you need is love and skylines.",
        "Bright lights, big city.",
        "No sleep in the city.",
        "Thank you for making me feel so alive.",
        "These sidewalks are like a runway.",
        "I'm in love with cities I've never been to and people I've never met.",
        "Those bright lights are my sunshine.",
        "Wake up and live.",
        "Making a stop at Central Perk.",
        "Exist loudly.",
        "I haven't been everywhere, but it's on my list.",
        "Wherever you go becomes a part of you somehow.",
        "Work hard, travel harder.",
        "Wander often, wonder always.",
        "We travel not to escape life, but for life not to escape us.",
        "A journey is best measured in friends rather than miles.",
        "It is not down in any map; true places never are.",
        "Take me anywhere.",
        "Wherever you go becomes a part of you somehow.",
        "Wherever you go, go with all your heart.",
        "We have nothing to lose, and a world to see.",
        "Where you lead, I will follow.",
        "Finding paradise wherever I go.",
        "Do what you love and you will never be late.",
        "Catch flights, not feelings.",
        "People don’t take trips, trips take people.",
        "Great things never came from comfort zones.",
        "It’s about the journey, not the destination.",
        "Keep calm and travel on.",
        "I haven’t been everywhere, but it’s on my list.",
        "Wanderlust: A desire to travel, to understand one’s very existence.",
        "I do believe it’s time for another adventure.",
        "Because when you stop and look around, this life is pretty amazing.",
        "We dream in colors borrowed from the sea.",
        "If it scares you, it might be a good thing to try.",
        "The tans will fade, but the memories will last forever.",
        "In the end, we only regret the chances we didn’t take.",
        "You don’t need magic to disappear, all you need is a destination.",
        "Born to explore the world.",
        "One life. One world. Explore it.",
        "Travel far enough, you meet yourself.",
        "Find a beautiful place, and get lost.",
        "Let the adventure begin.",
        "Travel while you’re young and able.",
        "Never stop exploring.",
        "I want to make memories all over the world.",
        "Travel is the healthiest addiction."
    ];

    private array $captions;

    public function __construct()
    {
        $this->captions['en_US'] = $this->en_US;
    }

    /**
     * @param string $locale
     * @return Caption
     * @throws LocaleNotFoundException
     */
    public function rand($locale = null): Caption
    {
        if (is_null($locale)) {
            $locale = $this->getRandLocale();
        }

        if (!isset($this->captions[$locale])) {
            throw new LocaleNotFoundException('LOCALE NOT FOUND: ' . $locale);
        }

        $total = count($this->captions[$locale]);
        $pos = rand(0, $total);

        return new Caption($this->captions[$locale][$pos], $locale);
    }

    private function getRandLocale(): string
    {
        return self::MAIN_LOCALE;
    }
}