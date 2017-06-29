<?php

use Illuminate\Database\Seeder;

class BehaviorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 2; $i++) {
            $item = new \App\Models\Behavior();
            $item->fill([
                'type' => 'video.watch',
                'data' => '{"video_id": 1}',
                'lesson_id' => 1,
                'video_id' => 1,
                'duration' => 10,
                'user_id' => $i % 2 == 0 ? 1 : 2,
            ]);
            $item->save();
        }

        for ($i = 0; $i < 2; $i++) {
            $item = new \App\Models\Behavior();
            $item->fill([
                'type' => 'video.drag.begin',
                'data' => '{"video_id": 1}',
                'lesson_id' => 1,
                'video_id' => 1,
                'user_id' => $i % 2 == 0 ? 1 : 2,
            ]);
            $item->save();
        }

        for ($i = 0; $i < 2; $i++) {
            $item = new \App\Models\Behavior();
            $item->fill([
                'type' => 'video.drag.end',
                'data' => '{"video_id": 1}',
                'lesson_id' => 1,
                'video_id' => 1,
                'user_id' => $i % 2 == 0 ? 1 : 2,
            ]);
            $item->save();
        }
    }
}
