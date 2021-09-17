<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /*
        protected $connnection = 'mysql'; في حال كنت اشتغل على قاعدة بيانات غير mysql

        protected $table = 'stores'; في حال كان صيغة الجدول ليس بصيغة التي تشتغل عليها لارافيل (جمع + احرف صغيرة)

        protected $primaryKey = 'id'; في حال كان الادي غير مسماه بتسمية لارافيل (id)

        protected $keyType = 'int'; في حال كان نوع PK ليس int 

        public $incrementing = true; في حال كان id ليس $incrementing  نضع القيمة false

        public $timestamps = true; في حال كنا لا نريد استخدام timestamps 

        const CREATED_AT = 'created_at'; في حال كنا مسمين هذا الحقل بتسميه اخرى غير تسمية لارافيل (created_at)

        const UPDATED_AT = 'updated_at'; في حال كنا مسمين هذا الحقل بتسميه اخرى غير تسمية لارافيل (update_at)

    */

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function childern()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent',
        ]);
    }
}
