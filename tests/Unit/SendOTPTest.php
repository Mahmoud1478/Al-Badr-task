<?php

namespace Tests\Unit;

use App\Mail\OTPMail;
use App\Models\Client;
use App\Models\OTP;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendOTPTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Client|\Closure|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    private Client $client;
    /**
     * @var OTP|\Illuminate\Database\Eloquent\Model
     */
    private  OTP $otp;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateUsing();
        $this->client = Client::factory(1)->create()->first();
        $this->otp = $this->client->otp()->create();
    }

    /** @test */
    public function otp_queued()
    {
        Mail::fake();
        $this->client->send_otp($this->otp);
        Mail::assertQueued(OTPMail::class ,function (OTPMail $mail){
            return $this->client->is($mail->client) && $this->otp->is($mail->otp);
        });
    }
    /** @test */
   public function otp_checked()
   {
       $this->assertTrue($this->client->otp->check($this->otp->code));
   }
   /** @test */
    public function email_verified()
    {
        $this->client->markEmailAsVerified();
        $this->assertTrue($this->client->hasVerifiedEmail());
    }
}
