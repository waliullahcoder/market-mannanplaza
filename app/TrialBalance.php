<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrialBalance extends Model
{
    protected $table = 'view_trial_balance';

    public function coa_setup()
    {
        return $this->belongsTo(CoaSetup::class, 'coa_head_code');
    }

    public function parent_head()
    {
        return $this->belongsTo(CoaSetup::class, 'parent_head_name');
    }
}
