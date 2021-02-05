<?php

namespace Tests\Feature;

use Database\Factories\RegisterOngFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OngTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $ong = new RegisterOngFactory;
        dd($ong->create());
    }
}
