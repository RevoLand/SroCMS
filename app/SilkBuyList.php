<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/*
INSERT INTO SK_SilkBuyList (UserJID, Silk_Type, Silk_Reason, Silk_Offset, Silk_Remain, BuyQuantity, SlipPaper, RegDate)
	VALUES ( @UserJID, 0, 0, @NumSilk, @NumSilk, 1, "User Purchase Silk from VDC-Net2E Billing System", GETDATE() );

INSERT INTO SK_SilkChange_BY_Web (JID, silk_remain, silk_offset, silk_type, reason)
	VALUES ( @UserJID, @SilkRemain+@NumSilk, @NumSilk, 0, 0 );
*/
class SilkBuyList extends Model
{
    const CREATED_AT = 'RegDate';
    const UPDATED_AT = null;

    protected $connection = 'account';
    protected $table = 'SK_SilkBuyList';
    protected $primaryKey = 'BuyNo';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserJID', 'JID');
    }
}
