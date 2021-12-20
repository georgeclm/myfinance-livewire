<?php

namespace Tests\Feature;

use App\Http\Livewire\Rekening\Create;
use App\Models\Jenis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RekeningTest extends TestCase
{

    public function testUserCanCreateRekening()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $jeniss = Jenis::all();
        Livewire::test(Create::class, ['jeniss' => $jeniss])
            ->set('form.jenis_id', 1)
            ->set('form.nama_akun', 'test pocket')
            ->set('form.saldo_sekarang', 1000000)
            ->call('submit')
            ->assertEmitted('success')
            ->assertEmitted('hideCreatePocket');
    }
    public function testUserCanCreateRekeningWithError()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $jeniss = Jenis::all();
        Livewire::test(Create::class, ['jeniss' => $jeniss])
            ->set('form.jenis_id', 1)
            ->set('form.nama_akun', '')
            ->set('form.saldo_sekarang', 1000000)
            ->call('submit')
            ->assertHasErrors(['form.nama_akun'])
            ->assertNotEmitted('success');
        // $response = $this->actingAs($user)->post('')
    }
}
