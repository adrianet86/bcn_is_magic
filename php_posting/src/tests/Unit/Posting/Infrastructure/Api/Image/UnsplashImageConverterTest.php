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

//        $image = UnsplashImageConverter::convert($unsplashJson);
        $image = UnsplashImageConverter::convert($this->getUnsplashJson());

        $this->assertNotNull($image->providerId());
        $this->assertNotNull($image->provider());
        $this->assertNotNull($image->description());
        $this->assertNotNull($image->providerUrl());
        $this->assertNotNull($image->location());
        $this->assertNotNull($image->author());
        $this->assertNotEquals(0, $image->views());
        $this->assertNotEquals(0, $image->downloads());
    }

    private function getUnsplashJson(): string
    {
        return '{
    "id": "s2q1_cxLHSE",
    "created_at": "2018-06-11T15:22:24-04:00",
    "updated_at": "2019-07-07T01:07:54-04:00",
    "width": 2736,
    "height": 3420,
    "color": "#08E2F9",
    "description": "On my holidays in Barcelona, I fall lost in love with the architecture of Antoni Gaudi, for example, this historical building made for Pere Milà y Roser Segimon it’s know as “La pedrera” for his architecture, but the original name is “Casa Milá”.",
    "alt_description": "beige and gray concrete building",
    "urls": {
        "raw": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjc5MjE4fQ",
        "full": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjc5MjE4fQ",
        "regular": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjc5MjE4fQ",
        "small": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjc5MjE4fQ",
        "thumb": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjc5MjE4fQ"
    },
    "links": {
        "self": "https://api.unsplash.com/photos/s2q1_cxLHSE",
        "html": "https://unsplash.com/photos/s2q1_cxLHSE",
        "download": "https://unsplash.com/photos/s2q1_cxLHSE/download",
        "download_location": "https://api.unsplash.com/photos/s2q1_cxLHSE/download"
    },
    "categories": [],
    "sponsored": false,
    "sponsored_by": null,
    "sponsored_impressions_id": null,
    "likes": 101,
    "liked_by_user": false,
    "current_user_collections": [],
    "user": {
        "id": "ekwiCAZsk24",
        "updated_at": "2019-07-02T17:41:10-04:00",
        "username": "florenciapotter",
        "name": "Florencia Potter",
        "first_name": "Florencia",
        "last_name": "Potter",
        "twitter_username": "florenciapotter",
        "portfolio_url": "http://instagram.com/florenciapotter",
        "bio": "www.behance.net/florencialibertini // Digital Creative and Art Director based in Buenos Aires. I love art direction and make projects with friends. Do you wanna be my friend? Lets get in touch for awesome ideas.",
        "location": "Buenos Aires, Argentina",
        "links": {
            "self": "https://api.unsplash.com/users/florenciapotter",
            "html": "https://unsplash.com/@florenciapotter",
            "photos": "https://api.unsplash.com/users/florenciapotter/photos",
            "likes": "https://api.unsplash.com/users/florenciapotter/likes",
            "portfolio": "https://api.unsplash.com/users/florenciapotter/portfolio",
            "following": "https://api.unsplash.com/users/florenciapotter/following",
            "followers": "https://api.unsplash.com/users/florenciapotter/followers"
        },
        "profile_image": {
            "small": "https://images.unsplash.com/profile-fb-1497025971-57d420394c4e.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
            "medium": "https://images.unsplash.com/profile-fb-1497025971-57d420394c4e.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
            "large": "https://images.unsplash.com/profile-fb-1497025971-57d420394c4e.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
        },
        "instagram_username": "florenciapotter",
        "total_collections": 3,
        "total_likes": 16,
        "total_photos": 43,
        "accepted_tos": true
    },
    "exif": {
        "make": "Canon",
        "model": "Canon EOS 6D",
        "exposure_time": "1/1000",
        "aperture": "6.3",
        "focal_length": "24.0",
        "iso": 100
    },
    "location": {
        "title": "LA PEDRERA, Barcelona, Spain",
        "name": "LA PEDRERA",
        "city": "Barcelona",
        "country": "Spain",
        "position": {
            "latitude": 41.39468,
            "longitude": 2.16165000000001
        }
    },
    "tags": [
        {
            "title": "barcelona"
        },
        {
            "title": "city"
        },
        {
            "title": "building"
        },
        {
            "title": "housing"
        },
        {
            "title": "apartment building"
        },
        {
            "title": "high rise"
        },
        {
            "title": "town"
        },
        {
            "title": "urban"
        },
        {
            "title": "la pedrera"
        },
        {
            "title": "architecture"
        },
        {
            "title": "spain"
        },
        {
            "title": "brick"
        },
        {
            "title": "casa mila"
        },
        {
            "title": "florencia potter"
        },
        {
            "title": "antoni gaudi"
        },
        {
            "title": "gaudi"
        },
        {
            "title": "modernism"
        },
        {
            "title": "florencia libertini"
        },
        {
            "title": "orange teal"
        },
        {
            "title": "explore"
        }
    ],
    "story": {
        "title": null,
        "description": "On my holidays in Barcelona, I fall lost in love with the architecture of Antoni Gaudi, for example, this historical building made for Pere Milà y Roser Segimon it’s know as “La pedrera” for his architecture, but the original name is “Casa Milá”."
    },
    "related_collections": {
        "total": 102,
        "type": "collected",
        "results": [
            {
                "id": 1083981,
                "title": "@wegoindia Instagram Photos",
                "description": "Collection of photos am loving, to repost at @wegoindia Instagram. Travel. Quirky. Personality. Adventures. Moving.",
                "published_at": "2017-08-11T05:27:23-04:00",
                "updated_at": "2019-06-21T06:01:24-04:00",
                "curated": false,
                "featured": false,
                "total_photos": 534,
                "private": false,
                "share_key": "93361360b8d1fd453bc7968fcacc598f",
                "tags": [
                    {
                        "title": "sea"
                    },
                    {
                        "title": "swimming"
                    },
                    {
                        "title": "vacation"
                    },
                    {
                        "title": "blue"
                    },
                    {
                        "title": "beach"
                    },
                    {
                        "title": "summer"
                    }
                ],
                "links": {
                    "self": "https://api.unsplash.com/collections/1083981",
                    "html": "https://unsplash.com/collections/1083981/wegoindia-instagram-photos",
                    "photos": "https://api.unsplash.com/collections/1083981/photos",
                    "related": "https://api.unsplash.com/collections/1083981/related"
                },
                "user": {
                    "id": "JSPS-HFTGKM",
                    "updated_at": "2019-07-04T21:42:53-04:00",
                    "username": "mondakranta",
                    "name": "Mondakranta Saikia",
                    "first_name": "Mondakranta",
                    "last_name": "Saikia",
                    "twitter_username": "mondakrantas",
                    "portfolio_url": "http://outsidemiracles.com",
                    "bio": "IG: @mondakranta",
                    "location": "India",
                    "links": {
                        "self": "https://api.unsplash.com/users/mondakranta",
                        "html": "https://unsplash.com/@mondakranta",
                        "photos": "https://api.unsplash.com/users/mondakranta/photos",
                        "likes": "https://api.unsplash.com/users/mondakranta/likes",
                        "portfolio": "https://api.unsplash.com/users/mondakranta/portfolio",
                        "following": "https://api.unsplash.com/users/mondakranta/following",
                        "followers": "https://api.unsplash.com/users/mondakranta/followers"
                    },
                    "profile_image": {
                        "small": "https://images.unsplash.com/profile-1521520266547-946f6977cc6a?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
                        "medium": "https://images.unsplash.com/profile-1521520266547-946f6977cc6a?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
                        "large": "https://images.unsplash.com/profile-1521520266547-946f6977cc6a?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
                    },
                    "instagram_username": "mondakranta",
                    "total_collections": 10,
                    "total_likes": 12,
                    "total_photos": 1,
                    "accepted_tos": false
                },
                "cover_photo": {
                    "id": "LV3irO4IkMQ",
                    "created_at": "2017-07-25T12:16:08-04:00",
                    "updated_at": "2019-05-17T19:29:11-04:00",
                    "width": 4000,
                    "height": 6000,
                    "color": "#FBFCFB",
                    "description": null,
                    "alt_description": null,
                    "urls": {
                        "raw": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1",
                        "full": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                        "regular": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                        "small": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                        "thumb": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                    },
                    "links": {
                        "self": "https://api.unsplash.com/photos/LV3irO4IkMQ",
                        "html": "https://unsplash.com/photos/LV3irO4IkMQ",
                        "download": "https://unsplash.com/photos/LV3irO4IkMQ/download",
                        "download_location": "https://api.unsplash.com/photos/LV3irO4IkMQ/download"
                    },
                    "categories": [],
                    "sponsored": false,
                    "sponsored_by": null,
                    "sponsored_impressions_id": null,
                    "likes": 23,
                    "liked_by_user": false,
                    "current_user_collections": [],
                    "user": {
                        "id": "EKqOFBS6i6A",
                        "updated_at": "2019-07-04T02:15:31-04:00",
                        "username": "ilsangmoon",
                        "name": "Ilsang Moon",
                        "first_name": "Ilsang",
                        "last_name": "Moon",
                        "twitter_username": null,
                        "portfolio_url": "https://www.ilsangmoon.me/",
                        "bio": "presets available on my website\r\n\r\ninstagram :@ilsangmoon\r\n\r\n contact: ilsang1997@gmail.com",
                        "location": null,
                        "links": {
                            "self": "https://api.unsplash.com/users/ilsangmoon",
                            "html": "https://unsplash.com/@ilsangmoon",
                            "photos": "https://api.unsplash.com/users/ilsangmoon/photos",
                            "likes": "https://api.unsplash.com/users/ilsangmoon/likes",
                            "portfolio": "https://api.unsplash.com/users/ilsangmoon/portfolio",
                            "following": "https://api.unsplash.com/users/ilsangmoon/following",
                            "followers": "https://api.unsplash.com/users/ilsangmoon/followers"
                        },
                        "profile_image": {
                            "small": "https://images.unsplash.com/profile-1500986568126-1279d24e4d3f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
                            "medium": "https://images.unsplash.com/profile-1500986568126-1279d24e4d3f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
                            "large": "https://images.unsplash.com/profile-1500986568126-1279d24e4d3f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
                        },
                        "instagram_username": "ilsangmoon",
                        "total_collections": 0,
                        "total_likes": 2,
                        "total_photos": 6,
                        "accepted_tos": false
                    }
                },
                "preview_photos": [
                    {
                        "id": "LV3irO4IkMQ",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1500999330552-7c8342dc04bf?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "IraVn9L24A0",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1509358033937-2784de2bfed8?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1509358033937-2784de2bfed8?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1509358033937-2784de2bfed8?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1509358033937-2784de2bfed8?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1509358033937-2784de2bfed8?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "avKjb3qy_Lo",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1487945911986-d8cf7e44f023?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1487945911986-d8cf7e44f023?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1487945911986-d8cf7e44f023?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1487945911986-d8cf7e44f023?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1487945911986-d8cf7e44f023?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "0x0VZNQzWAo",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1519906448142-1176f5530f5d?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1519906448142-1176f5530f5d?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1519906448142-1176f5530f5d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1519906448142-1176f5530f5d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1519906448142-1176f5530f5d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    }
                ]
            },
            {
                "id": 3609898,
                "title": "Barcelona",
                "description": null,
                "published_at": "2018-12-02T08:02:11-05:00",
                "updated_at": "2018-12-02T08:02:50-05:00",
                "curated": false,
                "featured": false,
                "total_photos": 5,
                "private": false,
                "share_key": "db11f41e7d3135846ef56922b83025a4",
                "tags": [
                    {
                        "title": "barcelona"
                    },
                    {
                        "title": "architecture"
                    },
                    {
                        "title": "building"
                    },
                    {
                        "title": "city"
                    },
                    {
                        "title": "blue"
                    },
                    {
                        "title": "cityscape"
                    }
                ],
                "links": {
                    "self": "https://api.unsplash.com/collections/3609898",
                    "html": "https://unsplash.com/collections/3609898/barcelona",
                    "photos": "https://api.unsplash.com/collections/3609898/photos",
                    "related": "https://api.unsplash.com/collections/3609898/related"
                },
                "user": {
                    "id": "4hW7Fl21hVg",
                    "updated_at": "2018-12-02T08:03:06-05:00",
                    "username": "laiamart",
                    "name": "Laia Martinez",
                    "first_name": "Laia",
                    "last_name": "Martinez",
                    "twitter_username": null,
                    "portfolio_url": null,
                    "bio": null,
                    "location": null,
                    "links": {
                        "self": "https://api.unsplash.com/users/laiamart",
                        "html": "https://unsplash.com/@laiamart",
                        "photos": "https://api.unsplash.com/users/laiamart/photos",
                        "likes": "https://api.unsplash.com/users/laiamart/likes",
                        "portfolio": "https://api.unsplash.com/users/laiamart/portfolio",
                        "following": "https://api.unsplash.com/users/laiamart/following",
                        "followers": "https://api.unsplash.com/users/laiamart/followers"
                    },
                    "profile_image": {
                        "small": "https://images.unsplash.com/profile-fb-1516699501-19ef08ae5f8d.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
                        "medium": "https://images.unsplash.com/profile-fb-1516699501-19ef08ae5f8d.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
                        "large": "https://images.unsplash.com/profile-fb-1516699501-19ef08ae5f8d.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
                    },
                    "instagram_username": null,
                    "total_collections": 3,
                    "total_likes": 0,
                    "total_photos": 0,
                    "accepted_tos": false
                },
                "cover_photo": {
                    "id": "qulKaJxq1gQ",
                    "created_at": "2017-11-19T11:21:45-05:00",
                    "updated_at": "2019-06-21T01:08:59-04:00",
                    "width": 3956,
                    "height": 2637,
                    "color": "#D6CED5",
                    "description": "I had spent my entire trip in Barcelona looking up through the deep alleyways and corridors to find those great shots. This was on my last day at the end of my time before I went to meet a friend, I laughed when I took this because this is the best and last photo I took when I was there, having to crane my neck up one last time.",
                    "alt_description": "condominiums during daytime",
                    "urls": {
                        "raw": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1",
                        "full": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                        "regular": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                        "small": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                        "thumb": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                    },
                    "links": {
                        "self": "https://api.unsplash.com/photos/qulKaJxq1gQ",
                        "html": "https://unsplash.com/photos/qulKaJxq1gQ",
                        "download": "https://unsplash.com/photos/qulKaJxq1gQ/download",
                        "download_location": "https://api.unsplash.com/photos/qulKaJxq1gQ/download"
                    },
                    "categories": [],
                    "sponsored": false,
                    "sponsored_by": null,
                    "sponsored_impressions_id": null,
                    "likes": 55,
                    "liked_by_user": false,
                    "current_user_collections": [],
                    "user": {
                        "id": "SBTbNMm0p2A",
                        "updated_at": "2019-07-07T12:56:12-04:00",
                        "username": "joshua_humphrey",
                        "name": "Joshua Humphrey",
                        "first_name": "Joshua",
                        "last_name": "Humphrey",
                        "twitter_username": "Joshuahumphrey1",
                        "portfolio_url": "http://jhumphreyimages.com",
                        "bio": "Round the world Photographer. More stuff on my instagram: @joshuahumphreyphoto",
                        "location": "United Kingdom",
                        "links": {
                            "self": "https://api.unsplash.com/users/joshua_humphrey",
                            "html": "https://unsplash.com/@joshua_humphrey",
                            "photos": "https://api.unsplash.com/users/joshua_humphrey/photos",
                            "likes": "https://api.unsplash.com/users/joshua_humphrey/likes",
                            "portfolio": "https://api.unsplash.com/users/joshua_humphrey/portfolio",
                            "following": "https://api.unsplash.com/users/joshua_humphrey/following",
                            "followers": "https://api.unsplash.com/users/joshua_humphrey/followers"
                        },
                        "profile_image": {
                            "small": "https://images.unsplash.com/profile-1505646218286-3414b8a9f922?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
                            "medium": "https://images.unsplash.com/profile-1505646218286-3414b8a9f922?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
                            "large": "https://images.unsplash.com/profile-1505646218286-3414b8a9f922?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
                        },
                        "instagram_username": "joshuahumphreyphoto",
                        "total_collections": 1,
                        "total_likes": 29,
                        "total_photos": 73,
                        "accepted_tos": true
                    }
                },
                "preview_photos": [
                    {
                        "id": "qulKaJxq1gQ",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1511108311173-a4a96ea6632c?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "uu2EA5gCALc",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1457207714875-13ef75a801ca?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1457207714875-13ef75a801ca?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1457207714875-13ef75a801ca?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1457207714875-13ef75a801ca?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1457207714875-13ef75a801ca?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "pm3O5KxWKtw",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1507619579562-f2e10da1ec86?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1507619579562-f2e10da1ec86?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1507619579562-f2e10da1ec86?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1507619579562-f2e10da1ec86?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1507619579562-f2e10da1ec86?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "q_TzfAt4NQ8",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1529551739587-e242c564f727?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1529551739587-e242c564f727?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1529551739587-e242c564f727?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1529551739587-e242c564f727?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1529551739587-e242c564f727?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    }
                ]
            },
            {
                "id": 3693725,
                "title": "Barcelona",
                "description": null,
                "published_at": "2018-12-19T07:18:17-05:00",
                "updated_at": "2018-12-19T07:21:41-05:00",
                "curated": false,
                "featured": false,
                "total_photos": 4,
                "private": false,
                "share_key": "e6374df7afb7c8c4b2ff724221dd9f22",
                "tags": [
                    {
                        "title": "barcelona"
                    },
                    {
                        "title": "city"
                    },
                    {
                        "title": "gaudi"
                    },
                    {
                        "title": "architecture"
                    },
                    {
                        "title": "explore"
                    },
                    {
                        "title": "la pedrera"
                    }
                ],
                "links": {
                    "self": "https://api.unsplash.com/collections/3693725",
                    "html": "https://unsplash.com/collections/3693725/barcelona",
                    "photos": "https://api.unsplash.com/collections/3693725/photos",
                    "related": "https://api.unsplash.com/collections/3693725/related"
                },
                "user": {
                    "id": "3GHZAcSvVjw",
                    "updated_at": "2018-12-19T07:18:17-05:00",
                    "username": "hannahspeakeasy",
                    "name": "Hannah Speakeasy",
                    "first_name": "Hannah",
                    "last_name": "Speakeasy",
                    "twitter_username": null,
                    "portfolio_url": null,
                    "bio": null,
                    "location": null,
                    "links": {
                        "self": "https://api.unsplash.com/users/hannahspeakeasy",
                        "html": "https://unsplash.com/@hannahspeakeasy",
                        "photos": "https://api.unsplash.com/users/hannahspeakeasy/photos",
                        "likes": "https://api.unsplash.com/users/hannahspeakeasy/likes",
                        "portfolio": "https://api.unsplash.com/users/hannahspeakeasy/portfolio",
                        "following": "https://api.unsplash.com/users/hannahspeakeasy/following",
                        "followers": "https://api.unsplash.com/users/hannahspeakeasy/followers"
                    },
                    "profile_image": {
                        "small": "https://images.unsplash.com/profile-fb-1545221852-670730fdf37c.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
                        "medium": "https://images.unsplash.com/profile-fb-1545221852-670730fdf37c.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
                        "large": "https://images.unsplash.com/profile-fb-1545221852-670730fdf37c.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
                    },
                    "instagram_username": null,
                    "total_collections": 1,
                    "total_likes": 0,
                    "total_photos": 0,
                    "accepted_tos": false
                },
                "cover_photo": {
                    "id": "psrloDbaZc8",
                    "created_at": "2017-07-12T23:23:31-04:00",
                    "updated_at": "2019-07-07T01:03:31-04:00",
                    "width": 2585,
                    "height": 2585,
                    "color": "#2D261D",
                    "description": "A sunny day in our SF apartment",
                    "alt_description": "brown wooden framed white padded chair in between green indoor leaf plants inside bedroom",
                    "urls": {
                        "raw": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1",
                        "full": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                        "regular": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                        "small": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                        "thumb": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                    },
                    "links": {
                        "self": "https://api.unsplash.com/photos/psrloDbaZc8",
                        "html": "https://unsplash.com/photos/psrloDbaZc8",
                        "download": "https://unsplash.com/photos/psrloDbaZc8/download",
                        "download_location": "https://api.unsplash.com/photos/psrloDbaZc8/download"
                    },
                    "categories": [],
                    "sponsored": false,
                    "sponsored_by": null,
                    "sponsored_impressions_id": null,
                    "likes": 1019,
                    "liked_by_user": false,
                    "current_user_collections": [],
                    "user": {
                        "id": "0e7zgniGMog",
                        "updated_at": "2019-07-03T00:14:59-04:00",
                        "username": "timothybuck",
                        "name": "Timothy Buck",
                        "first_name": "Timothy",
                        "last_name": "Buck",
                        "twitter_username": "TimothyBuckSF",
                        "portfolio_url": "https://timothybuck.me",
                        "bio": "I\'m a product manager, podcaster and writer living in San Francisco, California.",
                        "location": "San Francisco, California",
                        "links": {
                            "self": "https://api.unsplash.com/users/timothybuck",
                            "html": "https://unsplash.com/@timothybuck",
                            "photos": "https://api.unsplash.com/users/timothybuck/photos",
                            "likes": "https://api.unsplash.com/users/timothybuck/likes",
                            "portfolio": "https://api.unsplash.com/users/timothybuck/portfolio",
                            "following": "https://api.unsplash.com/users/timothybuck/following",
                            "followers": "https://api.unsplash.com/users/timothybuck/followers"
                        },
                        "profile_image": {
                            "small": "https://images.unsplash.com/profile-1561069530222-a2986ec58f3d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32",
                            "medium": "https://images.unsplash.com/profile-1561069530222-a2986ec58f3d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64",
                            "large": "https://images.unsplash.com/profile-1561069530222-a2986ec58f3d?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"
                        },
                        "instagram_username": "timothydavidbuck",
                        "total_collections": 1,
                        "total_likes": 0,
                        "total_photos": 7,
                        "accepted_tos": true
                    }
                },
                "preview_photos": [
                    {
                        "id": "psrloDbaZc8",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1499916078039-922301b0eb9b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "d0xjEv-WJQk",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1511527661048-7fe73d85e9a4?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1511527661048-7fe73d85e9a4?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1511527661048-7fe73d85e9a4?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1511527661048-7fe73d85e9a4?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1511527661048-7fe73d85e9a4?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "s2q1_cxLHSE",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1528744598421-b7b93e12df15?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    },
                    {
                        "id": "N6HTCyN50p0",
                        "urls": {
                            "raw": "https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1",
                            "full": "https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
                            "regular": "https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
                            "small": "https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max",
                            "thumb": "https://images.unsplash.com/photo-1523531294919-4bcd7c65e216?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"
                        }
                    }
                ]
            }
        ]
    },
    "views": 460167,
    "downloads": 8171
}';
    }
}