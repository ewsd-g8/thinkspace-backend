<?php

namespace App\Repositories\Admin;

use App\Models\View;

class ViewRepository
{
    /**
     * @return string
     */

     public function model()
     {
         return View::class;
     }
 
     public function increaseView(array $data)
     {
         $userId = auth()->user()->id;
         $ideaId = $data['idea_id'];
         $view = View::where('user_id', $userId)->where('idea_id', $ideaId)->first();
 
         if (!$view) {
             $view = View::create([
                 'user_id' => $userId,
                 'idea_id' => $ideaId,
             ]);
             return $view;
         }
     }
     
}