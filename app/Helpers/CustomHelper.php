<?php 
    function genrateUniqueId()
    {
        return str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
    }

    function getNextBinaryParent($user_id) {
        $queue = [$user_id];
    
        while (!empty($queue)) {
            $current = array_shift($queue);
    
            $children = User::where('parent_id', $current)->get();
            if ($children->count() < 2) {
                return [
                    'id' => $current,
                    'position' => ($children->count() == 0) ? 'left' : 'right'
                ];
            }
    
            foreach ($children as $child) {
                $queue[] = $child->id;
            }
        }
    
        return null;
    }
    
?>