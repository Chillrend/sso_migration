<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrationUser extends Model
{
    use HasFactory;

    protected $table = 'v_username_password_wt_jurusan';
}
