<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    use HasFactory;
    protected $table = 'user_cards';

    // 新規獲得フラグ
    private int $is_new = 0;

    const COLLMN_DETAILS =
    [
        'id' => [
            'title' => 'ID',
            'type' => 'int',
        ],
        'user_id' => [
            'title' => 'ユーザーID',
            'type' => 'int',
        ],
        'card_id' => [
            'title' => 'カードID',
            'type' => 'int',
        ],
        'card_reliability' => [
            'title' => 'カード信頼度',
            'type' => 'int',
        ],
        'updated_at' => [
            'title' => '更新度',
            'type' => 'int',
        ],
        'created_at' => [
            'title' => '作成度',
            'type' => 'int',
        ],
    ];

    // is_newフラグを返却する
    public function getIsNew(): int
    {
        return $this->is_new;
    }

    // カードの信頼度を増加する
    public function addReliability(int $add_reliability)
    {
        $this->card_reliability += $add_reliability;
        $this->save();
    }
}
