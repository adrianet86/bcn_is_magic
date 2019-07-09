<?php


namespace App\Posting\Domain\Model\Caption;


interface CaptionRepository
{
    /**
     * @param string $locale
     * @return Caption
     * @throws LocaleNotFoundException
     */
    public function rand($locale = null): Caption;
}