<?php

namespace App\Services;

use App\Http\Resources\Scene\DialogueResource;
use App\Http\Resources\Scene\EventResource;
use App\Http\Resources\Scene\MinigameResource;
use App\Models\Dialogue;
use App\Models\Event;
use App\Models\Minigame;
use App\Models\Scene;
use Illuminate\Validation\ValidationException;

class SceneService {

    public function getScene($sceneId) {
        return Scene::find($sceneId);
    }

    public function getSceneDetail($sceneId){
        $scene = Scene::find($sceneId);
        
        $scene_header = [
            'scene_id' => $scene->id,
            'background' => $scene->background,
            'is_start_scene' => $scene->is_start_scene,
            'is_end_scene' => $scene->is_end_scene,
            'activity_id' => $scene->activity_id,
            'next_scene_id' => $scene->next_scene_id,
            'sceneable_type' => $scene->sceneable_type
        ];
        
        switch($scene->sceneable_type){
            case Dialogue::class:
                $scene_detail = $this->getDialogueScene($scene->sceneable_id);
                $data = new DialogueResource((object) array_merge($scene_header, $scene_detail->toArray()));
                break;
            case Event::class:
                $scene_detail = $this->getEventScene($scene->sceneable_id);
                $data = new EventResource((object) array_merge($scene_header, $scene_detail->toArray()));
                break;
            case Minigame::class:
                $scene_detail = $this->getMinigameScene($scene->sceneable_id);
                $data = new MinigameResource((object) array_merge($scene_header, $scene_detail->toArray()));
                break;
            default:
                throw ValidationException::withMessages([
                    'scene type' => 'Invalid scene type',
                ]);
        }
        
        return $data;
    }

    private function getDialogueScene(string $sceneableId){
        $dialogue = Dialogue::findOrFail($sceneableId);
        $dialogue->options = $dialogue->dialogueOptions()->get();

        return $dialogue;
    }

    private function getMinigameScene(string $sceneableId){
        return Minigame::findOrFail($sceneableId);
    }

    private function getEventScene(string $sceneableId){
        return Event::findOrFail($sceneableId);
    }
}
