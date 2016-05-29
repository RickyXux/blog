<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '新浪微博',
                'link_title' => '新浪微博是全中国最主流，最具人气，当前最火爆的微博产品。',
                'link_url' => 'http://www.weibo.com',
                'link_order' => 1
            ],
            [
                'link_name' => '西祠胡同',
                'link_title' => '国内首创的网友“自行开版、自行管理、自行发展”的开放式社区平台,致力于为各地用户提供便捷的生活交流空间与本地生活服务平台。',
                'link_url' => 'http://www.xice.net',
                'link_order' => 2
            ]
        ];
        DB::table('links')->insert($data);
    }
}
