<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    // Nếu chỉ có 1 dòng, không cần khóa chính
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'logo',
        'favicon',
        'email',
        'phone',
        'address',
        'map',
        'schema_script',
        'head_script',
        'body_script',
    ];
}
