<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class HouseTest extends TestCase
{
    public function test_route_is_available(): void
    {
        $response = $this->get('/api/houses');

        $data = $this->getData($response);

        $this->assertGreaterThan(0, count($data));
    }

    public function test_data_not_empty(): void
    {
        $response = $this->get('/api/houses');

        $response->assertStatus(200);
    }

    public function test_name_filter_return_only_matching_items(): void
    {
        $queryString = 'iCtOrI';

        $response = $this->get("/api/houses?name=$queryString");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $substring = strtolower($queryString);
            $string = strtolower($item->name);

            $this->assertStringContainsString($substring, $string);
        }
    }

    public function test_maxprice_filter_return_only_less_or_equal_items(): void
    {
        $maxprice = 400000;

        $response = $this->get("/api/houses?maxprice=$maxprice");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $this->assertLessThanOrEqual($maxprice, $item->price);
        }
    }

    public function test_minprice_filter_return_only_greater_or_equal_items(): void
    {
        $minprice = 400000;

        $response = $this->get("/api/houses?minprice=$minprice");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $this->assertGreaterThanOrEqual($minprice, $item->price);
        }
    }

    public function test_bedrooms_filter_return_only_exact_matches(): void
    {
        $queryValue = 3;

        $response = $this->get("/api/houses?bedrooms=$queryValue");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $this->assertEquals($queryValue, $item->bedrooms);
        }
    }

    public function test_bathrooms_filter_return_only_exact_matches(): void
    {
        $queryValue = 3;

        $response = $this->get("/api/houses?bathrooms=$queryValue");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $this->assertEquals($queryValue, $item->bathrooms);
        }
    }

    public function test_storeys_filter_return_only_exact_matches(): void
    {
        $queryValue = 2;

        $response = $this->get("/api/houses?storeys=$queryValue");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $this->assertEquals($queryValue, $item->storeys);
        }
    }

    public function test_garages_filter_return_only_exact_matches(): void
    {
        $queryValue = 2;

        $response = $this->get("/api/houses?garages=$queryValue");
        $data = $this->getData($response);

        $this->assertTrue(!empty($data));

        foreach ($data as $item) {
            $this->assertEquals($queryValue, $item->garages);
        }
    }



    private function getData(TestResponse $response): array
    {
        return json_decode($response->content())->data;
    }
}
