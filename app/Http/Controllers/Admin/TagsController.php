<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function products($id)
    {
        /*
            رجعلي اسم و الايدي الخاص بجدول التاقز كل شيء يخصها من جدول المنتجات
            $tag = Tag::select('id','name')->with('products')->findOrFail($id);
            return $tag;

            اعطيني الاسم من جدول التاقز واعطيني من جدول المنتجات فقط اسمه 
            $tag = Tag::select('id','name')->with('products:name')->findOrFail($id);
            return $tag;

            اعطيني اسم و(الايدي حتى تقدر تجيب علاقة المنتجات) من جدول التاق و الاسم و (الكاتيقوري ايدي حتى تقدر تجيب علاقة الكاتيقوري) من جدول المنتجات مع الاسم من جدول الكاتيقوري
            $tag = Tag::select('id','name')->with('products:name,category_id', 'products.category:id,name')->findOrFail($id);
            return $tag;

            اعطيني من جدول التاق الايدي و الاسم و كل بيانات جدول المنتجات الي على علاقة مع جدول التاق و الاسم و(الايدي لان جدول المنتجات مرتبط بايدي الكاتيغوري حتى يعمل العلاقة)  من جدول الكاتيقوري
            $tag = Tag::select('id','name')->with('products.category:id,name')->findOrFail($id);
            return $tag;
        */
        /*
            return Product::whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$id])
                    ->get();
                    ===
            return $tag->products;

            $tag = Tag::with('products')->findOrFail($id);
            return $tag;
            === 
            return $tag->load('products');
        */

        /* Eager loading Relationships
            كل استعلام على المنتج جيب معه العلاقة تاعت category , store
            return $tag->load('products.category', 'products.store');
            ===
            $tag = Tag::with('products.category', 'products.store')->findOrFail($id);
            return $tag;
        */

        // لترتيب حسب الاسم وهنا يجب ان تضع بعد علاقة المنتجات أقواس
        $tag = Tag::findOrFail($id);
        return $tag->products()->orderBy('name')->get();
        
    }
}
