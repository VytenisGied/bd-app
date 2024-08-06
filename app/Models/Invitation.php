<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;

class Invitation extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->token = bin2hex(random_bytes(32));
        });
    }

    public function getGenderTextAttribute()
    {
        return $this->gender ? 'Female' : 'Male';
    }

    public function sendEmail(){
        Mail::to($this->email)->send(new InvitationMail($this));
        $this->sent = true;
        $this->save();
    }

    protected $fillable = ['email', 'addressTo', 'gender', 'accepted', 'responded', 'sent'];
}
