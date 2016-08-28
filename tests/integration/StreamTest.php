<?php

use App\Contracts\StandardFetchSetting;
use App\Feed;
use App\Stream;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class StreamTest extends TestCase
{

    protected $user;

    public function setUp() {
        parent::setUp();
        $this->user = User::first();
    }

    public function test_get_feed_stream_only() {
        $collection = Stream::whereItemType(\App\Feed::class)->get();

        foreach ($collection as $item){
            $this->assertInstanceOf(\App\Feed::class, $item->item);
        }
    }

    public function test_get_zero_feed_stream_with_clan_id_0() {

        $user = User::whereClanId(0)->first();

        $streamCount = Stream::whereItemType(Feed::class)
                        ->whereClanId($user->clan_id)
                        ->with('item')
                        ->count();

            
        $this->assertEquals(0, $streamCount);
    }

    public function test_all_steram_are_instance_of_standardFetching() {
        $stream = Stream::all();

        foreach ($stream as $streamItem){
            $this->assertTrue($streamItem->item instanceof StandardFetchSetting);
        }
    }
}
