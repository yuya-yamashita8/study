<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    //use HasFactory;

    public function index()
    {//::コロンはDBファイルの中の（）の機能を使うって意味
        $companies=DB::table('companies')->get();
        return $companies;
    }
}
//::で繋ぐとDBの中の（）テーブルを使うよ！って意味！