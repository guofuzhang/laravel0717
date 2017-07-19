<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $table="role";
   protected $primaryKey="role_id";
   protected $fillable=['role_name','role_auth_ids','role_auth_ac'];
}
