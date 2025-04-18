<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fooo extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $table = 'fooos';
    protected $primaryKey = 'fooo_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['fooo_id'];
    const CREATED_AT = 'fooo_created';
    const UPDATED_AT = 'fooo_updated';

    /**
     * relationshios with other models
     */
    public function bars() {
        return $this->hasMany('App\Models\Bar', 'bar_fooo_id', 'fooo_id');
    }

}
