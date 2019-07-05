<?php


namespace Unit\Posting\Infrastructure\Api\Image;


use PHPUnit\Framework\TestCase;
use App\Posting\Infrastructure\Api\Image\UnsplashImageConverter;

class UnsplashImageConverterTest extends TestCase
{
    public function testItParsesJsonToImage()
    {
        $providerId = "N6HTCyN50p0";
        $postedAt = "2018-04-12T07:08:49-04:00";
        $description = "Spring in Barcelona";

        $unsplashJson = "{\"id\":\"$providerId\",\"created_at\":\"$postedAt\",\"updated_at\":\"2019-06-28T01:09:38-04:00\",\"width\":4804,\"height\":3203,\"color\":\"#0A0A16\",\"description\":\"$description\",\"alt_description\":\"group of people walking near brown church\",\"urls\":{\"raw\":\"https:\/\/images.unsplash.com\/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjc5MjE4fQ\",\"full\":\"https:\/\/images.unsplash.com\/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjc5MjE4fQ\",\"regular\":\"https:\/\/images.unsplash.com\/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjc5MjE4fQ\",\"small\":\"https:\/\/images.unsplash.com\/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjc5MjE4fQ\",\"thumb\":\"https:\/\/images.unsplash.com\/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjc5MjE4fQ\"},\"links\":{\"self\":\"https:\/\/api.unsplash.com\/photos\/N6HTCyN50p0\",\"html\":\"https:\/\/unsplash.com\/photos\/N6HTCyN50p0\",\"download\":\"https:\/\/unsplash.com\/photos\/N6HTCyN50p0\/download\",\"download_location\":\"https:\/\/api.unsplash.com\/photos\/N6HTCyN50p0\/download\"},\"categories\":[],\"sponsored\":false,\"sponsored_by\":null,\"sponsored_impressions_id\":null,\"likes\":55,\"liked_by_user\":false,\"current_user_collections\":[],\"user\":{\"id\":\"xMDOG_F7JoQ\",\"updated_at\":\"2019-06-15T04:18:30-04:00\",\"username\":\"corneschi\",\"name\":\"Daniel Corneschi\",\"first_name\":\"Daniel\",\"last_name\":\"Corneschi\",\"twitter_username\":null,\"portfolio_url\":null,\"bio\":null,\"location\":\"Timisoara\",\"links\":{\"self\":\"https:\/\/api.unsplash.com\/users\/corneschi\",\"html\":\"https:\/\/unsplash.com\/@corneschi\",\"photos\":\"https:\/\/api.unsplash.com\/users\/corneschi\/photos\",\"likes\":\"https:\/\/api.unsplash.com\/users\/corneschi\/likes\",\"portfolio\":\"https:\/\/api.unsplash.com\/users\/corneschi\/portfolio\",\"following\":\"https:\/\/api.unsplash.com\/users\/corneschi\/following\",\"followers\":\"https:\/\/api.unsplash.com\/users\/corneschi\/followers\"},\"profile_image\":{\"small\":\"https:\/\/images.unsplash.com\/profile-1516695245035-4ea0bb9b4874?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32\",\"medium\":\"https:\/\/images.unsplash.com\/profile-1516695245035-4ea0bb9b4874?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64\",\"large\":\"https:\/\/images.unsplash.com\/profile-1516695245035-4ea0bb9b4874?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128\"},\"instagram_username\":null,\"total_collections\":8,\"total_likes\":5,\"total_photos\":45,\"accepted_tos\":true},\"tags\":[{\"title\":\"city\"},{\"title\":\"spain\"},{\"title\":\"park g\u00fcell\"},{\"title\":\"architecture\"},{\"title\":\"tower\"},{\"title\":\"building\"},{\"title\":\"bell tower\"},{\"title\":\"cross\"},{\"title\":\"sunshine\"},{\"title\":\"sunlight\"},{\"title\":\"village\"},{\"title\":\"house\"},{\"title\":\"villa\"},{\"title\":\"housing\"},{\"title\":\"plant\"},{\"title\":\"flora\"},{\"title\":\"pottery\"},{\"title\":\"jar\"},{\"title\":\"potted plant\"},{\"title\":\"vase\"}]}";

        $image = UnsplashImageConverter::convert($unsplashJson);

        $this->assertEquals($providerId, $image->providerId());
        $this->assertEquals($description, $image->description());
        // TODO: continue asserts
    }
}